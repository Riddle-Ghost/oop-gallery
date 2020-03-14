<?php

namespace App\components;

class AuthReg {

    private $db;
    private $auth;
    protected $query;
    protected $mail;

    public function __construct(\App\lib\Query $query, \App\lib\Mail $mail) {

        $this->db = \App\lib\Db::getInstance();
        $this->auth = new \Delight\Auth\Auth($this->db);
        $this->query = $query;
        $this->mail = $mail;
        

    }

    public function register($data) {

        if ( $data['password'] !== $data['password_confirm'] ) {

            flash()->error(['Пароли не совпадают!']);
            return 0;
        }
        if ( !$data['agree'] ) {

            flash()->error(['Подтвердите правила сайта!']);
            return 0;
        }

        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {

                $this->mail->sendConfirmEmail($selector, $token);

                flash()->success("Вам на почту отправлено письмо. Пожалуйста перейдите по ссылке, указанной в письме, чтобы закончить регистрацию! <a href='/register/confirm/$selector/$token'>Эта ссылка</a>");
            });
            
            flash()->success("Успешно зарегестрирован пользователь с ID $userId");
        }
        catch (\Delight\Auth\InvalidEmailException $e) {

            flash()->error(['Неправильный эмейл!']);
            return 0;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            
            flash()->error(['Неправильный пароль!']);
            return 0;
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            
            flash()->error(['Такой пользьзователь уже существует!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов! Отдохните']);
            return 0;
        }
    }
    public function confirmEmail($selector, $token) {

        try {
            $this->auth->confirmEmail($selector, $token);
        
            flash()->success("Эмейл успешно подтвержден! Используйте этот эмейл, чтобы войти на сайт");

            return 1;
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            
            flash()->error(['Неверный токен!']);
            return 0;
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            
            flash()->error(['Токен истек!']);
            return 0;
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            
            flash()->error(['Такой пользьзователь уже существует!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов!']);
            return 0;
        }
    }
    public function resendConfirmEmail($post) {

        try {
            $this->auth->resendConfirmationForEmail($post['email'], function ($selector, $token) {
                
                $this->mail->sendConfirmEmail($selector, $token);

                flash()->success("Вам на почту отправлено письмо. Пожалуйста перейдите по ссылке, указанной в письме, чтобы закончить регистрацию! <a href='/register/confirm/$selector/$token'>Эта ссылка</a>");
            });
        }
        catch (\Delight\Auth\ConfirmationRequestNotFound $e) {
            
            flash()->error(['Нет запросов подтверждения, которые должны быть переотправлены!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов! Попробуйте позже']);
            return 0;
        }
    }
    public function login($post) {

        if ($post['remember'] == 1) {

            $rememberDuration = (int) (60 * 60 * 24);
        }
        else {
            // do not keep logged in after session ends
            $rememberDuration = null;
        }
        try {
            $this->auth->login($post['email'], $post['password'], $rememberDuration);

            return 1;
        
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            
            flash()->error(['Неверный эмейл!']);
            return 0;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            
            flash()->error(['Неверный пароль!']);
            return 0;
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            
            flash()->error(['Эмейл не подтвержден!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов!']);
            return 0;
        }
    }
    public function logOut() {

        $this->auth->logOut();
    }
    public function getStatus() {

        $status['isLogged'] = $this->auth->check();
        
        if ( $status['isLogged'] ) {

            $status['id'] = $this->auth->getUserId();
            $status['username'] = $this->auth->getUsername();
            $status['usernameTrim'] = substr($status['username'], 0, 8) . "...";
            $status['email'] = $this->auth->getEmail();
            $status['isNormal'] = $this->auth->isNormal();
            $status['isAdmin'] = $this->auth->hasRole(\Delight\Auth\Role::ADMIN);
            
        }
        
        return $status;
        

    }
    public function passwordReset($post) {

        try {
            $this->auth->forgotPassword($post['email'], function ($selector, $token) {

                $this->mail->sendResetPassword($selector, $token);

                flash()->success("Вам на почту отправлено письмо. Пожалуйста перейдите по ссылке, указанной в письме, чтобы сменить пароль! <a href='/password-reset/$selector/$token'>Эта ссылка</a>");
            });
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            
            flash()->error(['Неверный эмейл!']);
            return 0;
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            
            flash()->error(['Эмейл не подтвержден!']);
            return 0;
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            
            flash()->error(['Сброс пароля отключен!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов!']);
            return 0;
        }
    }
    public function confirmPasswordReset($selector, $token) {

        try {
            $this->auth->canResetPasswordOrThrow($selector, $token);


            flash()->success("Введите новый пароль!");
        
            return 1;
        
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            
            flash()->error(['Неверный токен!']);
            return 0;
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            
            flash()->error(['Токен уже испортился!']);
            return 0;
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            
            flash()->error(['Нельзя сменить пароль!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов!']);
            return 0;
        }
    }
    public function setNewPassword($selector, $token, $post) {

        try {
            $this->auth->resetPassword($selector, $token, $post['password']);
        
            flash()->success("Пароль успешно изменен!");
        
            return 1;
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            
            flash()->error(['Неверный токен!']);
            return 0;
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            
            flash()->error(['Токен просрочен!']);
            return 0;
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
            
            flash()->error(['Нельзя сменить пароль!']);
            return 0;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            
            flash()->error(['Неправильный пароль!']);
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error(['Слишком много запросов!']);
            return 0;
        }
    }
    public function adminRegisterUser() {

        try {
            $userId = $this->auth->admin()->createUser($_POST['email'], $_POST['password'], $_POST['username']);
        
            flash()->success("Успешно зарегестрирован пользователь с ID $userId");

            return 1;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            
            flash()->error(['Неправильный эмейл!']);
            return 0;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            
            flash()->error(['Неправильный пароль!']);
            return 0;
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            
            flash()->error(['Такой пользьзователь уже существует!']);
            return 0;
        }

        $this->query->update('users', ['roles_mask', 'status'], 'email', $_POST['email'], ['roles_mask' => $_POST['role'], 'status' => $_POST['status'] ]);

    }
    public function adminShowUserInfo($id) {

        $user = $this->query->select(['id', 'username', 'email'], 'users', [], 'id=:id', 'id', $id);

        return $user[0];
    }
    public function adminChangeUserInfo($id) {

        $_POST['username'] = htmlentities( trim( $_POST['username'] ) );
        
        if ( strlen( $_POST['username']) < 4 ) {

            flash()->error(['Введите имя!']);
            return 0;
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            
            flash()->error(['Неправильный эмейл!']);
            return 0;
        }

        $this->query->update('users', ['username', 'email'], 'id', $id, ['username' => $_POST['username'], 'email' => $_POST['email'] ]);

        flash()->success("Обновлены данные пользователя $id");

        if ( !empty( $_POST['password'] ) ) {

            $this->adminChangeUserPass($id);
        }
    }
    public function adminChangeUserPass($id) {

        try {
            $this->auth->admin()->changePasswordForUserById($id, $_POST['password']);

            flash()->success("Изменен пароль пользователю $id");
            return 1;
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            
            flash()->error("Нет пользователя с ID $id");

            return 0;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            
            flash()->error("Неверный формат пароля");

            return 0;
        }
    }
    public function adminDeleteUser($id) {

        try {
            $this->auth->admin()->deleteUserById($id);

            flash()->success("Удален пользователь с ID $id");

            return 1;
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            
            flash()->error("Нет пользователя с ID $id");

            return 0;
        }
    }
    public function adminAddRoleAdmin($id) {

        try {
            $this->auth->admin()->addRoleForUserById($id, \Delight\Auth\Role::ADMIN);

            flash()->success("Новый админ, пользователь $id");
        }
        catch (\Delight\Auth\UnknownIdException $e) {

            flash()->error("Нет пользователя с ID $id");

            return 0;
        }
    }
    public function adminRemoveRoleAdmin($id) {

        try {
            $this->auth->admin()->removeRoleForUserById($id, \Delight\Auth\Role::ADMIN);

            flash()->success("Минус один админ, пользователь $id");
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            
            flash()->error("Нет пользователя с ID $id");

            return 0;
        }
    }
    public function adminCheckRoleAdmin($id) {

        try {
            if ($this->auth->admin()->doesUserHaveRole($id, \Delight\Auth\Role::ADMIN)) {
                
                return 1;
            }
            else {
                
                return 0;
            }
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            
            flash()->error("Нет пользователя с ID $id");

            return 0;
        }
    }
    public function adminAddBan($id) {

        $this->query->update('users', ['status'], 'id', $id, ['status' => '1']);

        flash()->success("Забанен пользователь $id");
    }
    public function adminRemoveBan($id) {

        $this->query->update('users', ['status'], 'id', $id, ['status' => '0']);

        flash()->success("Разбанен пользователь $id");
    }
    public function adminLoginAsUser($id) {

        try {
            $this->auth->admin()->logInAsUserById($id);

            flash()->success("Вы вошли как пользователь $id");
            return 1;
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            
            flash()->error("Нет пользователя с ID $id");

            return 0;
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            
            flash()->error("Эмейл не верифицирован");

            return 0;
        }
    }
}


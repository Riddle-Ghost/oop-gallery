<?php

namespace App\components;

class EditProfile {

    protected $db;
    protected $auth;
    protected $query;

    public function __construct(\App\lib\Query $query) {

        $this->db = \App\lib\Db::getInstance();
        $this->auth = new \Delight\Auth\Auth($this->db);
        $this->query = $query;
    }

    public function changeProfileData($post, $status) {

        $post['username'] = htmlentities( trim( $post['username'] ) );

        if ( $post['username'] !== $status['username'] ) {

            if ( strlen( $post['username'] ) < 4 ) {

                flash()->error(['Слишком короткое имя!']);
                return 0;
            }

            $this->query->update('users', ['username'], 'id', $status['id'], ['username' => $post['username'] ]);

            $_SESSION['auth_username'] = $post['username'];

            flash()->success("Имя изменено!");

        }

        if ( $post['email'] !== $status['email'] ) {

            try {
                if ($this->auth->reconfirmPassword($post['password'])) {
                    $this->auth->changeEmail($post['email'], function ($selector, $token) {
                        
                        flash()->success("Отправлен селектор <br>$selector<br> и токен <br>$token<br> на указанный эмейл. Ссылка <a href='/register/confirm/$selector/$token'>Перейти</a>");
                    });
            
                    flash()->success("На ваш новый эмейл отправлено письмо. Подтвердите новый эмейл");

                    return 1;
                }
                else {
                    flash()->error('Неверные данные');
                    
                }
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
                
                flash()->error('Неправильный эмейл');
                return 0;
            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
                
                flash()->error('Данный эмейл уже зарегестрирован');
                return 0;
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
                
                flash()->error('Эмейл не подтвержден');
                return 0;
            }
            catch (\Delight\Auth\NotLoggedInException $e) {
                
                flash()->error('Войдите для продолжения');
                return 0;
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                
                flash()->error('Слишком много запросов');
                return 0;
            }
        }
    }
    public function changeProfilePassword($post) {

        try {
            $this->auth->changePassword($post['oldPassword'], $post['newPassword']);
        
            flash()->success("Пароль успешно изменен");
            
            return 1;
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            
            flash()->error('Сначала войдите');
            return 0;
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            
            flash()->error('Неправильный пароль');
            return 0;
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            
            flash()->error('Слишком много запросов');
            return 0;
        }
    }
}
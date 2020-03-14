<?php

namespace App\lib;

class Mail {

    public function send(array $to, $title, $body) {

        $config = require '../app/config.php';
        $config = $config['smtp'];

        $transport = (new \Swift_SmtpTransport( $config['host'], $config['port'], $config['crypt'] ) )
        ->setUsername($config['login'])
        ->setPassword($config['password']);

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message($title))
        ->setFrom($config['from'])
        ->setTo($to)
        ->setBody($body);

        return $mailer->send($message);
    }
    public function sendConfirmEmail($selector, $token) {

        $this->send([ $_POST['email'] ],
        'Подтверждение регистрации на сайте',
        "Спасибо за регистрацию. Чтобы активировать аккаунт, пожалуйста, перейдите по ссылке ПОПРАВИТЬ ПУТЬ <a href='http://oop-gallery/register/confirm/$selector/$token'>Перейти</a>"
        );
    }
    public function sendResetPassword($selector, $token) {

        $this->send([ $_POST['email'] ],
        'Сброс пароля',
        "Чтобы переопределить пароль, перейдите по ссылке ПОПРАВИТЬ ПУТЬ <a href='http://oop-gallery/password-reset/$selector/$token'>Перейти</a>"
        );
    }
}
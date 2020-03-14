<?php

namespace App\controllers;

class AuthController extends Controller {


    public function login() {

        if ( $this->status['isLogged'] ) {

            header('Location: /');
            exit;
        }
        if ( !empty( $_POST )) {

            if ( $this->authreg->login($_POST) ) {

                header ('Location: /');
                exit;
            }
            else {

                header ('Location: /login');
                exit;
            }
        }

        echo $this->view->render('auth/login', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function logOut() {

        if ( $this->status['isLogged'] ) {

            $this->authreg->logOut();
        }

        header('Location: /');
    }
    public function register() {

        if ( $this->status['isLogged'] ) {

            header('Location: /');
            exit;
        }
        if ( !empty( $_POST ) ) {

            $this->authreg->register($_POST);

            header ('Location: /register');
            exit;
        }

        echo $this->view->render('auth/register', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function confirmEmail($selector, $token) {

        if ( !empty( $token ) ) {

            $this->authreg->confirmEmail($selector, $token);

        }

        if ( $this->status['isLogged'] ) {

            header('Location: /profile');
        } else {

            header ('Location: /login');
        }
        
    }
    public function resendConfirmEmail() {

        if ( $this->status['isLogged'] ) {

            header('Location: /');
            exit;
        }
        if ( !empty( $_POST ) ) {

            $this->authreg->resendConfirmEmail($_POST);
            
            header('Location: /register/resend-confirm');
            exit;
        }

        echo $this->view->render('auth/resendConfirmEmail', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function passwordReset() {

        if ( $this->status['isLogged'] ) {

            header('Location: /');
            exit;
        }
        if ( !empty( $_POST ) ) {

            $this->authreg->passwordReset($_POST);

            header('Location: /password-reset');
            exit;
        }
        echo $this->view->render('auth/passwordReset', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function confirmPasswordReset($selector, $token) {

        if ( $this->status['isLogged'] ) {

            header('Location: /');
            exit;
        }
        if ($token) {

            if ( !empty ($_POST ) ) {

                $this->authreg->setNewPassword($selector, $token, $_POST);

                header('Location: /login');
                exit;
            }
            if ( $this->authreg->confirmPasswordReset($selector, $token) ) {

                echo $this->view->render('auth/setNewPassword', ['status' => $this->status, 'categories' => $this->categories, 'selector' => $selector, 'token' => $token]);
            }
        }

        header('Location: /password-reset');
        exit;
    }
}
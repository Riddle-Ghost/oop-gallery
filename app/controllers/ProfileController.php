<?php

namespace App\controllers;


class ProfileController extends Controller {

    protected $editprofile;

    public function __construct(\League\Plates\Engine $view, \App\components\AuthReg $authreg, \App\components\Images $images, \App\components\Paginator $paginator, \App\components\Categories $categs, \App\components\EditProfile $editprofile) {

        parent::__construct($view, $authreg, $images, $paginator, $categs);

        $this->editprofile = $editprofile;
    }

    public function profileInfo() {

        if ( !$this->status['isLogged'] ) {

            header("Location: /login");
            exit;
        }

        if ( !empty( $_POST) ) {

            $this->editprofile->changeProfileData($_POST, $this->status);

            header('Location: /profile-info');
            exit;
        }

        echo $this->view->render('profile/profileInfo', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function profileSecurity() {

        if ( !$this->status['isLogged'] ) {

            header("Location: /login");
            exit;
        }
        if ( !empty( $_POST) ) {

            $this->editprofile->changeProfilePassword($_POST);

            header('Location: /profile-security');
            exit;
        }

        echo $this->view->render('profile/profileSecurity', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function profilePhotos($page = '') {

        if ( !$this->status['isLogged'] ) {

            header("Location: /login");
            exit;
        }
        if(!$page) $page = 1;

        $paginate = $this->paginator->main($page, '8', 'profile', $this->status['id']);

        $photos = $this->images->getFromOneUser($this->status['id'], $page, '8');
        
        echo $this->view->render('profile/profilePhotos', ['status' => $this->status, 'categories' => $this->categories, 'photos' => $photos, 'paginator' => $paginate]);
    }
}
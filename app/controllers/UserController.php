<?php

namespace App\controllers;

class UserController extends Controller {


    public function main($id) {

        $photos = $this->images->getFromOneUser($id);

        echo $this->view->render('user', ['status' => $this->status, 'categories' => $this->categories, 'photos' => $photos]);
    }

}
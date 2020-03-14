<?php

namespace App\controllers;

class HomeController extends Controller {


    public function main($page = '') {

        if(!$page) $page = 1;

        $paginate = $this->paginator->main($page, '8', 'home');

        $photos = $this->images->getAllPictures($page, '8');

        echo $this->view->render('home', ['status' => $this->status, 'categories' => $this->categories, 'photos' => $photos, 'paginator' => $paginate]);
    }
}
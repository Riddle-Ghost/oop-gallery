<?php

namespace App\controllers;

class UploadController extends Controller {

    protected $query;

    public function __construct(\League\Plates\Engine $view, \App\components\AuthReg $authreg, \App\components\Images $images, \App\components\Paginator $paginator, \App\components\Categories $categs, \App\lib\Query $query) {

        parent::__construct($view, $authreg, $images, $paginator, $categs);

        $this->query = $query;
    }

    public function main() {

        if ( !$this->status['isLogged'] ) {

            header("Location: /");
            exit;
        }
        if ( !empty( $_POST) ) {

            $this->images->uploadPicture($this->status['id']);


            header('Location: /upload');
            exit;
        }

        echo $this->view->render('upload', ['status' => $this->status, 'categories' => $this->categories]);
    }

}
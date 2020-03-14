<?php

namespace App\controllers;

use League\Plates\Engine;

abstract class Controller {

    protected $view;
    protected $authreg;
    protected $images;
    protected $paginator;
    protected $status;
    protected $categs;
    protected $categories;

    public function __construct(Engine $view, \App\components\AuthReg $authreg, \App\components\Images $images, \App\components\Paginator $paginator, \App\components\Categories $categs)
    {
        
        $this->view = $view;
        $this->authreg = $authreg;
        $this->images = $images;
        $this->paginator = $paginator;
        $this->categs = $categs;
        $this->status = $this->authreg->getStatus();
        $this->categories = $this->categs->getAllCategories();
    }

}
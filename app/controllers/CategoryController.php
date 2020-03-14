<?php

namespace App\controllers;

class CategoryController extends Controller {


    public function main() {

        $photosCategories = $this->images->getFromCategories();

        echo $this->view->render('category/category', ['status' => $this->status, 'categories' => $this->categories, 'photosCategories' => $photosCategories]);
    }
    public function oneCategory($id, $page='') {

        if(!$page) $page = 1;

        $paginate = $this->paginator->main($page, '8', 'oneCategory', $id);

        $photos = $this->images->getFromOneCategory($id, $page, '8');

        echo $this->view->render('category/oneCategory', ['status' => $this->status, 'categories' => $this->categories, 'photos' => $photos, 'paginator' => $paginate]);
    }

}
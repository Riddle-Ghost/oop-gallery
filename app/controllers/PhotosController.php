<?php

namespace App\controllers;

class PhotosController extends Controller {


    public function photos() {


        echo $this->view->render('photos', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function showPhoto($id) {

        $photo = $this->images->getSingle($id);
        //Ищем другие фото юзера, получаем 4 и передаем айди уже загруженной, чтобы не вывело ее повторно
        $photos = $this->images->getRandom($photo['user_id'], '4', $id);

        echo $this->view->render('single/photo', ['status' => $this->status, 'categories' => $this->categories, 'photo' => $photo, 'photos' => $photos]);
    }
    public function editPhoto($id) {
        
        $photo = $this->images->getSingle($id);

        if ( $photo['user_id'] !== $this->status['id'] ) {

            flash()->error(['Нет прав для редактирования!']);
            header('Location: /');
            exit;
        }
        if ( !empty( $_POST ) ) {

            $this->images->editSingle($id, $_POST);

            header("Location: /edit-photo/$id");
            exit;
        }

        echo $this->view->render('single/photoEdit', ['status' => $this->status, 'categories' => $this->categories, 'photo' => $photo]);
    }
    public function deletePhoto($id) {

        $photo = $this->images->getSingle($id);

        if ( $photo['user_id'] !== $this->status['id'] ) {

            flash()->error(['Нет прав для удаления!']);
            header('Location: /');
            exit;
        }

        $this->images->deleteSingle($id, $photo['image']);

        header("Location: /profile");
    }

}
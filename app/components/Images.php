<?php

namespace App\components;

class Images {

    protected $files;
    protected $query;
    protected $manager;
    protected $categories;

    public function __construct(\App\lib\Files $files, \App\lib\Query $query, \Intervention\Image\ImageManager $manager, Categories $categories)
    {
        $this->files = $files;
        $this->query = $query;
        $this->manager = $manager;
        $this->categories = $categories;
    }

    public function uploadPicture($user_id) {
        
        $extension = pathinfo($_FILES['picture']['name'])['extension'];
        $extensions = ['gif', 'jpg', 'jpeg', 'png'];

        if ( in_array($extension , $extensions ) ) {

            $img = $this->files->uploadFile('picture');
            $path = $this->files->getPath('uploads/' . $img['name'] );

            $imgResize = $this->manager->make($path);
            $height = $imgResize->height();
            $width = $imgResize->width();
            if ( $height > 760 || $width > 1280) {

                $imgResize->resize(1280, 760);
                $height = '760';
                $width = '1280';
            }
            
            $imgResize->save($path);

        } else {

            flash()->error(['Неверный формат картинки!']);
            return 0;
        }

        $_POST['name'] = htmlentities( trim( $_POST['name'] ) );
        $_POST['description'] = htmlentities( trim( $_POST['description'] ) );
        $_POST['category'] =  (int) $_POST['category'];

        if ( empty( $_POST['name'] ) ) {

            $_POST['name'] = 'JustPicture';
        }

        $this->query->insert('photos', ['name', 'description', 'image', 'dimensions', 'category_id', 'user_id'], 
        [
            'name' => $_POST['name'],
            'description' => $_POST['description'], 
            'image' => $img['name'],
            'dimensions' => "{$width}x{$height}",
            'category_id' => $_POST['category'],
            'user_id' => $user_id
        ]);

        flash()->success(['Картинка успешно загружена!']);
        
    }
    public function getAllPictures($page, $itemsPerPage) {

        $offset = ($itemsPerPage * $page) - $itemsPerPage;

        $data = $this->query->selectJoin(['photos.*', 'users.username', 'categories.title'], 'photos', ['LEFT', 'users', 'photos.user_id = users.id'], ['LEFT', 'categories', 'photos.category_id = categories.id'], 'photos.date DESC', '', '', [], $itemsPerPage, $offset);

        $data = $this->dateFormat($data);
        $data = $this->trimNames($data);

        return $data;
    }
    public function getFromCategories() {

        //Получаем все категории
        $data = $this->categories->getAllCategories();

        //На каждую категорию получаем картинки
        $count = count($data);
        $i=0;
        $result = [];
        
        while ($i<$count) {

            $result[$i] = $this->query->selectJoin(['photos.*', 'users.username', 'categories.title'], 'photos', ['LEFT', 'users', 'photos.user_id = users.id'], ['LEFT', 'categories', 'photos.category_id = categories.id'],'photos.date DESC', 'categories.id = :categories', '', ['categories' => $data[$i]['id'] ], '4');

            $result[$i] = $this->dateFormat($result[$i]);
            $result[$i] = $this->trimNames($result[$i], 'title');
            
            $i++;
        }
        
        return $result;
    }
    public function getFromOneCategory($id, $page='1', $itemsPerPage='300') {

        $offset = ($itemsPerPage * $page) - $itemsPerPage;

        $data = $this->query->selectJoin(['photos.*', 'users.username', 'categories.title'], 'photos', ['LEFT', 'users', 'photos.user_id = users.id'], ['LEFT', 'categories', 'photos.category_id = categories.id'], 'photos.date DESC', 'photos.category_id = :categorie', '', ['categorie' => $id], $itemsPerPage, $offset);

        $data = $this->dateFormat($data);
        $data = $this->trimNames($data);

        return $data;

    }
    public function getFromOneUser($id, $page='1', $itemsPerPage='300') {

        $offset = ($itemsPerPage * $page) - $itemsPerPage;

        $data = $this->query->selectJoin(['photos.*', 'users.username', 'categories.title'], 'photos', ['LEFT', 'users', 'photos.user_id = users.id'], ['LEFT', 'categories', 'photos.category_id = categories.id'], 'photos.date DESC', 'photos.user_id = :user', '', ['user' => $id], $itemsPerPage, $offset);

        $data = $this->dateFormat($data);
        $data = $this->trimNames($data);

        return $data;
        // SELECT photos.*, users.username, categories.title
        // FROM photos
        // LEFT JOIN users
        //     on photos.user_id = users.id
        // LEFT JOIN categories
        //     on photos.category_id = categories.id
        // WHERE photos.user_id = 4
        // ORDER BY photos.date DESC
    }
    public function getSingle($id) {

        $data = $this->query->selectJoin(['photos.*', 'users.username', 'categories.title'], 'photos', ['LEFT', 'users', 'photos.user_id = users.id'], ['LEFT', 'categories', 'photos.category_id = categories.id'], 'photos.date DESC', 'photos.id = :id', '', ['id' => $id] );

        $data = $this->dateFormat($data);

        $data = $data['0'];
        return $data;
    }
    public function getRandom($id, $amount, $id2='') {

        $data = $this->query->selectJoin(['photos.*', 'categories.title'], 'photos', ['LEFT', 'categories', 'photos.category_id = categories.id'], [], 'RAND()', 'photos.user_id = :user', 'photos.id <> :id2', ['user' => $id, 'id2' => $id2], $amount);

        $data = $this->dateFormat($data);
        $data = $this->trimNames($data);

        return $data;
    }
    public function editSingle($id, $post) {

        $post['name'] = htmlentities( trim($post['name']) );
        $post['description'] = htmlentities( trim($post['description']) );
        $post['category_id'] = (int) $post['category_id'];

        $this->query->update('photos', ['name', 'description', 'category_id'], 'id', $id, ['name' => $post['name'], 'description' => $post['description'], 'category_id' => $post['category_id'] ]);

        flash()->success(['Данные обновлены!']);
    }
    public function deleteSingle($id, $name) {

        $this->query->delete('photos', $id);

        $this->files->deleteFile('uploads/' . $name);

        flash()->success(['Картинка удалена!']);
    }
    public function dateFormat($data) {

        $count = count($data);
        $i=0;
        while ($i<$count) {

            $timestamp = strtotime( $data[$i]['date'] );
            $dateNew = date('d-m-Y', $timestamp);
            $data[$i]['date'] = $dateNew;
            $i++;
        }
        
        return $data;
    }
    public function trimNames($data, $exclude='') {

        $count = count($data);
        $i=0;
        while ($i<$count) {

            if ( $exclude !== 'title' ) {

                if( mb_strlen($data[$i]['title']) > 8 ) {

                    $data[$i]['title'] = mb_substr($data[$i]['title'], 0, 8) . "..";
                }
            }
            
            if( mb_strlen($data[$i]['name']) > 11 ) {
    
                $data[$i]['name'] = mb_substr($data[$i]['name'], 0, 11) . "..";
            }
            if( mb_strlen($data[$i]['description']) > 8 ) {
    
                $data[$i]['description'] = mb_substr($data[$i]['description'], 0, 8) . "..";
            }
            if( mb_strlen($data[$i]['username']) > 12 ) {
    
                $data[$i]['username'] = mb_substr($data[$i]['username'], 0, 12) . "..";
            }
            $i++;
        }

        return $data;
    }
}
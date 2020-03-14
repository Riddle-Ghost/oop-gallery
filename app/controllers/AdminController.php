<?php

namespace App\controllers;

class AdminController extends Controller {

    protected $query;

    public function __construct(\League\Plates\Engine $view, \App\components\AuthReg $authreg, \App\components\Images $images, \App\components\Paginator $paginator, \App\components\Categories $categs, \App\lib\Query $query) {

        parent::__construct($view, $authreg, $images, $paginator, $categs);

        $this->query = $query;
    }


    public function main() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }

        echo $this->view->render('admin/main', ['name' => 'Jonathan']);
    }

    public function photosMain() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }

        $photos = $this->images->getAllPictures(1, 300);

        echo $this->view->render('admin/photos/main', ['status' => $this->status, 'photos' => $photos]);

    }
    public function photosCreate() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }
        if( !empty($_POST) ) {

            if (!$this->images->uploadPicture($this->status['id']) ) {

                header('Location: /admin/photos/create');
                exit;
            }

            header('Location: /admin/photos');
            exit;
        }

        echo $this->view->render('admin/photos/create', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function photosEdit($id) {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }
        if( !empty($_POST) ) {

            if( $this->status['isAdmin'] ) {

                $this->images->editSingle($id, $_POST);

            }   else {

                flash()->error("А ты правда Админ ?");
            }

            header('Location: /admin/photos');
            exit;
        }
        $photo = $this->images->getSingle($id);

        echo $this->view->render('admin/photos/edit', ['status' => $this->status, 'categories' => $this->categories, 'photo' => $photo]);
    }
    public function photosDelete($id) {

        if( $this->status['isAdmin'] ) {

            $photo = $this->images->getSingle($id);

            $this->images->deleteSingle($id, $photo['name']);

        }   else {

            flash()->error("А ты правда Админ ?");
        }

        header('Location: /admin/photos');
    }
    

    public function categoriesMain() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }

        echo $this->view->render('admin/categories/main', ['status' => $this->status, 'categories' => $this->categories]);
    }
    public function categoriesCreate() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }

        if(!empty($_POST)) {

            if( $this->status['isAdmin'] ) {

                if ( $this->categs->newCategory($_POST['title']) ) {

                    header("Location: /admin/categories");
                    exit;
    
                }   else {
    
                    header("Location: /admin/categories/create");
                    exit;
                }
    
            }   else {
    
                flash()->error("А ты правда Админ ?");
                header("Location: /admin/categories/create");
            }
            
        }
        echo $this->view->render('admin/categories/create', ['status' => $this->status]);
    }
    public function categoriesEdit($id) {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }
        if ( !empty($_POST) ) {

            if( $this->status['isAdmin'] ) {

                if ( $this->categs->editCategory($id, $_POST['title']) ) {

                    header("Location: /admin/categories");
                    exit;
    
                }   else {
    
                    header("Location: /admin/categories/edit/$id");
                    exit;
                }
    
            }   else {
    
                flash()->error("А ты правда Админ ?");
                header("Location: /admin/categories");
                exit;
            }
        }

        $category = $this->categs->getSingleCat($id);

        echo $this->view->render('admin/categories/edit', ['status' => $this->status,'category' => $category]);
    }
    public function categoriesDelete($id) {

        if( $this->status['isAdmin'] ) {

            $this->categs->deleteCategory($id);

        }   else {

            flash()->error("А ты правда Админ ?");
        }
        
        header("Location: /admin/categories");
    }


    public function usersMain() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }
        $users = $this->query->select(['*'], 'users', ['id DESC']);

        echo $this->view->render('admin/users/main', ['status' => $this->status, 'users' => $users]);
    }
    public function usersCreate() {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }

        if ( !empty( $_POST ) ) {

            if( $this->status['isAdmin'] ) {

                $this->authreg->adminRegister();
    
            }   else {
    
                flash()->error("А ты правда Админ ?");
            }

            header("Location: /admin/users");
            exit;
        }

        echo $this->view->render('admin/users/create', ['status' => $this->status]);
    }
    public function usersEdit($id) {

        if(!$this->status['isLogged']) {

            header('Location: /');
            exit;
        }
        if( !empty($_POST) ) {

            if( $this->status['isAdmin'] ) {

                $this->authreg->adminChangeUserInfo($id);
    
            }   else {
    
                flash()->error("А ты правда Админ ?");
            }

            header("Location: /admin/users");
            exit;
        }

        $user = $this->authreg->adminShowUserInfo($id);

        echo $this->view->render('admin/users/edit', ['status' => $this->status, 'user' => $user]);
    }
    public function usersBan($id, $status) {

        if( $this->status['isAdmin'] ) {

            if ($status) {

                $this->authreg->adminRemoveBan($id);
    
            }   else {
    
                $this->authreg->adminAddBan($id);
            }

        }   else {

            flash()->error("А ты правда Админ ?");
        }
        
        header("Location: /admin/users");
    }
    public function usersRole($id, $role) {

        if( $this->status['isAdmin'] ) {

            if ($role) {

                $this->authreg->adminRemoveRoleAdmin($id);
    
            }   else {
    
                $this->authreg->adminAddRoleAdmin($id);
            }

        }   else {

            flash()->error("А ты правда Админ ?");
        }
        
        header("Location: /admin/users");
    }
    public function usersDelete($id) {

        if( $this->status['isAdmin'] ) {

            $this->authreg->adminDeleteUser($id);

        }   else {

            flash()->error("А ты правда Админ ?");
        }

        header("Location: /admin/users");
    }
}
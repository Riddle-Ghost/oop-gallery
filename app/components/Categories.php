<?php

namespace App\components;

class Categories {

    protected $query;

    public function __construct(\App\lib\Query $query) {

        $this->query = $query;
    }

    public function getAllCategories() {

        return $this->query->select(['id', 'title'], 'categories', ['id']);
    }
    public function getSingleCat($id) {

        $category = $this->query->select(['id', 'title'], 'categories', [], 'id=:id', 'id', $id);

        return $category[0];
         
    }
    public function newCategory($value) {

        $value = htmlentities( trim( $value ) );

        if ($value) {

            $this->query->insert('categories', ['title'], [$value]);
            flash()->success(['Категория добавлена!']);
            return 1;

        }   else {

            flash()->error(['Введите название категории!']);
            return 0;

        }
    }
    public function editCategory($id, $value) {

        $value = htmlentities( trim( $value ) );

        if ($value) {

            $this->query->update('categories', ['title'], $id, ['title' => $value]);
            flash()->success(['Категория обновлена!']);
            return 1;

        }   else {

            flash()->error(['Введите название категории!']);
            return 0;

        }
    }
    public function deleteCategory($id) {

        $this->query->delete('categories', $id);
        flash()->success(['Категория удалена!']);
    }
}
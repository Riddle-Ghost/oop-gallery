<?php

namespace App\components;

class Paginator {

    protected $query;

    public function __construct(\App\lib\Query $query) {

        $this->query = $query;
    }

    public function getCount($where = '', $value = '') {

        if ($where && $value) {
            $count = $this->query->select(['COUNT(id)'], 'photos', [], $where.'=:'.$where, $where, $value );

        } else {
            $count = $this->query->select(['COUNT(id)'], 'photos');
        }
        

        return $count['0']['COUNT(id)'];

    }
    public function main($page, $itemsPerPage, $pageName, $value = '') {

        if ($pageName == 'home') {

            $totalItems = $this->getCount();
            $urlPattern = '/(:num)';

        } elseif ( $pageName == 'profile' ) {

            $totalItems = $this->getCount('user_id', $value);
            $urlPattern = '/profile/(:num)';

        }   elseif ( $pageName == 'oneCategory' ) {

            $totalItems = $this->getCount('category_id', $value);
            $urlPattern = '/category/' . $value . '/(:num)';
        }
        
        
        if ($totalItems <= $itemsPerPage || $totalItems < ($page * $itemsPerPage) - $itemsPerPage ) {

            return 0;
        }

        $currentPage = $page;

        $libPaginator = new \JasonGrimes\Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $libPaginator;
    }
}
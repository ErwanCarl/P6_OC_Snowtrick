<?php 

namespace App\Service;

class PaginationHandler
{
    public function pagination(int $page, float $pageNumber) : int
    {
        if($page > 0 && $page <= $pageNumber) {
            $currentPage = $page;
            return $currentPage;
        }else{
            $currentPage = 1;
            return $currentPage;
        }
    }
}
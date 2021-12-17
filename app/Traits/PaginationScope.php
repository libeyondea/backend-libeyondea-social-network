<?php

namespace App\Traits;

trait PaginationScope
{

    public function scopePagination($query, $page = 1, $pageSize = 10)
    {
        $page = request()->get('page', $page);
        $pageSize = request()->get('page_size', $pageSize);
        return $query->skip(($page - 1) * $pageSize)->limit($pageSize)->get();
    }
}

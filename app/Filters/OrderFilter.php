<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class OrderFilter extends QueryFilter
{
    protected $filters = ['status'];

    public function status($status)
    {
        if ($status == 'pending') {
            $this->builder->pending();
        }

        if ($status == 'completed') {
            $this->builder->completed();
        }
    }
}

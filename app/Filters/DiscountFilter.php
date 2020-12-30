<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class DiscountFilter extends QueryFilter
{
    protected $filters = ['featured'];

    public function featured($featured)
    {
        if (filter_var($featured, FILTER_VALIDATE_BOOLEAN) == true) {
            $this->builder->featured();
        }
    }
}

<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class OrderFilter extends QueryFilter
{
    protected $filters = ['status', 'orders_time_scope'];

    public function status($status)
    {
        if ($status == 'pending') {
            $this->builder->pending();
        }

        if ($status == 'completed') {
            $this->builder->completed();
        }
    }

    public function orders_time_scope($orders_time_scope)
    {
        if ($orders_time_scope == 'this_month') {
            $this->builder->whereMonth('created_at', today()->month);
        }

        if ($orders_time_scope == 'last_month') {
            $this->builder->whereMonth('created_at', today()->subMonth()->month);
        }

        if ($orders_time_scope == 'this_year') {
            $this->builder->whereYear('created_at', today()->year);
        }

        if ($orders_time_scope == 'all_time') {
            $this->builder;
        }
    }
}

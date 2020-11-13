<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\CategoryResource';

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}

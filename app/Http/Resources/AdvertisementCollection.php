<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdvertisementCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\AdvertisementResource';

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;

class AdvertisementController
{
    public function index()
    {
        $ads = Advertisement::published()->paginate(20);

        return AdvertisementResource::collection($ads);
    }
}

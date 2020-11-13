<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\AdvertisementCollection;
use App\Models\Advertisement;

class AdvertisementController
{
    public function index()
    {
        $ads = Advertisement::all();

        return new AdvertisementCollection($ads);
    }
}

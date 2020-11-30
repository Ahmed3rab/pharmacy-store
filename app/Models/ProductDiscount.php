<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    use HasFactory, HasUuid;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceAfterAttribute()
    {
        return $this->product->price * (100 - $this->percentage) / 100;
    }
}

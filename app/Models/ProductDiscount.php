<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = ['id'];

    protected $dates = ['starts_at', 'ends_at'];

    public function items()
    {
        return $this->hasMany(ProductDiscountItem::class);
    }

    public function getSalePriceOfProduct($product)
    {
        return $product->price * (100 - $this->percentage) / 100;
    }

    public function hasExpired()
    {
        return $this->ends_at->lessThan(today());
    }
}

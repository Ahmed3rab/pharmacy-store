<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscountItem extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productDiscount()
    {
        return $this->belongsTo(ProductDiscount::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountItem extends Model
{
    use HasFactory;

    protected $table = "discountables";

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->where(['discountable_type' => 'products']);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->where(['discountable_type' => 'categories']);
    }
}

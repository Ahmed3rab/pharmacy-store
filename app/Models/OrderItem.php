<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function k()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getPriceAttribute($value)
    {
        return ucfirst($value);
    }
}

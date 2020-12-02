<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function imagePath()
    {
        return asset($this->image_path);
    }

    public function discountItems()
    {
        return $this->hasMany(ProductDiscountItem::class);
    }

    public function getPriceAfterAttribute()
    {
        if ($this->discount) {
            return $this->price * (100 - $this->discount->percentage) / 100;
        }

        return $this->price;
    }

    public function decreaseQuantity($amount)
    {
        $this->quantity -= $amount;
        $this->save();
    }

    public function activeDiscountItem()
    {
        return $this->hasOne(ProductDiscountItem::class, 'product_id')->whereHas('productDiscount', function ($query) {
            return $query->where('ends_at', '>=', today());
        });
    }

    public function path()
    {
        return config('app.url') . "/cp/products/{$this->uuid}/edit";
    }
}

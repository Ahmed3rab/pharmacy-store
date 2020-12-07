<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if ($product->position) {
                $product->position = $product->position;
            } else {
                $lastProductPosition = static::latest()->first() ? static::latest()->first()->position : 0;
                $product->position   = $lastProductPosition + 1;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function imagePath()
    {
        return asset($this->image_path);
    }

    public function discountItems()
    {
        return $this->hasMany(ProductDiscountItem::class);
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function getPriceAfterAttribute()
    {
        if ($this->activeDiscount) {
            return $this->price * (100 - $this->activeDiscount->percentage) / 100;
        }

        return $this->price;
    }

    public function decreaseQuantity($amount)
    {
        $this->quantity -= $amount;
        $this->save();
    }

    public function increaseQuantity($amount)
    {
        $this->quantity += $amount;
        $this->save();
    }

    public function getActiveDiscountAttribute()
    {
        if ($this->discounts->count()) {
            return $this->discounts()->where('ends_at', '>=', today())->first();
        }

        if ($this->category->discounts->count()) {
            return $this->category->discounts()->where('ends_at', '>=', today())->first();
        }
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

    public function scopeHasSufficientQuantity(Builder $builder)
    {
        $builder->where('quantity', '>', 0);
    }
}

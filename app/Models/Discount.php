<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = ['id'];

    protected $dates = ['starts_at', 'ends_at'];

    public function items()
    {
        return $this->hasMany(DiscountItem::class);
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'discountable')->withPivot('id');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'discountable')->withPivot('id');
    }

    public function hasExpired()
    {
        return $this->ends_at->lessThan(today());
    }
}

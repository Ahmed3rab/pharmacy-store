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

    public function discount()
    {
        return $this->hasOne(ProductDiscount::class);
    }
}

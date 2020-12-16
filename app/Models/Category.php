<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if ($category->position) {
                $category->position = $category->position;
            } else {
                $lastCategoryPosition = static::latest()->first() ? static::latest()->first()->position : 0;
                $category->position   = $lastCategoryPosition + 1;
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, 'discountable');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function iconPath()
    {
        return Storage::disk('categories')->url($this->icon_path);
    }

    public function path()
    {
        return config('app.url') . "/cp/categories/{$this->uuid}/edit";
    }

    public function getActiveDiscountAttribute()
    {
        return $this->discounts()->where('ends_at', '>=', today())->first();
    }

    public function scopePublished(Builder $builder)
    {
        $builder->where('published', true);
    }

    public function setIcon($icon)
    {
        if ($icon) {
            Storage::disk('categories')->put($path = $this->uuid . '-' . time() . '.' . $icon->extension(), file_get_contents($icon));

            $this->icon_path =  $path;
            $this->save();
        }
    }
}

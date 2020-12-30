<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function coverImagePath()
    {
        return Storage::disk('discounts')->url($this->cover_image_path);
    }

    public function setImage($image)
    {
        if ($image) {
            Storage::disk('discounts')->put($path = $this->uuid . '-' . time() . '.' . $image->extension(), file_get_contents($image));
            $this->cover_image_path =  $path;
            $this->save();
        }
    }
}

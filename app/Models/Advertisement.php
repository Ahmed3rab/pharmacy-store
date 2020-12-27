<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Advertisement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopePublished(Builder $builder)
    {
        $builder->where('published', true);
    }

    public function imagePath()
    {
        return Storage::disk('advertisements')->url($this->image_path);
    }

    public function setImage($image)
    {
        if ($image) {
            Storage::disk('advertisements')->put($path = $this->uuid . '-' . time() . '.' . $image->extension(), file_get_contents($image));

            $this->image_path =  $path;
            $this->save();
        }
    }
}

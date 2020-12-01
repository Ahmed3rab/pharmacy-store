<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function imagePath()
    {
        return asset($this->image_path);
    }
}

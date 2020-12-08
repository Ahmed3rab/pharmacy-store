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
}

<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = ['id'];

    protected $dates = ['sent_at'];

    protected $casts = [
        'users' => 'array',
    ];
}

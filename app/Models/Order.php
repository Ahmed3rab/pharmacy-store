<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $month = Str::upper(now()->shortMonthName);
            $year = now()->format('y');
            $count = DB::table('orders')->whereMonth('created_at', now()->month)->count();
            $orderNumber = sprintf("%'.06d", $count +=1);
            $order->reference_number = $month . "-" . $year . $orderNumber;
        });
    }

    protected $guarded = ['id'];

    public function complete()
    {
        return $this->update([
            'completed_at' => now(),
        ]);
    }

    public function isComplete()
    {
        return (bool) $this->completed_at;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getItemsTotalQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }
}

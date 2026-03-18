<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'total_amount',
        'shipping_charge',
        'tax',
        'payment_method',
        'payment_status',
        'order_status',
        'status',
    ];

    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_id', 'user_id');
    }
}

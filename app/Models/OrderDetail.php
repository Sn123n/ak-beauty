<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'discount_price',
        'subtotal',
        'discount_subtotal',
        'status',
        'product_title',
        'pincode',
        'shipped_date',
        'estimated_delivery_date',
        'delivered_date'
    ];

    protected $guarded = [];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class); // or whatever your User model is
    }
    
}

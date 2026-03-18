<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

        'category_id',
        'title',    
        'sku',
        'image',
        'back_image',
        'other_image',
        'content',
        'discount',
        'discount_type',
        'qnty',
        'weight_in_gram',
        'daily_deal',
        'price',
        'status',
        'variations'
    ];

    protected $casts = [
        'variations' => 'array',
    ];

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function review()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function orderdetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

}

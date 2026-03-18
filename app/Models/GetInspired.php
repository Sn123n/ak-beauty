<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetInspired extends Model
{
    use HasFactory;

    protected $table = 'get_inspired';

    protected $fillable = [
        'title',
        'detail',
        'image',
        'status'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}


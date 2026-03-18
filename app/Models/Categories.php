<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'content',
        'homeimage',
        'status',
        'display_on_home'
    ];
    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); // category_id foreign key
    }
}

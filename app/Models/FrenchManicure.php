<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrenchManicure extends Model
{
    use HasFactory;
    
    protected $table = 'french_manicures';
    
    protected $fillable = [
        'title',
        'title2',
        'image',
        'image2',
        'content',
        'content2',
        'status',
        'button_text',
        'button_link'
    ];
}

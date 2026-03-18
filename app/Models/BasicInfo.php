<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'email',
        'phone_number',
        'address',
        'address2',
        'site_name',
        'footer',
        'font1',
        'font2',
        'image_dark',
        'image_light',
        'facebook',
        'instagram',
        'thread',
        'pinterest',
        'twitter'
    ];
}

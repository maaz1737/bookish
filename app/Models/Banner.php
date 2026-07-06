<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'tittle',
        'top_tagline',
        'main_headline',
        'subheadline',
        'image_path',
        'link',
        'is_active',
        'order',
    ];
}

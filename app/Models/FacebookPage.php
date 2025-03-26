<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'name',
        'username',
        'access_token',
        'description',
        'profile_picture',
        'category',
        'likes',
        'followers',
        'posts_count',
        'is_active'
    ];

    protected $hidden = [
        'access_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'likes' => 'integer',
        'followers' => 'integer',
        'posts_count' => 'integer',
    ];
}

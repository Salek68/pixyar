<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id','shortcode','media_type','media_url','thumbnail_url',
        'caption','hashtags','mentions','likes_count','comments_count',
        'views_count','is_sponsored','posted_at','fetched_at'
    ];

    protected $casts = [
        'hashtags'=>'array',
        'mentions'=>'array',
        'is_sponsored'=>'boolean',
        'posted_at'=>'datetime',
        'fetched_at'=>'datetime'
    ];

    public function profile(){ return $this->belongsTo(InstagramProfile::class); }
public function comments()
{
    return $this->hasMany(InstagramComment::class, 'post_id');
}

    public function insights(){ return $this->hasMany(PostInsight::class); }
}

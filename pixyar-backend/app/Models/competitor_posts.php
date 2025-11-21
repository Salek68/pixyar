<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competitor_posts extends Model
{
    use HasFactory;

    protected $table = 'competitor_posts';

    protected $fillable = [
          'instagram_profile_id',
        'post_id',
        'media_type',
        'media_url',
        'caption',
        'hashtags',
        'hashtags_count',

        'like_count',
        'comment_count',
        'view_count',
        'share_count',
        'save_count',

        'video_duration',

        'published_at',
        'taken_at',


        'caption_length',
        'mentions_count',


    ];

    protected $casts = [
        'published_at' => 'datetime',
        'taken_at' => 'datetime',
        'video_duration' => 'double',


        'hashtags_count' => 'integer',
        'caption_length' => 'integer',
        'mentions_count' => 'integer',
    ];

    // -----------------------------------------
    // RELATIONS
    // -----------------------------------------



    // پروفایل اینستاگرام مربوطه
    public function instagramProfile()
    {
        return $this->belongsTo(InstagramProfile::class, 'instagram_profile_id');
    }
}

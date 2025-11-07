<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramProfileSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id','followers_count','following_count','posts_count',
        'avg_likes','avg_comments','engagement_rate','collected_at'
    ];

    protected $casts = ['collected_at'=>'datetime'];

    public function profile(){ return $this->belongsTo(InstagramProfile::class); }
}

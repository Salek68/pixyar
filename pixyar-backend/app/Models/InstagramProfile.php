<?php

namespace App\Models;


use App\Models\AnalyticsCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstagramProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','username','full_name','profile_pic','biography','website',
        'is_verified','followers_count','following_count','posts_count',
        'country','language','account_type','engagement_rate','avg_likes','avg_comments','fetched_at'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'fetched_at' => 'datetime',
    ];

    public function user(){ return $this->belongsTo(User::class); }
    public function posts(){ return $this->hasMany(InstagramPost::class); }
    public function snapshots(){ return $this->hasMany(InstagramProfileSnapshot::class); }
    public function reports(){ return $this->hasMany(Report::class); }
    public function analyticsCache(){ return $this->hasMany(AnalyticsCache::class); }
}

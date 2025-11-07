<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id','engagement_rate','caption_length','hashtags_count',
        'mentions_count','best_posting_hour','performance_label','created_at'
    ];

    protected $casts = ['engagement_rate'=>'float','created_at'=>'datetime'];

    public function post(){ return $this->belongsTo(InstagramPost::class); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestedCampaign extends Model
{
    use HasFactory;

    // نام جدول مشخص شود
    protected $table = 'instagram_campaign_suggestions';

    // فیلدهایی که قابل پر شدن هستند
    protected $fillable = [
        'instagram_profile_id',
        'campaign_title',
        'campaign_goal',
        'campaign_description',
        'suggested_media_type',
        'suggested_post_caption',
        'suggested_post_caption_length',
        'suggested_post_hashtags',
        'suggested_post_hashtags_count',
        'suggested_post_time',
        'repeated_hashtags',
        'repeated_words',
        'competitor_analysis',
        'insights',
    ];

    // اگر نیاز است، نوع داده‌ها را مشخص کنیم
    protected $casts = [
        'suggested_post_hashtags' => 'array',
        'repeated_hashtags'       => 'array',
        'repeated_words'          => 'array',
    ];

    // رابطه با پروفایل اینستاگرام
    public function instagramProfile()
    {
        return $this->belongsTo(InstagramProfile::class, 'instagram_profile_id');
    }
}

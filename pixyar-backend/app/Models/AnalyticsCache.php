<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsCache extends Model
{
    use HasFactory;

    protected $fillable = ['profile_id','type','payload','calculated_at'];
    protected $casts = ['payload'=>'array','calculated_at'=>'datetime'];

    public function profile(){ return $this->belongsTo(InstagramProfile::class); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramComment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id','username','text','sentiment_score','created_at'];
    protected $casts = ['sentiment_score'=>'float','created_at'=>'datetime'];

    public function post(){ return $this->belongsTo(InstagramPost::class); }
}

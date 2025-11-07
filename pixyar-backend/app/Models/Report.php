<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','profile_id','type','file_path','generated_at'];
    protected $casts = ['generated_at'=>'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
    public function profile(){ return $this->belongsTo(InstagramProfile::class); }
}

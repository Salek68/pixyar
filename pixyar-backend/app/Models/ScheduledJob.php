<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','job_type','status','started_at','finished_at','message'
    ];

    protected $casts = ['started_at'=>'datetime','finished_at'=>'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','plan','price','status','started_at','expires_at','payment_reference'
    ];

    protected $casts = ['started_at'=>'datetime','expires_at'=>'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
}

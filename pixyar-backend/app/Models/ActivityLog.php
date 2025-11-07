<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','action','metadata','ip_address','created_at'];
    protected $casts = ['metadata'=>'array','created_at'=>'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
}

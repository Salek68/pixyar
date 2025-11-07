<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','endpoint','response_time_ms','status_code','response_size','created_at'];
    protected $casts = ['created_at'=>'datetime'];

    public function user(){ return $this->belongsTo(User::class); }
}
    
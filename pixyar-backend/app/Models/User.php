<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','email','password','plan','last_login_at','signup_ip','status'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['last_login_at'=>'datetime','plan'=>'string','status'=>'string'];

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public function instagramProfiles(){ return $this->hasMany(InstagramProfile::class); }
    public function subscriptions(){ return $this->hasMany(Subscription::class); }
    public function scheduledJobs(){ return $this->hasMany(ScheduledJob::class); }
    public function activityLogs(){ return $this->hasMany(ActivityLog::class); }
    public function apiRequests(){ return $this->hasMany(ApiRequest::class); }
}

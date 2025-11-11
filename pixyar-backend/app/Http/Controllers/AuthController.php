<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index (Request $request){
        return view('login');
    }

    /**
     * ثبت نام کاربر
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password, // هش توسط مدل User انجام می‌شود
            'plan'=> $request->plan,
        ]);
         $plan = $request->plan;

        // ثبت سابسکریپشن
        switch ($plan) {
            case 'free':
                $price = 0;
                $status = 'active';
                $expires_at = null;
                break;
            case 'pro':
                $price = 100000;
                $status = 'canceled';
                $expires_at = Carbon::now()->addMonth();
                break;
            case 'business':
                $price = 200000;
                $status = 'canceled';
                $expires_at = Carbon::now()->addMonth();
                break;
            default:
                return response()->json([
                    'message' => 'پلن اشتباه است'
                ], 422);
        }

        Subscription::create([
            'user_id' => $user->id,
            'plan' => $plan,
            'price' => $price,
            'status' => $status,
            'expires_at' => $expires_at
        ]);

        // ایجاد توکن API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=>'ثبت نام موفقیت آمیز بود',
            'user'=> $user,
            'token'=> $token
        ]);
    }

    /**
     * ورود کاربر
     */
    public function login(Request $request)
    {
      $request->validate([
    'email' => 'required|email',
    'password' => 'required|string',
]);

$user = User::where('email', $request->email)->first();

if (!$user || !password_verify($request->password, $user->password)) {
    return response()->json(['message' => 'ایمیل یا رمز عبور اشتباه است'], 401);
}

$sub = Subscription::where('user_id', $user->id)->first();

// اگر کاربر اشتراک نداشت، به پلن رایگان تنظیم کن
if (!$sub) {
    $sub = Subscription::create([
        'user_id' => $user->id,
        'plan' => 'free',
        'status' => 'active',
        'expires_at' => null,
    ]);
}

// بررسی وضعیت اشتراک
if ($sub->plan != "free") {
    if ($sub->status != "active" || ($sub->expires_at && Carbon::now()->greaterThan($sub->expires_at))) {
        // اتمام یا غیرفعال شدن اشتراک → برگرد به پلن رایگان
        $sub->plan = "free";
        $sub->status = "active";
        $sub->expires_at = null;
        $sub->save();

        return response()->json([
            'message' => 'اشتراک شما پایان رسیده است یا پرداخت نشده است. پلن شما به صورت خودکار به رایگان تغییر کرد. لطفا دوباره وارد شوید.'
        ], 401);
    }
}

// اگر اشتراک فعال است یا رایگان:
$user->last_login_at = now();
$user->signup_ip = $request->ip();
$user->save();

Auth::login($user);
$token = $user->createToken('auth_token')->plainTextToken;

return response()->json([
    'message' => 'ورود موفقیت‌آمیز بود',
    'user' => $user,
    'token' => $token,
]);

    }

    /**
     * خروج کاربر (Revoking token)
     */
    public function logout(Request $request)
    {
        // حذف توکن فعلی
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message'=>'خروج با موفقیت انجام شد'
        ]);
    }
}

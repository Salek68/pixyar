<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index (Request $request){
        return view('')
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
            'plan'=> 'free',
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
            'email'=> 'required|email',
            'password'=> 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !password_verify($request->password, $user->password)){
            return response()->json(['message'=>'ایمیل یا رمز عبور اشتباه است'],401);
        }

        // بروزرسانی زمان آخرین ورود و IP
        $user->last_login_at = now();
        $user->signup_ip = $request->ip();
        $user->save();

        // ایجاد توکن API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'=>'ورود موفقیت آمیز بود',
            'user'=> $user,
            'token'=> $token
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

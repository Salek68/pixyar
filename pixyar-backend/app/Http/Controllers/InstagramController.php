<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessAllApis;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use Carbon\Carbon;

class InstagramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * دریافت اطلاعات پروفایل و ثبت Subscription
     */
    public function fetchProfile(Request $request)
    {
        $request->validate([
            'page_id' => 'required|string',
            'plan' => 'required|string', // free | pro | business
        ]);

        $userId = Auth::id();
        $username = $request->page_id;
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
            'user_id' => $userId,
            'plan' => $plan,
            'price' => $price,
            'status' => $status,
            'expires_at' => $expires_at
        ]);

        // Dispatch Job برای پردازش پروفایل، پست و کامنت‌ها
      $job = new \App\Jobs\ProcessAllApis($username, $userId);
$job->handle();


        return response()->json([
            'message' => 'درخواست ثبت شد و پردازش پروفایل در پس‌زمینه انجام می‌شود. تا 3 ثانیه دیگر به صورت اتومات به پنل منتقل میشوید',
            'plan' => $plan
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\ProcessAllApis;
use App\Models\InstagramProfile;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
    ]);

    $user = Auth::user();
    $username = $request->page_id;
    $type = $request->type;
    // گرفتن آخرین اشتراک فعال
    $subscription = $user->subscriptions()
        ->where('status', 'active')
        ->latest('id')
        ->first();

    if (!$subscription) {
        return response()->json([
            'message' => 'اشتراکی فعال پیدا نشد. لطفا ابتدا پلن خود را ارتقا دهید.'
        ], 403);
    }

    // تعیین ظرفیت بر اساس پلن
    $planLimits = [
        'free' => 1,
        'pro' => 2,
        'business' => 5,
    ];

    $plan = $subscription->plan;
    $limit = $planLimits[$plan] ?? 1; // اگر پلن تعریف نشده بود، 1

    // تعداد پروفایل‌های ثبت شده توسط کاربر
    // فرض می‌کنیم جدولی دارید که پروفایل‌ها ثبت شده‌اند، مثلا user_profiles
    $currentCount = $user->instagramProfiles()->count(); // اگر رابطه user->profiles دارید

    if ($currentCount >= $limit) {
        return response()->json([
            'message' => "ظرفیت پلن شما: $limit پروفایل است. شما $currentCount پروفایل ثبت کرده‌اید."
        ], 403);
    }

    // اگر ظرفیت آزاد بود → اجرای Job
    $job = new ProcessAllApis($username, $user->id);
    $job->handle();
InstagramProfile::where('username', $username)->update([
    'type' => $type,

]);
    return response()->json([
        'message' => 'درخواست ثبت شد و پردازش پروفایل در پس‌زمینه انجام می‌شود. تا 3 ثانیه دیگر به صورت اتومات به پنل منتقل میشوید',
    ]);
    }
}

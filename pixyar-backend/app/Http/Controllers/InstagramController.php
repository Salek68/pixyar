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
            
        ]);

        $userId = Auth::id();
        $username = $request->page_id;



        // Dispatch Job برای پردازش پروفایل، پست و کامنت‌ها
      $job = new \App\Jobs\ProcessAllApis($username, $userId);
$job->handle();


        return response()->json([
            'message' => 'درخواست ثبت شد و پردازش پروفایل در پس‌زمینه انجام می‌شود. تا 3 ثانیه دیگر به صورت اتومات به پنل منتقل میشوید',

        ]);
    }
}

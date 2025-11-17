<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Jobs\ProcessAllApis;
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

        $userId = Auth::id();
        $username = $request->page_id;



    $job = new ProcessAllApis($username, $userId);
$job->handle();


        // Dispatch Job برای پردازش پروفایل، پست و کامنت‌ها


        return response()->json([
            'message' => 'درخواست ثبت شد و پردازش پروفایل در پس‌زمینه انجام می‌شود. تا 3 ثانیه دیگر به صورت اتومات به پنل منتقل میشوید',

        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Http\Controllers\Controller;
use App\Models\InstagramProfileSnapshot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request,$idprofile)
    {
        $id = Auth::id();
$userId = Auth::id();


       $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
$username = $profiles->username;
         $job = new \App\Jobs\ProcessAllApis($username, $userId);
     $job->handle();
     $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $posts = InstagramPost::where('profile_id', $idprofile)->get();
        return view ('admin.PanelAdmin',compact('profiles','posts','idprofile'));
    }
      public function showpost(Request $request,$idprofile,$idpost)
    {
        $id = Auth::id();
       $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $post = InstagramPost::with(['profile.user','comments'])->where('profile_id', $idprofile)->where('id',$idpost)->first();

$likes = Http::get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
    'url' => 'https://instagram-social-api.p.rapidapi.com/v1/likes',
    'host' => 'instagram-social-api.p.rapidapi.com',
    'code_or_id_or_url' => $post->shortcode
]);

$likes = $likes->json();


        return view ('admin.PanelAdminShowPost',compact('profiles','post','likes','idprofile'));
    }
    public function select(Request $request)
    {
        $id = Auth::id();
       $profiles = InstagramProfile::where('user_id', $id)->get();


        return view ('admin.select-profile',compact('profiles'));
    }

     public function starter(Request $request)
    {
        return view ('profile');
    }

    public function bestTimeHeatmap($idprofile)
{
     $id = Auth::id();
   $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();

    $posts = InstagramPost::where('profile_id', $idprofile)->get();

    $days = ['شنبه','یکشنبه','دوشنبه','سه‌شنبه','چهارشنبه','پنج‌شنبه','جمعه'];
    $hours = range(0,23);
    $heatmap = array_fill(0, 7, array_fill(0, 24, 0));
      $followers_count = $profiles->followers_count;

   foreach ($posts as $post) {
        if(!$post->posted_at) continue; // اگر posted_at خالی است

        $dt = \Carbon\Carbon::parse($post->posted_at)->timezone('Asia/Tehran');

        // تبدیل dayOfWeek به index فارسی (شنبه=0, جمعه=6)
        $dayIndex = ($dt->dayOfWeek + 1) % 7;

        $hourIndex = $dt->hour;

        // نرخ تعامل واقعی
        $engagement = ($post->likes_count + $post->comments_count) / max($followers_count,1) * 100;

        // میانگین اگر چند پست در همان سلول باشند
        if($heatmap[$dayIndex][$hourIndex] > 0){
            $heatmap[$dayIndex][$hourIndex] = ($heatmap[$dayIndex][$hourIndex] + $engagement)/2;
        } else {
            $heatmap[$dayIndex][$hourIndex] = $engagement;
        }
    }

    // گرد کردن مقادیر
    foreach ($heatmap as $d => $row) {
        foreach ($row as $h => $val) {
            $heatmap[$d][$h] = round($val,2);
        }
    }

     $topTimes = [];
    foreach ($heatmap as $dayIndex => $row) {
        foreach ($row as $hourIndex => $val) {
            $topTimes[] = [
                'day' => $days[$dayIndex],
                'hour' => $hourIndex,
                'engagement' => $val
            ];
        }
    }

    $topTimes = collect($topTimes)->sortByDesc('engagement')->take(5);


    return view('admin.PanelAdminBestTime', compact('days','hours','heatmap','profiles','idprofile','topTimes'));
}


public function followersGrowth($idprofile)
{

      $id = Auth::id();
   $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();

    // گرفتن داده‌ها از جدول آمار پروفایل
    $stats = InstagramProfileSnapshot::
        where('profile_id', $idprofile)
        ->orderBy('collected_at')
        ->get()
        ->groupBy(function($item) {
            // گروه‌بندی بر اساس روز (Y-m-d)
            return Carbon::parse($item->collected_at)->format('Y-m-d');
        })
        ->map(function($dayGroup){
            // فقط آخرین رکورد روزانه
            return $dayGroup->last();
        });

    $dates = $stats->pluck('collected_at')->map(function($date){
        return Carbon::parse($date)->format('Y-m-d');
    });

    $followers = $stats->pluck('followers_count');

    return view('admin.PanelAdminFallowChart', compact('dates','followers','profiles', 'idprofile'));
}


}

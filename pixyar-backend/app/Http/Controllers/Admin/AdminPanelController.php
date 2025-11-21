<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Http\Controllers\Controller;
use App\Models\competitor_posts;
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
        set_time_limit(180);

        $id = Auth::id();
$userId = Auth::id();


       $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
     $snapshot = InstagramProfileSnapshot::where('profile_id', $profiles->id)
            ->orderBy('collected_at', 'desc')
            ->first();
$username = $profiles->username;
$diffHours = $snapshot->collected_at->diffInHours(now('Asia/Tehran')) + 3.5;


$hours = floor($diffHours);


if (!$snapshot->collected_at || $hours >= 5) {

     $job = new \App\Jobs\ProcessAllApis($username, $userId);
   $job->handle();

}




     $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
  


      $posts = InstagramPost::where('profile_id', $idprofile)->get();
        return view ('admin.PanelAdmin',compact('profiles','posts','idprofile'));
    }


public function raghib(Request $request,$idprofile)
    {
        set_time_limit(180);

        $id = Auth::id();
$userId = Auth::id();


      
  




     $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $responsePostC = Http::withoutVerifying()->get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
    'url' => 'https://instagram-social-api.p.rapidapi.com/v1/search_posts',
    'host' => 'instagram-social-api.p.rapidapi.com',
    'search_query' => $profiles->full_name
]);
    $postsDatac = $responsePostC->json()['data']['items'] ?? [];
foreach ($postsDatac as $post) {

    // 1) استخراج امن caption
    $captionText = null;

    if (isset($post['caption']['text'])) {
        $captionText = $post['caption']['text'];
    }

    // 2) اگر کپشن وجود ندارد → پست را ذخیره نکن (skip)
    if (empty($captionText)) {
        continue;
    }

    // 3) ادامه تحلیل فقط برای پست‌هایی که کپشن دارند
    $captionLength = mb_strlen($captionText);

    // استخراج هشتگ‌ها
    preg_match_all('/#(\w+)/u', $captionText, $matches);
    $hashtagsArray = $matches[0] ?? [];

    // استخراج منشن‌ها
    preg_match_all('/@(\w+)/u', $captionText, $mentionsMatch);
    $mentionsArray = $mentionsMatch[0] ?? [];

    competitor_posts::updateOrCreate(
        [
            'instagram_profile_id' => $profiles->id,
            'post_id'  => $post['code'] ?? null,
        ],
        [
            'media_type'       => $post['media_format'] ?? 'image',
            'media_url'        => $post['video_url'] ,


            'caption'          => $captionText,
            'caption_length'   => $captionLength,

            'hashtags'         => json_encode($hashtagsArray),
            'hashtags_count'   => count($hashtagsArray),

            'mentions_count'   => count($mentionsArray),

            'like_count'       => $post['like_count'] ?? 0,
            'comment_count'    => $post['comment_count'] ?? 0,
            'view_count'       => $post['play_count'] ?? 0,

        'share_count'       => $post['share_count'] ?? 0,
            'save_count'        => $post['save_count'] ?? 0,
            'video_duration'    => $post['video_duration'] ?? null,

            'published_at'      => isset($post['published_at'])
                                    ? date('Y-m-d H:i:s', strtotime($post['published_at']))
                                    : null,

            'taken_at'          => isset($post['taken_at_date'])
                                    ? date('Y-m-d H:i:s', strtotime($post['taken_at_date']))
                                    : null,

        ]
    );

}


      $posts = competitor_posts::where('instagram_profile_id', $idprofile)->get();
        return view ('admin.PanelAdminRaghib',compact('profiles','posts','idprofile'));
    }


      public function showpost(Request $request,$idprofile,$idpost)
    {
        $id = Auth::id();
       $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $post = InstagramPost::with(['profile.user','comments'])->where('profile_id', $idprofile)->where('id',$idpost)->first();

$likes = Http::withoutVerifying()->get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
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

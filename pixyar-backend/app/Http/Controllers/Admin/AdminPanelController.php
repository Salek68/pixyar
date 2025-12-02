<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Http\Controllers\Controller;
use App\Models\competitor_posts;
use App\Models\InstagramProfileSnapshot;
use App\Models\SuggestedCampaign;
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
// function faToEnTrans($text)
// {
//     // جدول تبدیل
//     $map = [
//         'ا'=>'a','آ'=>'a','ب'=>'b','پ'=>'p','ت'=>'t','ث'=>'s','ج'=>'j','چ'=>'ch',
//         'ح'=>'h','خ'=>'kh','د'=>'d','ذ'=>'z','ر'=>'r','ز'=>'z','ژ'=>'zh','س'=>'s',
//         'ش'=>'sh','ص'=>'s','ض'=>'z','ط'=>'t','ظ'=>'z','ع'=>'a','غ'=>'gh','ف'=>'f',
//         'ق'=>'gh','ک'=>'k','گ'=>'g','ل'=>'l','م'=>'m','ن'=>'n','و'=>'v','ه'=>'h','ی'=>'y',
//         ' ',''
//     ];

//     $trans = '';
//     $chars = preg_split('//u', $text, 0, PREG_SPLIT_NO_EMPTY);

//     foreach ($chars as $c) {
//         $trans .= $map[$c] ?? $c;
//     }

//     return strtolower($trans);
// }


// function generateSmartPasswords($info)
// {
//     $patterns = [];

//     // Detect & convert Persian names
//     $name = preg_match('/[\x{0600}-\x{06FF}]/u', $info['name'])
//         ? faToEnTrans($info['name'])
//         : strtolower($info['name']);

//     $family = preg_match('/[\x{0600}-\x{06FF}]/u', $info['family'])
//         ? faToEnTrans($info['family'])
//         : strtolower($info['family']);

//     // Other fields
//     $birth      = substr($info['birth_year'], -2);
//     $fullBirth  = $info['birth_year'];
//     $mobile4    = substr($info['mobile'], -4);
//     $username   = strtolower($info['username']);
//     $sitePass   = $info['site_password'];

//     // Extract parts from site password
//     $siteBase   = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $sitePass));
//     $sitePrefix = substr($siteBase, 0, 3);
//     $siteDigits = preg_replace('/\D/', '', $sitePass);

//     // Common suffixes
//     $suffixes = ["!", "@", "#", "$", "123", "2024", "2025", "##", "@@"];

//     $baseParts = [
//         $name, $family, $username,
//         $name.$family,
//         $sitePrefix, $siteBase
//     ];

//     // 1: Name combinations
//     foreach ($baseParts as $p) {
//         $patterns[] = $p.$birth;
//         $patterns[] = $p.$fullBirth;
//         $patterns[] = $p.$mobile4;
//         $patterns[] = $p."_".$birth;
//         $patterns[] = $p."_".$fullBirth;
//     }

//     // 2: Username combos
//     $patterns[] = $username;
//     $patterns[] = str_replace("_", ".", $username);
//     $patterns[] = $username.$birth;
//     $patterns[] = $username.$fullBirth;

//     // 3: Mix with site password structure
//     if ($siteDigits) {
//         $patterns[] = $name.$siteDigits;
//         $patterns[] = $family.$siteDigits;
//         $patterns[] = $username.$siteDigits;
//     }

//     // 4: Add suffix variations
//     foreach ($patterns as $p) {
//         foreach ($suffixes as $s) {
//             $patterns[] = $p.$s;
//         }
//     }

//     // 5: Human-like strong combos
//     $patterns[] = $name."dev".$birth;
//     $patterns[] = $name."dev".$fullBirth;
//     $patterns[] = $name."style".$birth;
//     $patterns[] = $name."style".$fullBirth;
//     $patterns[] = $name.$family."@".$birth;
//     $patterns[] = $name.$family."#".$fullBirth;

//     // 6: Cleanup
//     $patterns = array_unique(array_filter($patterns));

//     return array_values($patterns);
// }


// $info = [
//     "name" => "saleh",
//     "family" => "keshavarz",
//     "birth_year" => "1386",
//     "mobile" => "09334650695",
//     "username" => "@sale_k68",
//     "site_password" => "@salehk15"
// ];

// $results = generateSmartPasswords($info);
// dd($results);

        $id = Auth::id();
$userId = Auth::id();
$profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();

// /////


//   $responsef = Http::withoutVerifying()->get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
//     'url' => 'https://instagram-social-api.p.rapidapi.com/v1/followers',
//     'host' => 'instagram-social-api.p.rapidapi.com',
//     'username_or_id_or_url' => $profiles->username
// ]);

// dd($responsef->json());
// ///




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
    'search_query' => $profiles->type
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


    public function campain(Request $request,$idprofile)
    {
        set_time_limit(180);

        $id = Auth::id();
$userId = Auth::id();


$myPosts = InstagramPost::where('profile_id', $idprofile)->get();
$competitorPosts = competitor_posts::where('instagram_profile_id', $idprofile)->get();

$hashtags = [];

foreach ($competitorPosts as $post) {
    $tags = json_decode($post->hashtags, true) ?? [];
    foreach ($tags as $t) {
        $hashtags[] = strtolower($t);
    }
}

$hashtagsRepeated = array_count_values($hashtags);
arsort($hashtagsRepeated); // مرتب‌سازی
$topHashtags = array_slice(array_keys($hashtagsRepeated), 0, 15);

$words = [];

foreach ($competitorPosts as $p) {
    if (!$p->caption) continue;

    $text = strtolower($p->caption);
    $parts = preg_split('/\s+/', $text);

    foreach ($parts as $w) {
        if (strlen($w) > 3) {
            $words[] = $w;
        }
    }
}

$wordRepeated = array_count_values($words);
arsort($wordRepeated);
$topWords = array_slice(array_keys($wordRepeated), 0, 20);

$hours = [];

foreach ($competitorPosts as $p) {
    if (!$p->taken_at) continue;

    $h = date('H', strtotime($p->taken_at));
    $hours[] = $h;
}

$bestHour = (!empty($hours)) ? array_keys(array_count_values($hours), max(array_count_values($hours)))[0] : null;

function generateSmartCaption($topWords, $topHashtags) {

    // ۱) متن پایه
    $base = [
        "امروز می‌خوایم درباره " . ($topWords[0] ?? "موضوعات مهم") . " صحبت کنیم!",
        "یه نکته مهم درباره " . ($topWords[1] ?? "رشد پیج") . " که حتما باید بدونید...",
        "اگر می‌خوای نتیجه بهتری بگیری، این پست رو از دست نده!",
    ];

    // ۲) رندوم از جملات بالا
    $caption = $base[array_rand($base)];

    // ۳) اضافه کردن هشتگ‌ها


    return trim($caption);
}
function generateCampaignTitle($topWords)
{
    $titles = [
        "کمپین افزایش تعامل درباره " . ($topWords[0] ?? "موضوع مهم"),
        "کمپین رشد فالوور با تمرکز روی " . ($topWords[1] ?? "محتوای پرتعامل"),
        "کمپین محتوایی ۷ روزه"
    ];

    return $titles[array_rand($titles)];
}
function generateInsight($bestHour, $topWords, $topHashtags)
{
    return "
📊 تحلیل خودکار از رفتار رقبای شما:

⏰ بهترین زمان انتشار: " . ($bestHour ? "$bestHour:00" : "نامشخص") . "
🔥 بیشترین موضوعات تکرار‌شده: " . implode('، ', array_slice($topWords,0,5)) . "
🏷️ هشتگ‌های پرتکرار: #" . implode(' #', array_slice($topHashtags,0,5)) . "

بر اساس رفتار رقیبا پیشنهاد می‌شود:
- در همین ساعت پست منتشر کنید
- از این هشتگ‌ها استفاده کنید
- پست با موضوع «".$topWords[0]."» تعامل بهتری می‌گیرد
    ";
}
$lastCampaign = SuggestedCampaign::where('instagram_profile_id', $idprofile)
    ->orderBy('created_at', 'desc')
    ->first();
if(!$lastCampaign){
   $campaignCaption = generateSmartCaption($topWords, $topHashtags);
$aiInsight = generateInsight($bestHour, $topWords, $topHashtags);
$campaignTitle = generateCampaignTitle($topWords);

SuggestedCampaign::create([

    'instagram_profile_id'  => $idprofile,

    'campaign_title'        => $campaignTitle,
    'campaign_goal'         => 'engagement',
    'campaign_description'  => 'کمپین بر اساس تحلیل رقیبا و پست‌های اخیر ساخته شد.',

    'suggested_media_type'  => 'reels',
    'suggested_post_caption' => $campaignCaption,
    'suggested_post_caption_length' => mb_strlen($campaignCaption),
    'suggested_post_hashtags' => json_encode($topHashtags),
    'suggested_post_hashtags_count' => count($topHashtags),

    'suggested_post_time'   => $bestHour ? $bestHour . ':00' : null,

    'repeated_hashtags'     => json_encode($topHashtags),
    'repeated_words'        => json_encode($topWords),
    'competitor_analysis'   => "رقیبا در ساعت $bestHour بیشترین پست‌گذاری را دارند ...",

    'insights'              => $aiInsight,
]);

}
else{
$twoWeeksAgo = Carbon::now()->subWeeks(2);

// اگر created_at رشته است → parse با UTC
$createdAt = $lastCampaign->created_at instanceof \Carbon\Carbon
    ? $lastCampaign->created_at
    : Carbon::parse($lastCampaign->created_at, 'UTC');

// مطمئن شو هر دو زمان در یک timezone هستند
$createdAt->setTimezone(config('app.timezone'));

// اگر کمپین وجود دارد و از ۲ هفته گذشته → حذفش کن
if ($lastCampaign &&$createdAt->lt($twoWeeksAgo)) {
    $lastCampaign->delete();
    $campaignCaption = generateSmartCaption($topWords, $topHashtags);
$aiInsight = generateInsight($bestHour, $topWords, $topHashtags);
$campaignTitle = generateCampaignTitle($topWords);

SuggestedCampaign::create([

    'instagram_profile_id'  => $idprofile,

    'campaign_title'        => $campaignTitle,
    'campaign_goal'         => 'engagement',
    'campaign_description'  => 'کمپین بر اساس تحلیل رقیبا و پست‌های اخیر ساخته شد.',

    'suggested_media_type'  => 'reels',
    'suggested_post_caption' => $campaignCaption,
    'suggested_post_caption_length' => mb_strlen($campaignCaption),
    'suggested_post_hashtags' => json_encode($topHashtags),
    'suggested_post_hashtags_count' => count($topHashtags),

    'suggested_post_time'   => $bestHour ? $bestHour . ':00' : null,

    'repeated_hashtags'     => json_encode($topHashtags),
    'repeated_words'        => json_encode($topWords),
    'competitor_analysis'   => "رقیبا در ساعت $bestHour بیشترین پست‌گذاری را دارند ...",

    'insights'              => $aiInsight,
]);





}
}





 $profiles = InstagramProfile::where('user_id', $id)->where('id' , $idprofile)->first();
      $posts = SuggestedCampaign::where('instagram_profile_id', $idprofile)->get();
    //   dd($posts);
        return view ('admin.PanelAdminCampain',compact('profiles','posts','idprofile'));
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

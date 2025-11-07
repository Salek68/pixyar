<?php

namespace App\Http\Controllers;


use App\Models\ApiRequest;
use Illuminate\Http\Request;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\InstagramCommentsController;

class InstagramPostsController extends Controller
{
       /**
     * دریافت و ذخیره پست‌های یک پروفایل اینستاگرام
     */
    public function fetchPosts(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $username = $request->username;
  $userId = Auth::id();
        // ابتدا پروفایل را پیدا می‌کنیم
        $profile = InstagramProfile::where('username', $username)->first();

        if (!$profile) {
            return response()->json(['message' => 'پروفایل یافت نشد. ابتدا پروفایل را ثبت کنید.'], 404);
        }
$startTime = microtime(true);
        // فراخوانی API برای دریافت پست‌ها
        $response = Http::withHeaders([
            'X-Rapidapi-Key' => '26d6bc2669msh34bc749da31f3a5p10fb9ajsnbbbf46a26c5d',
            'X-Rapidapi-Host' => 'instagram-social-api.p.rapidapi.com'
        ])->get("https://instagram-social-api.p.rapidapi.com/v1/posts", [
            'username_or_id_or_url' => $username
        ]);
$endTime = microtime(true);

$responseTime = round(($endTime - $startTime) * 1000, 2); // تبدیل به میلی‌ثانیه
$responseSize = strlen($response->body());

ApiRequest::create([
    'user_id' =>$userId,
    'endpoint' => '/v1/post',
    'response_time_ms' => $responseTime,
    'status_code' => $response->status(),
    'response_size' => $responseSize,
]);
        if ($response->failed()) {
            return response()->json(['message' => 'خطا در دریافت پست‌ها'], 500);
        }

        $postsData = $response->json()['data']['items'] ?? [];

        foreach ($postsData as $post) {
 InstagramPost::updateOrCreate(
    [
        'profile_id' => $profile->id,
        'shortcode' => $post['code'] ?? 'null',
    ],
    [

        'media_type' => $post['media_format'] ?? 'image',
        'media_url' => $post['video_url']  ?? 'null',
        'thumbnail_url' => $post['thumbnail_url']  ?? 'null',
        'caption' => $post['caption']['text']  ?? 'null',
        'hashtags' => json_encode($post['caption']['hashtags'] ?? []),
        'mentions' => json_encode($post['caption']['mentions'] ?? []),
        'likes_count' => $post['like_count'] ?? 0,
        'comments_count' => $post['comment_count'] ?? 0,
        'views_count' => $post['play_count'] ?? 0,
        'is_sponsored' => $post['is_sponsored'] ?? 0,
        'posted_at' => isset($post['taken_at_date']) ? date('Y-m-d H:i:s', strtotime($post['taken_at_date'])) : null,
    ]
);
        }


 $posts = InstagramPost::where('profile_id', $profile->id)->get();
$like_conut= 0 ;
$comment_conut = 0;

 foreach ($posts as $post) {
$like_conut += $post['likes_count'];
$comment_conut += $post['comments_count'];
$commentsController = new InstagramCommentsController();
    $commentsController->StoreComments($post['id'],$post['shortcode']);
 }
$like_avg = $like_conut / count($posts);
$comment_avg = $comment_conut / count($posts);
$engagement_rate = (($like_avg + $comment_avg) / $profile->followers_count) * 100;
  $profile = InstagramProfile::updateOrCreate(
    [
        'username' => $username
    ],
    [
        'engagement_rate'  => $engagement_rate,
    'avg_likes'        => $like_avg,  // ← فقط نمونه، باید محاسبه دقیق‌تر شود
    'avg_comments'     => $comment_avg
    ]
  );

        return response()->json([
           'message' => 'پست‌ها با موفقیت دریافت و ذخیره شدند.',

            'count' => count($postsData)
        ]);
    }
}

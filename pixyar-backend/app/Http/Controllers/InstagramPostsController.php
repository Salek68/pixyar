<?php

namespace App\Http\Controllers;

use App\Models\ApiRequest;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InstagramPostsController extends Controller
{
    /**
     * دریافت و ذخیره پست‌های یک پروفایل اینستاگرام
     */
    public function fetchPosts(Request $request)
    {
        $request->validate([
            'page_id' => 'required|string'
        ]);

        $userId = Auth::id(); // اگر کاربر لاگین نبود، پیشفرض 1
        $username = $request->page_id;

        // پیدا کردن پروفایل
        $profile = InstagramProfile::where('username', $username)->first();
        if (!$profile) {
            return response()->json([
                'message' => 'پروفایل یافت نشد. ابتدا پروفایل را ثبت کنید.'
            ], 404);
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
            'user_id'         => $userId,
            'endpoint'        => '/v1/post',
            'response_time_ms'=> $responseTime,
            'status_code'     => $response->status(),
            'response_size'   => $responseSize,
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'خطا در دریافت پست‌ها'], 500);
        }

        $postsData = $response->json()['data']['items'] ?? [];

        foreach ($postsData as $post) {
            InstagramPost::updateOrCreate(
                [
                    'profile_id' => $profile->id,
                    'shortcode'  => $post['code'] ?? 'null',
                ],
                [
                    'media_type'    => $post['media_format'] ?? 'image',
                    'media_url'     => $post['video_url'] ?? 'null',
                    'thumbnail_url' => $post['thumbnail_url'] ?? 'null',
                    'caption'       => $post['caption']['text'] ?? 'null',
                    'hashtags'      => json_encode($post['caption']['hashtags'] ?? []),
                    'mentions'      => json_encode($post['caption']['mentions'] ?? []),
                    'likes_count'   => $post['like_count'] ?? 0,
                    'comments_count'=> $post['comment_count'] ?? 0,
                    'views_count'   => $post['play_count'] ?? 0,
                    'is_sponsored'  => $post['is_sponsored'] ?? 0,
                    'posted_at'     => isset($post['taken_at_date'])
                                        ? date('Y-m-d H:i:s', strtotime($post['taken_at_date']))
                                        : null,
                ]
            );
        }

        // محاسبه میانگین لایک و کامنت
        $posts = InstagramPost::where('profile_id', $profile->id)->get();

        if ($posts->count() === 0) {
            return response()->json(['message' => 'هیچ پستی یافت نشد.'], 200);
        }

        $like_sum = $posts->sum('likes_count');
        $comment_sum = $posts->sum('comments_count');

        $like_avg = $like_sum / $posts->count();
        $comment_avg = $comment_sum / $posts->count();

        $followers = $profile->followers_count ?: 1; // جلوگیری از تقسیم بر صفر
        $engagement_rate = (($like_avg + $comment_avg) / $followers) * 100;

        $profile->update([
            'engagement_rate' => $engagement_rate,
            'avg_likes'       => $like_avg,
            'avg_comments'    => $comment_avg,
        ]);

        // ذخیره کامنت‌ها برای هر پست
        foreach ($posts as $post) {
            app(InstagramCommentsController::class)
                ->StoreComments($post->id, $post->shortcode);
        }

        return response()->json([
            'message' => 'پست‌ها با موفقیت دریافت و ذخیره شدند.',
            'count'   => count($postsData)
        ]);
    }
}

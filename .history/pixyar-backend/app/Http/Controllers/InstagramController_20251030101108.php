<?php

namespace App\Http\Controllers;

use App\Models\ApiRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\InstagramProfile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\InstagramPostsController;

class InstagramController extends Controller
{
    /**
     * دریافت اطلاعات پروفایل اینستاگرام کاربر
     */
    public function fetchProfile(Request $request)
    {
        function getClientIpFromRequest(\Illuminate\Http\Request $request): ?string
{
    // اگر X-Forwarded-For هست، اولین آدرس واقعی معمولاً اولی است
    $xff = $request->header('X-Forwarded-For');
    if ($xff) {
        $parts = array_map('trim', explode(',', $xff));
        foreach ($parts as $p) {
            if (filter_var($p, FILTER_VALIDATE_IP)) {
                return $p;
            }
        }
    }

    // Cloudflare special header
    if ($request->header('CF-Connecting-IP') && filter_var($request->header('CF-Connecting-IP'), FILTER_VALIDATE_IP)) {
        return $request->header('CF-Connecting-IP');
    }

    // fallback به متد پیش‌فرض لاراول
    $ip = $request->ip();
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : null;
}




        $request->validate([
            'username' => 'required|string'
        ]);

        $userId = Auth::id(); // اگر کاربر لاگین نبود، پیشفرض 1
        $username = $request->username;
$startTime = microtime(true);
        // فراخوانی API واقعی با هدرها
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'simple-instagram-api.p.rapidapi.com',
            'x-rapidapi-key' => '26d6bc2669msh34bc749da31f3a5p10fb9ajsnbbbf46a26c5d'
        ])->get("https://simple-instagram-api.p.rapidapi.com/account-info", [
            'username' => $username
        ]);
$endTime = microtime(true);

$responseTime = round(($endTime - $startTime) * 1000, 2); // تبدیل به میلی‌ثانیه
$responseSize = strlen($response->body());

ApiRequest::create([
    'user_id' =>$userId,
    'endpoint' => '/v1/profile',
    'response_time_ms' => $responseTime,
    'status_code' => $response->status(),
    'response_size' => $responseSize,
]);

$ip = getClientIpFromRequest($request);

ActivityLog::create([
 'user_id' =>$userId,
  'action' => 'ساخت پیج و دریافت اطلاعات پست ها و کامنت و..',
   'metadata' =>$userId,
 'ip_address' =>$ip,
]);
        if ($response->failed()) {
            return response()->json(['message' => 'خطا در دریافت اطلاعات پروفایل'], 500);
        }

        $data = $response->json();

        // ذخیره در دیتابیس با updateOrCreate
        $profile = InstagramProfile::updateOrCreate(
            [
                'user_id' => $userId,
                'username' => $username
            ],
            [

    'full_name'        => $data['full_name'] ?? '',
    'profile_pic'      => $data['profile_pic_url_hd'] ?? ($data['profile_pic_url'] ?? ''),
    'biography'        => $data['biography'] ?? '',
    'website'          => $data['external_url'] ?? ($data['website'] ?? ''),
    'is_verified'      => $data['is_verified'] ?? false,
    'followers_count'  => $data['edge_followed_by']['count'] ?? 0,
    'following_count'  => $data['edge_follow']['count'] ?? 0,
    'posts_count'      => $data['edge_owner_to_timeline_media']['count'] ?? 0,
    'country'          => $data['location']['name'] ?? null,
    'language'         => $data['language'] ?? null,
    'account_type'     => (!empty($data['is_business_account']) && $data['is_business_account'] ? 'business' :
                           (!empty($data['is_professional_account']) && $data['is_professional_account'] ? 'creator' :
                           'personal')),
    'engagement_rate'  => $data['engagement_rate'] ?? 0,
    'avg_likes'        => $data['edge_media_to_caption']['edges'][0]['node']['text'] ?? 0,  // ← فقط نمونه، باید محاسبه دقیق‌تر شود
    'avg_comments'     => $data['edge_media_to_comment']['count'] ?? 0,

                'fetched_at' => now()
            ]
        );


         $postsController = new InstagramPostsController();
    $postsController->fetchPosts($request);
 $profile = InstagramProfile::where('username', $username)->first();
        return response()->json([
            'message' => 'اطلاعات پروفایل دریافت و ذخیره شد',
            'profile' => $profile
        ]);
    }


    public function index(Request $request)
    {
        $profiles = InstagramProfile::where('user_id', $request->user()->id)->get();
        return response()->json($profiles);
    }

    /**
     * حذف یک پروفایل
     */
    public function delete(Request $request, $id)
    {
        $profile = InstagramProfile::where('user_id', $request->user()->id)->findOrFail($id);
        $profile->delete();
        return response()->json(['message' => 'پروفایل حذف شد']);
    }

    /**
     * تحلیل داده‌ها (میانگین تعامل و جمع فالوورها)
     */
    public function analytics(Request $request)
    {
        $profiles = InstagramProfile::where('user_id', $request->user()->id)->get();

        $avgEngagement = $profiles->avg('engagement_rate');
        $totalFollowers = $profiles->sum('followers_count');
        $totalFollowing = $profiles->sum('following_count');
        $totalPosts = $profiles->sum('posts_count');

        return response()->json([
            'avg_engagement' => $avgEngagement,
            'total_followers' => $totalFollowers,
            'total_following' => $totalFollowing,
            'total_posts' => $totalPosts
        ]);
    }

}

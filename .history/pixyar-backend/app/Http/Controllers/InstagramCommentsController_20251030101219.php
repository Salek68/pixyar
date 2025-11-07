<?php

namespace App\Http\Controllers;

use App\Models\ApiRequest;
use Illuminate\Http\Request;
use App\Models\InstagramPost;
use App\Models\InstagramComment;
use App\Models\InstagramProfile;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class InstagramCommentsController extends Controller
{
   public function StoreComments($postid,$postcode)
    {

  $userId = Auth::id();
   $startTime = microtime(true);
        // فراخوانی API برای دریافت پست‌ها
        $response = Http::withHeaders([
            'X-Rapidapi-Key' => '26d6bc2669msh34bc749da31f3a5p10fb9ajsnbbbf46a26c5d',
            'X-Rapidapi-Host' => 'instagram-social-api.p.rapidapi.com'
        ])->get("https://instagram-social-api.p.rapidapi.com/v1/comments", [
            'code_or_id_or_url' => $postcode
        ]);
$endTime = microtime(true);

$responseTime = round(($endTime - $startTime) * 1000, 2); // تبدیل به میلی‌ثانیه
$responseSize = strlen($response->body());

ApiRequest::create([
    'user_id' =>$userId,
    'endpoint' => '/v1/comments',
    'response_time_ms' => $responseTime,
    'status_code' => $response->status(),
    'response_size' => $responseSize,
]);


        if ($response->failed()) {
            return response()->json(['message' => 'خطا در دریافت'], 500);
        }

        $postsData = $response->json()['data']['items'] ?? [];

        foreach ($postsData as $post) {
 InstagramComment::updateOrCreate(
    [
        'post_id' => $postid,
        'username' => $post['user']['username']?? 'null',
    ],
    [

        'text' => $post['text'] ?? 'image',

    ]
);
        }




    }
}

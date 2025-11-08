<?php

namespace App\Jobs;

use App\Models\ApiRequest;
use App\Models\ActivityLog;
use App\Models\InstagramPost;
use Illuminate\Bus\Queueable;
use App\Models\InstagramComment;
use App\Models\InstagramProfile;
use App\Models\InstagramProfileSnapshot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAllApis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $username;
    protected $userId;

    public function __construct($username, $userId)
    {
        $this->username = $username;
        $this->userId = $userId;
    }

    public function handle()
    {
        set_time_limit(0);
        ignore_user_abort(true);

        // ===================
        // 1. Fetch Profile
        // ===================
        $startTime = microtime(true);

$url = 'https://simple-instagram-api.p.rapidapi.com/account-info';
$query = http_build_query([
    'username' => $this->username,
    'host' => 'simple-instagram-api.p.rapidapi.com'
    ,'url' => $url
]);

$response = Http::get("https://proxy-steel-beta-96.vercel.app/api/proxy?$query");


        $endTime = microtime(true);

        ApiRequest::create([
            'user_id' => $this->userId,
            'endpoint' => '/v1/profile',
            'response_time_ms' => round(($endTime - $startTime) * 1000, 2),
            'status_code' => $response->status(),
            'response_size' => strlen($response->body())
        ]);

        if ($response->failed()) return;

        $data = $response->json();

   $profile = InstagramProfile::updateOrCreate(
            ['user_id'=>$this->userId,'username'=>$this->username],
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
                'avg_likes'        => data_get($data, 'edge_media_to_caption.edges.0.node.text', 0),
                'avg_comments'     => $data['edge_media_to_comment']['count'] ?? 0,
                'fetched_at' => now()
            ]
        );


        ActivityLog::create([
            'user_id' => $this->userId,
            'action' => 'Fetch Profile',
            'metadata' => $profile,
            'ip_address' => null
        ]);

        // ===================
        // 2. Fetch Posts
        // ===================
        $startTime = microtime(true);

$responsePosts = Http::get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
    'url' => 'https://instagram-social-api.p.rapidapi.com/v1/posts',
    'host' => 'instagram-social-api.p.rapidapi.com',
    'username_or_id_or_url' => $this->username
]);

        $endTime = microtime(true);

        ApiRequest::create([
            'user_id' => $this->userId,
            'endpoint' => '/v1/posts',
            'response_time_ms' => round(($endTime - $startTime) * 1000, 2),
            'status_code' => $responsePosts->status(),
            'response_size' => strlen($responsePosts->body())
        ]);

        $postsData = $responsePosts->json()['data']['items'] ?? [];

        foreach($postsData as $post){
            $postModel = InstagramPost::updateOrCreate(
                ['profile_id'=>$profile->id,'shortcode'=>$post['code']??'null'],
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

            // ===================
            // 3. Fetch Comments
            // ===================
            $startTime = microtime(true);

       $responseComments = Http::get("https://proxy-steel-beta-96.vercel.app/api/proxy", [
    'url' => 'https://instagram-social-api.p.rapidapi.com/v1/comments',
    'host' => 'instagram-social-api.p.rapidapi.com',
    'code_or_id_or_url' => $post['code']
]);



            $endTime = microtime(true);

            ApiRequest::create([
                'user_id' => $this->userId,
                'endpoint' => '/v1/comments',
                'response_time_ms' => round(($endTime - $startTime) * 1000, 2),
                'status_code' => $responseComments->status(),
                'response_size' => strlen($responseComments->body())
            ]);

            $commentsData = $responseComments->json()['data']['items'] ?? [];
            foreach($commentsData as $comment){
                InstagramComment::updateOrCreate(
                    ['post_id'=>$postModel->id,'username'=>$comment['user']['username']??'null'],
                    ['text'=>$comment['text']??'image']
                );
            }
        }
  $postss = InstagramPost::where('profile_id', $profile->id)->get();

        if ($postss->count() === 0) {
            return response()->json(['message' => 'هیچ پستی یافت نشد.'], 200);
        }

        $like_sum = $postss->sum('likes_count');
        $comment_sum = $postss->sum('comments_count');

        $like_avg = $like_sum / $postss->count();
        $comment_avg = $comment_sum / $postss->count();

        $followers = $profile->followers_count ?: 1; // جلوگیری از تقسیم بر صفر
        $engagement_rate = (($like_avg + $comment_avg) / $followers) * 100;

        $profile->update([
            'engagement_rate' => $engagement_rate,
            'avg_likes'       => $like_avg,
            'avg_comments'    => $comment_avg,
        ]);

        $profile_snapshot = InstagramProfileSnapshot::create(
    [
        'profile_id' => $profile->id,
        'followers_count'  => $data['edge_followed_by']['count'] ?? 0,
        'following_count'  => $data['edge_follow']['count'] ?? 0,
        'posts_count'      => $data['edge_owner_to_timeline_media']['count'] ?? 0,
         'engagement_rate' => $engagement_rate,
            'avg_likes'       => $like_avg,
            'avg_comments'    => $comment_avg,
    ]
);

    }
}

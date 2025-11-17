@extends('admin.layout.master')
@section('route')
داشبورد - {{$profiles->full_name}}
@endsection
@section('srcprofile')
https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($profiles->profile_pic ?? asset('admin/img/pro.jpg')) }}
@endsection 
@section('main-content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- اول Vue -->

<div class="main-content" id="admin-app">
    <div class="row no-gutters font-size-13 margin-bottom-10">
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> تعداد فالور  ها </p>
            <p>{{$profiles->followers_count}}</p>

        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> تعداد فالوینگ ها</p>
            <p>{{$profiles->following_count}}</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>تعداد پست ها</p>
            <p>{{$profiles->posts_count}}</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
            <p>نرخ تعامل کاربر </p>
        <p>{{$profiles->engagement_rate}} %</p>
        </div>




    @foreach($posts as $post)
    <div class="col-3 padding-20 border-radius-3 bg-white  margin-bottom-10 " style="margin-right: 8px;">
        <div class="instagram-card mb-4 shadow-sm border-radius-3 p-2">

            {{-- تصویر یا ویدیو با ابعاد ثابت --}}
            @if($post->media_type == 'image')
                <img src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->thumbnail_url) }}" alt="Post Image" class="w-100 instagram-media mb-2">
            @elseif($post->media_type == 'video')
                <video controls class="w-100 instagram-media mb-2">
                    <source src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->media_url) }}" type="video/mp4">
                    مرورگر شما ویدیو را پشتیبانی نمی‌کند.
                </video>
            @endif

            {{-- کپشن --}}
            @if($post->caption)
            <p class="caption font-size-12 mb-1">{{ Str::limit($post->caption, 50) }}</p>
            @endif

            {{-- هشتگ‌ها از آرایه --}}
            @if(is_array($post->hashtags) && count($post->hashtags) > 0)
            <p class="hashtags font-size-11 mb-1">
                @foreach($post->hashtags as $hashtag)
                    <span class="text-blue">#{{ $hashtag }}</span>
                @endforeach
            </p>
            @endif

            {{-- تعداد لایک و کامنت --}}
            <div class="d-flex justify-content-between font-size-11 text-muted">
                <span>❤️ {{ $post->likes_count }}</span>
                <span>💬 {{ $post->comments_count }}</span>
                @if($post->views_count)
                <span>👁️ {{ $post->views_count }}</span>
                @endif
            </div>

            {{-- لینک کوتاه --}}
            @if($post->shortcode)
            <a href="{{ route('AdminPanel.Sh', ['idprofile'=>$profiles->id , 'idpost'=>$post->id]) }}" target="_blank" class="font-size-11 text-primary d-block mt-1">مشاهده پست</a>
            @endif
        </div>
    </div>
    @endforeach


<style>
.instagram-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s;
}
.instagram-card:hover {
    transform: translateY(-3px);
}
.instagram-media {
    max-height: 1920px;
    width: 100%;
    height: 100%; /* ارتفاع ثابت برای تصویر و ویدیو */
    object-fit: cover;
    border-radius: 6px;
}
.caption {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.hashtags span {
    margin-right: 4px;
    display: inline-block;
}
.text-blue {
    color: #0095f6;
}
</style>


    </div>

@endsection

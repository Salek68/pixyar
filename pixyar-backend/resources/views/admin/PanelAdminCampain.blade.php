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





    @foreach($posts as $post)
    <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10" style="margin-right: 8px;">
    <div class="instagram-card mb-4 shadow-sm border-radius-3 p-2">

        {{-- تصویر یا ویدیو --}}
        {{-- @if($post->media_type == 'image')
            <img src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->thumbnail_url) }}" alt="Post Image" class="w-100 instagram-media mb-2">
        @elseif($post->media_type == 'video')
            <video controls class="w-100 instagram-media mb-2">
                <source src="https://proxy-steel-beta-96.vercel.app/api/proxy-image?url={{ urlencode($post->media_url) }}" type="video/mp4">
                مرورگر شما ویدیو را پشتیبانی نمی‌کند.
            </video>
        @endif --}}

        {{-- کپشن --}}
        @if($post->campaign_title)
            <p class="caption font-size-12 mb-1" style="font-weight: bolder;">عنوان کمپین : </p>
        <p class="caption font-size-12 mb-1">{{ $post->campaign_title }}</p>
                    <p class="caption font-size-12 mb-1" style="font-weight: bolder;">جزییات کمپین : </p>
        <p class="caption font-size-12 mb-1">{{ $post->campaign_description }}</p>
                    <p class="caption font-size-12 mb-1" style="font-weight: bolder;">متن کپشن : </p>
            <p class="caption font-size-12 mb-1">{{ $post->suggested_post_caption }}</p>
        @endif

        {{-- هشتگ‌ها --}}
       {{-- @php
    $hashtags = is_array($post->suggested_post_hashtags)
        ? $post->suggested_post_hashtags
        : explode(',', $post->suggested_post_hashtags);
@endphp

@if(count($hashtags) > 0)
    <div class="hashtags font-size-11 mb-1 flex flex-wrap gap-2">
        @foreach($hashtags as $hashtag)
            <span class="text-blue inline-block">#{{ trim($hashtag) }}</span>
        @endforeach
    </div>
@endif --}}


        {{-- تعداد لایک و کامنت --}}
        <div class="d-flex justify-content-between font-size-11 text-muted mt-1">
             <p class="caption font-size-12 mb-1">{{ $post->insights }}</p>
        </div>

    </div>
</div>

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
    height: auto; /* اندازه خودکار تا نسبت تصویر حفظ شود */
    object-fit: cover;
    border-radius: 6px;
}
.caption {
    max-height: max-content !important; /* حدود 2 خط */
    overflow: hidden;
    line-height: 1.8em;
    text-overflow: ellipsis;
}

.text-blue {
    color: #0095f6;
}
</style>

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
/* .caption {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
} */
/* .hashtags span {
    margin-right: 4px;
    display: inline-block;
} */
.text-blue {
    color: #0095f6;
}
</style>


    </div>

@endsection

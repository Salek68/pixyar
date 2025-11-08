@extends('admin.layout.master')
@section('route')
داشبورد - {{$profiles->full_name}}
@endsection
@section('srcprofile')
 {{$profiles->profile_pic}}
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
 <div class="row bg-white no-gutters font-size-13" style="margin-bottom: 10px;">
        <div class="title__row">
            <p>پست  های اخیر </p>
            <a class="all-reconcile-text margin-left-20 color-2b4a83">نمایش همه پست ها</a>
        </div>
        {{-- <div class="table__box">
            <table width="100%" class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه تخفیف</th>
                    <th>عنوان</th>
                    <th>توضیحات</th>
                    <th>درصد تخفیف</th>
                    <th>تاریخ شروع تخفیف</th>
                    <th>تاریخ پایان تخفیف</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
          @foreach ($discount as $item)
          <tr role="row">
            <td><a href=""> {{$item->id}}</a></td>
            <td><a href=""> {{$item->title}}</a></td>
            <td><a href=""> {{$item->description}}</a></td>
            <td><a href=""> {{$item->discount_percent}}</a></td>
            <td><a href="">{{ \Morilog\Jalali\Jalalian::fromDateTime($item->start_date)->format('Y/m/d') }}</a></td>
            <td><a href="">{{ \Morilog\Jalali\Jalalian::fromDateTime($item->end_date)->format('Y/m/d') }}</a></td>
            <td><a href=""  style="color: {{ \Carbon\Carbon::parse($item->end_date)->isPast() ? 'red' : 'green' }};">  ({{ \Carbon\Carbon::parse($item->end_date)->isPast() ? 'منقضی' : 'فعال' }})</a></td>
            <td class="i__oprations">

                <a href="{{ route('AdminPanel.Discounts.Remove', ['id'=>$item->id]) }}" class="item-delete margin-left-10" title="حذف"></a>
                <a href="{{ route('AdminPanel.DiscountDeactive', ['id'=>$item->id]) }}" class="item-lock margin-left-10" title='غیر فعال کردن'></a>
                <a href="{{ route('AdminPanel.DiscountUpdate.Index', ['id'=>$item->id]) }}" class="item-edit" title='  ویرایش'></a>
            </td>
        </tr>
          @endforeach

                </tbody>
            </table>
        </div> --}}
    </div>
    {{-- <script>

        var chartLabels = @json($labels);
        var chartData = @json($values);

                document.addEventListener("DOMContentLoaded", function () {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar', // نوع نمودار (bar, line, pie, etc.)
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: ' نمودار بازدید هفت روز گذشته',
                                data: chartData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });









         var chartLabels2 = @json($labels2);
        var chartData2 = @json($values2);

                document.addEventListener("DOMContentLoaded", function () {
                    var ctx2 = document.getElementById('myChart2').getContext('2d');
                    var myChart2 = new Chart(ctx2, {
                        type: 'bar', // نوع نمودار (bar, line, pie, etc.)
                        data: {
                            labels: chartLabels2,
                            datasets: [{
                                label: ' نمودار ثبت تخفیف هفت روز گذشته',
                                data: chartData2,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script> --}}
    <div class="row no-gutters font-size-13 margin-bottom-10">
        <div class="col-6 padding-20 bg-white margin-bottom-10 margin-left-10 border-radius-3">

            <canvas id="myChart" width="400" height="200"></canvas>

        </div>
        <div class="col-6 info-amount padding-20 bg-white margin-bottom-12-p margin-bottom-10 border-radius-3">
            <canvas id="myChart2" width="400" height="200"></canvas>

        </div>
    </div>

</div>

@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
<title> پنل مدیریت | ادمین</title>    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/responsive_991.css') }}" media="(max-width:991px)">
    <link rel="stylesheet" href={{ asset('admin/css/responsive_768.css') }}" media="(max-width:768px)">
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    @vite('resources/css/app.css')

</head>
<body id="body">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('service-worker-registration.js') }}"></script>
<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://netcopy.ir"></a>
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img"><img src="@yield('srcprofile')" class="avatar___img">

        </div>
         <span class="profile__name">

            {{-- @php
             if(session('user_name')){
                $userName = Crypt::decrypt(session('user_name'));
            }

        @endphp
        @isset($userName)
{{$userName}}
        @endisset --}}

    </span>
    </div>

    <ul>
        {{-- @if (session('user_ac'))
        @foreach (session('user_ac') as $item )
        @if ($item->pos != "all")
        <li class="item-li {{ $item->i }} @isset($is_active)  @if ($is_active == $item->id) is-active @endif @endisset">
            <a href="{{ route($item->route) }}">{{ $item->pos }}</a>
        </li>
        @else
        @php
            $all = true;
        @endphp
        @endif




        @endforeach
    @else

    @endif --}}
    <li class="item-li i-dashboard"><a href="{{ route('AdminPanel.Index',['id' => $idprofile]) }}">پیشخوان</a></li>
    <li class="item-li i-categories"><a href="{{ route('AdminPanel.bestTimeHeatmap' ,['idprofile' => $idprofile]) }}">  تقویم محتوایی </a></li>
    <li class="item-li i-discounts"><a href="{{ route('AdminPanel.followersGrowth' ,['idprofile' => $idprofile]) }}">  نمودار رشد فالوئرها</a></li>
    <li class="item-li i-notification__management"><a href="{{ route('AdminPanel.Raghib' ,['idprofile' => $idprofile]) }}">رقبا چه کردند؟ </a></li>
    </ul>

</div>
<div class="content">
    <div class="header d-flex item-center bg-white width-100 border-bottom padding-12-30">
        <div class="header__right d-flex flex-grow-1 item-center">
            <span class="bars"></span>
            <a class="" href="">
                 {{-- @php
                if(session('store_name')){
                    $userName = Crypt::decrypt(session('store_name'));
                }

            @endphp
            @isset($userName)
   فروشگاه : {{$userName}}
            @endisset --}}
        </a>
        </div>
        <div class="header__left d-flex flex-end item-center margin-top-2">
            {{-- <span class="account-balance font-size-12">موجودی : 2500,000 تومان</span> --}}
            <div class="notification margin-15">
                <a class="notification__icon"></a>
                <div class="dropdown__notification">
                    <div class="content__notification">
                        <span class="font-size-13">موردی برای نمایش وجود ندارد</span>
                    </div>
                </div>
            </div>
            <a href="#logout" class="logout" title="خروج"></a>
        </div>
    </div>
    <div class="breadcrumb">
        <ul>
            <li><a href="index.html" title="@yield('route')">@yield('route')</a></li>
          </ul>
    </div>

@yield('main-content')

</div>
</body>
<script src="{{ asset('admin/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('admin/js/js.js') }}"></script>
</html>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>پیکس یار - مدیریت هوشمند شبکه‌های اجتماعی</title>

  {{-- keep your Vite assets exactly --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- AOS + Swiper styles (kept) --}}
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <style>
    /* ---------- Visual polish & small component styles ---------- */

    /* Glass navbar blur */
    .glass-nav {
      backdrop-filter: blur(8px);
      background: linear-gradient(180deg, rgba(255,255,255,0.70), rgba(255,255,255,0.48));
    }
    @media (prefers-color-scheme: dark) {
      .glass-nav {
        background: linear-gradient(180deg, rgba(8,10,15,0.72), rgba(8,10,15,0.56));
      }
    }

    /* Person rings modern animation */
    .ring {
      position: absolute;
      border-radius: 9999px;
      pointer-events: none;
      mix-blend-mode: screen;
      opacity: 0.9;
      animation: ringFloat 5.5s ease-in-out infinite;
    }
    .ring.slow { animation-duration: 8s; }
    .ring.fast { animation-duration: 4.2s; }

    @keyframes ringFloat {
      0%   { transform: translateY(0) scale(1); opacity: .95; }
      50%  { transform: translateY(-18px) scale(1.03); opacity: .75; }
      100% { transform: translateY(0) scale(1); opacity: .95; }
    }

    /* subtle focus outline for keyboard nav */
    :focus { outline: 3px solid rgba(99,102,241,0.15); outline-offset: 2px; }

    /* small restoration for swiper pagination dots */
    .swiper-pagination-bullet {
      height: 8px;
      width: 32px;
      border-radius: 9999px;
      opacity: .45;
      transition: all .3s ease;
    }
    .swiper-pagination-bullet-active { opacity: 1; transform: scale(1.05); }

    /* Keep images nicely rounded in cards */
    .card-img {
      border-radius: .75rem;
      object-fit: cover;
    }

    /* mobile-first height helpers */
    .hero-h {
      min-height: calc(85vh - 64px) !important;
        max-height: calc(85vh - 64px) !important;
    }

    /* ensure right-to-left scrollbar thumb looks decent */
    ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.08); border-radius: 8px; }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased selection:bg-indigo-200 selection:text-indigo-900">

<!-- NAVBAR (sticky + glass) -->
<nav class="glass-nav fixed inset-x-0 top-0 z-50 border-b border-gray-100/60 dark:border-gray-800/60">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- logo -->
      <div class="flex items-center gap-3">
        <a href="/" class="flex items-center gap-3">
          <img src="{{ asset('images/logo.png') }}" alt="Pixyar Logo" class="h-9 w-auto" />
        </a>
        <span class="hidden sm:inline-block text-sm font-semibold text-gray-700">پیکس یار</span>
      </div>

      <!-- desktop links -->
      <div class="hidden md:flex items-center gap-6">
        <a href="#banner" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">خانه</a>
        <a href="#why" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">چرا پیکس یار؟</a>
        <a href="#features" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">ویژگی‌ها</a>
        <a href="#contact" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">تماس با ما</a>
        <a href="{{ route('login') }}" class="ml-2 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-white text-sm font-semibold shadow hover:bg-indigo-500 transition">
          ثبت نام
        </a>
      </div>

      <!-- mobile controls -->
      <div class="md:hidden flex items-center">
        <button id="mobile-toggle" aria-expanded="false" aria-controls="mobile-menu" class="p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:ring-2 focus:ring-indigo-300">
          <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- mobile menu (hidden by default) -->
  <div id="mobile-menu" class="md:hidden hidden px-4 pb-6 pt-2 border-t border-gray-100/60">
    <div class="space-y-2">
      <a href="#banner" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50">خانه</a>
      <a href="#why" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50">چرا پیکس یار؟</a>
      <a href="#features" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50">ویژگی‌ها</a>
      <a href="#contact" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50">تماس با ما</a>
      <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-center bg-indigo-600 text-white font-semibold hover:bg-indigo-500">ثبت نام</a>
    </div>
  </div>
</nav>

<!-- HERO / BANNER -->
<header id="banner" class="relative hero-h pt-16">
  <!-- slider background (Swiper) -->
  <div class="absolute inset-0 -z-10">
    <div class="swiper heroSwiper h-full">
      <div class="swiper-wrapper h-full">
        <div class="swiper-slide bg-cover bg-center" style="background-image:url('https://bdbd.ir/wp-content/uploads/2022/09/Layer-3.png');"></div>
        <div class="swiper-slide bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1950&q=80');"></div>
        <div class="swiper-slide bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1950&q=80');"></div>
      </div>
    </div>
    <!-- soft overlay gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-indigo-800/10 via-white/30 to-white/60 dark:from-indigo-900/20 dark:via-black/10"></div>
  </div>

  <!-- hero container -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
    <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
      <!-- left: content -->
      <div class="px-2 text-center lg:text-right" data-aos="fade-up">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
          مدیریت هوشمند شبکه‌های اجتماعی — <span class="text-indigo-600">پیکس یار</span>
        </h1>
        <p class="mt-4 text-gray-600 dark:text-gray-300 max-w-xl mx-auto lg:mx-0" style="color: black;">
          پیکس یار راهکاری جامع برای مدیریت شبکه‌های اجتماعی کسب‌وکار شماست که همه نیازهایتان را پوشش می‌دهد.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row sm:justify-center lg:justify-end gap-3">
          <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-indigo-600 to-violet-500 px-6 py-3 text-white font-semibold shadow-lg hover:scale-[1.02] transform transition">
            ثبت نام رایگان
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-full border border-gray-200 bg-white px-5 py-3 text-sm font-medium hover:shadow hover:translate-y-[-2px] transition">
            مشاهده ویژگی‌ها
          </a>
        </div>

        {{-- <!-- small trust badges -->
        <div class="mt-6 flex items-center justify-center lg:justify-end gap-4 text-xs text-gray-500">
          <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-500" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
            <span>راه‌اندازی سریع</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-500" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>گزارش‌گیری پیشرفته</span>
          </div>
        </div>
      </div> --}}


    </div>
  </div>
  <!-- right: person image with animated rings -->

  <!-- hero pagination / controls (visually subtle) -->
  <div class="absolute left-4 bottom-6 right-4 flex justify-center md:justify-start z-10">
    <div class="swiper-pagination-hero"></div>
  </div>
</header>

<!-- WHY (Features overview, 2-col on large) -->
<section id="why" class="pt-16 pb-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
      <h2 class="text-2xl sm:text-3xl font-bold">چرا پیکس یار؟</h2>
      <p class="mt-3 text-gray-600">پیکس یار راهکاری جامع برای مدیریت شبکه‌های اجتماعی کسب‌وکار شماست که همه نیازهایتان را پوشش می‌دهد.</p>
    </div>


    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      <!-- left: cards -->
      <div class="space-y-6">
        <article class="group bg-gray-50 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
          <div class="flex items-start gap-4">
            <div class="flex-none rounded-xl bg-indigo-50 p-3">
              <svg class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold">تحلیل دقیق داده‌ها</h3>
              <p class="mt-1 text-sm text-gray-600">تمام داده‌های شبکه‌های اجتماعی شما جمع‌آوری و تحلیل می‌شود تا تصمیمات هوشمندانه بگیرید.</p>
            </div>
          </div>
        </article>

        <article class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition">
          <div class="flex items-start gap-4">
            <div class="flex-none rounded-xl bg-indigo-50 p-3">
              <svg class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8M8 12h8"/></svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold">زمان‌بندی و اتوماسیون</h3>
              <p class="mt-1 text-sm text-gray-600">پست‌ها و دایرکت‌ها را خودکار زمان‌بندی کنید و وقت خود را صرف کارهای مهم‌تر کنید.</p>
            </div>
          </div>
        </article>

        <article class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition">
          <div class="flex items-start gap-4">
            <div class="flex-none rounded-xl bg-indigo-50 p-3">
              <svg class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14"/></svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold">گزارش‌ها و آمار</h3>
              <p class="mt-1 text-sm text-gray-600">با گزارش‌ها و نمودارهای دقیق عملکرد پیج خود را مشاهده کنید و رشد کسب‌وکار خود را دنبال کنید.</p>
            </div>
          </div>
        </article>
      </div>

      <!-- right: visual / compact features list -->
      <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-6 shadow-inner">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex items-start gap-3 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition">
            <div class="flex-none rounded-lg p-2 bg-indigo-100">
              <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/></svg>
            </div>
            <div>
              <h4 class="text-sm font-medium">تحلیل زمان واقعی</h4>
              <p class="text-xs text-gray-500">اطلاعات همیشه به روز</p>
            </div>
          </div>

          <div class="flex items-start gap-3 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition">
            <div class="flex-none rounded-lg p-2 bg-indigo-100">
              <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z"/></svg>
            </div>
            <div>
              <h4 class="text-sm font-medium">مدیریت چند حساب</h4>
              <p class="text-xs text-gray-500">همه پیج‌ها در یک داشبورد</p>
            </div>
          </div>

          <div class="flex items-start gap-3 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition">
            <div class="flex-none rounded-lg p-2 bg-indigo-100">
              <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg>
            </div>
            <div>
              <h4 class="text-sm font-medium">اتوماسیون هوشمند</h4>
              <p class="text-xs text-gray-500">واکنش خودکار به مشتریان</p>
            </div>
          </div>

          <div class="flex items-start gap-3 p-3 bg-white rounded-xl shadow-sm hover:shadow-md transition">
            <div class="flex-none rounded-lg p-2 bg-indigo-100">
              <svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
            </div>
            <div>
              <h4 class="text-sm font-medium">پشتیبانی ۲۴/۷</h4>
              <p class="text-xs text-gray-500">تیم ما همیشه همراه شماست</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES CAROUSEL (Swiper) -->
<section id="features" class="py-12 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">
      <h2 class="text-xl sm:text-2xl font-bold" data-aos="fade-up">ویژگی‌های پیکس یار</h2>
      <p class="text-sm text-gray-500" data-aos="fade-up" data-aos-delay="80">ابزارهایی برای رشد و نظم در مدیریت شبکه‌های اجتماعی</p>
    </div>

    <div class="mt-6">
      <div class="swiper featuresSwiper" data-aos="fade-up" data-aos-delay="120">
        <div class="swiper-wrapper">
          <!-- slide 1 -->
          <div class="swiper-slide px-2">
            <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition h-full flex flex-col">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-lg font-semibold">تحلیل دقیق</h3>
                  <p class="mt-2 text-sm text-gray-600">تمام داده‌های پیج خود را جمع‌آوری و تحلیل کنید و گزارش‌های دقیق بگیرید.</p>
                </div>
                <div class="flex-none text-4xl">📊</div>
              </div>
              <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">
                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1">گزارش لحظه‌ای</span>
                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1">CSV / PDF</span>
              </div>
            </div>
          </div>

          <!-- slide 2 -->
          <div class="swiper-slide px-2">
            <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition h-full flex flex-col">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-lg font-semibold">زمان‌بندی پست‌ها</h3>
                  <p class="mt-2 text-sm text-gray-600">پست‌ها و استوری‌ها را به راحتی زمان‌بندی کنید و تعامل پیج خود را افزایش دهید.</p>
                </div>
                <div class="flex-none text-4xl">📝</div>
              </div>
              <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">
                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1">تقویم بصری</span>
                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1">از پیش‌تنظیم‌ها</span>
              </div>
            </div>
          </div>

          <!-- slide 3 -->
          <div class="swiper-slide px-2">
            <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition h-full flex flex-col">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-lg font-semibold">پاسخ خودکار</h3>
                  <p class="mt-2 text-sm text-gray-600">کامنت‌ها و دایرکت‌ها را خودکار پاسخ دهید و وقت خود را ذخیره کنید.</p>
                </div>
                <div class="flex-none text-4xl">🤖</div>
              </div>
              <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">
                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1">قوانین پیشرفته</span>
                <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-2 py-1">یکپارچه‌سازی</span>
              </div>
            </div>
          </div>

          <!-- you can add more slides here -->
        </div>

        <!-- pagination + arrows -->
        <div class="mt-6 flex items-center justify-between">
          <div class="swiper-pagination-features"></div>
          <div class="flex gap-2">
            <button class="prev-feature p-2 rounded-lg bg-white shadow hover:bg-gray-50" aria-label="قبلی">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="next-feature p-2 rounded-lg bg-white shadow hover:bg-gray-50" aria-label="بعدی">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section id="stats" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
      <div data-aos="fade-up">
        <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">1.2K+</div>
        <p class="mt-2 text-sm text-gray-600">کاربر فعال</p>
      </div>
      <div data-aos="fade-up" data-aos-delay="80">
        <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">3.5K+</div>
        <p class="mt-2 text-sm text-gray-600">پیج مدیریت شده</p>
      </div>
      <div data-aos="fade-up" data-aos-delay="160">
        <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600">50K+</div>
        <p class="mt-2 text-sm text-gray-600">پست منتشر شده</p>
      </div>
    </div>
  </div>
</section>

<!-- STRONG CTA -->
<section class="py-12 bg-gradient-to-r from-indigo-600 to-violet-600 text-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="text-2xl sm:text-3xl font-bold" data-aos="zoom-in">همین حالا شروع کنید</h2>
    <p class="mt-2 text-sm sm:text-base opacity-90" data-aos="zoom-in" data-aos-delay="60">ثبت نام رایگان و شروع مدیریت حرفه‌ای شبکه‌های اجتماعی کسب‌وکار شما</p>
    <div class="mt-6" data-aos="zoom-in" data-aos-delay="120">
      <a href="{{ route('login') }}" class="inline-flex items-center gap-3 rounded-full bg-white px-6 py-3 text-indigo-600 font-semibold shadow-lg hover:scale-[1.02] transition">
        ثبت نام
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-gray-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row items-center md:justify-between gap-6">
      <div class="text-center md:text-right">
        <a href="/" class="inline-flex items-center gap-2">
          <img src="{{ asset('images/logo.png') }}" alt="Pixyar" class="h-8" />
          <span class="text-white font-semibold">پیکس یار</span>
        </a>
        <p class="mt-3 text-sm text-gray-400">© 2025 پیکس یار. تمام حقوق محفوظ است.</p>
      </div>

      <div class="flex items-center gap-6">
        <nav class="flex gap-4">
          <a href="#features" class="text-sm hover:text-white">ویژگی‌ها</a>
          <a href="#why" class="text-sm hover:text-white">چرا پیکس یار</a>
          <a href="#contact" class="text-sm hover:text-white">تماس</a>
        </nav>

        <div class="flex items-center gap-3">
          <a href="#" class="text-gray-400 hover:text-white text-sm">اینستاگرام</a>
          <a href="#" class="text-gray-400 hover:text-white text-sm">تلگرام</a>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- SCRIPTS: AOS + Swiper + small interactions -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
  // AOS init
  AOS.init({ duration: 900, once: true, offset: 60 });

  // mobile menu toggle (accessible)
  (function(){
    const btn = document.getElementById('mobile-toggle');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => {
      const isOpen = menu.classList.toggle('hidden') === false;
      btn.setAttribute('aria-expanded', String(isOpen));
    });
  })();

  // HERO Swiper
  const heroSwiper = new Swiper('.heroSwiper', {
    slidesPerView: 1,
    loop: true,
    effect: 'fade',
    speed: 900,
    autoplay: { delay: 5000, disableOnInteraction: false },
    pagination: { el: '.swiper-pagination-hero', clickable: true, type: 'bullets' },
    a11y: true
  });

  // FEATURES Swiper
  const featuresSwiper = new Swiper('.featuresSwiper', {
    slidesPerView: 1,
    spaceBetween: 16,
    loop: true,
    autoplay: { delay: 4200, disableOnInteraction: false },
    pagination: { el: '.swiper-pagination-features', clickable: true },
    navigation: {
      nextEl: '.next-feature',
      prevEl: '.prev-feature',
    },
    breakpoints: {
      640: { slidesPerView: 1.2 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 }
    }
  });

  // small accessible focus trap for keyboard users - focus on hero CTA after load
  window.addEventListener('load', () => {
// Replace the problematic line with this:
const primaryCTAs = document.querySelectorAll(`a[href="{{ route('login') }}"], a[href$="#features"]`);

    if (primaryCTAs && primaryCTAs[0]) {
      // nothing forced — we prefer not to move focus unexpectedly, so we leave it commented.
      // primaryCTAs[0].focus();
    }
  });
</script>

</body>
</html>

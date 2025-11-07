<template>
 <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پیکس یار - مدیریت هوشمند شبکه‌های اجتماعی</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        /* آدم و دایره‌ها */
        .person-wrapper { position: relative; max-width: 400px; margin: auto; }
        .person-wrapper img { width: 100%; border-radius: 50%; z-index: 10; position: relative; }
        .circle { position: absolute; border: 2px dashed #6366f1; border-radius: 50%; animation: float 4s ease-in-out infinite; }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .circle span { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color:#6366f1; font-weight:bold; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
<!-- Navbar -->
<nav class="bg-white shadow fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- لوگو -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/">
                    <img class="h-8 w-auto" src="https://images.unsplash.com/photo-1602524811462-9b5e42e7b68a?auto=format&fit=crop&w=80&q=80" alt="Pixyar Logo">
                </a>
            </div>
            <!-- منو دسکتاپ -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#banner" class="text-gray-700 hover:text-indigo-600 font-semibold">خانه</a>
                <a href="#features" class="text-gray-700 hover:text-indigo-600 font-semibold">چرا پیکس یار؟</a>
                <a href="#contact" class="text-gray-700 hover:text-indigo-600 font-semibold">تماس با ما</a>
                <a href="{{ route('LorR') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500 transition">ثبت نام</a>
            </div>
            <!-- دکمه همبرگر موبایل -->
            <div class="flex items-center md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- منوی موبایل -->
    <div id="mobile-menu" class="md:hidden hidden px-2 pt-2 pb-3 space-y-1 bg-white shadow">
        <a href="#banner" class="block px-3 py-2 rounded text-gray-700 hover:bg-indigo-100">خانه</a>
        <a href="#features" class="block px-3 py-2 rounded text-gray-700 hover:bg-indigo-100">چرا پیکس یار؟</a>
        <a href="#contact" class="block px-3 py-2 rounded text-gray-700 hover:bg-indigo-100">تماس با ما</a>
        <a href="{{ route('LorR') }}" class="block px-3 py-2 rounded text-white bg-indigo-600 hover:bg-indigo-500 text-center">ثبت نام</a>
    </div>
</nav>

<!-- جاوااسکریپت برای باز/بسته کردن منوی موبایل -->
<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>


<!-- Hero / Banner Slider -->
<section id="banner" class="relative overflow-hidden h-[500px] md:h-[400px]">
    <div class="swiper bannerSwiper h-full">
        <div class="swiper-wrapper h-full">
            <div class="swiper-slide bg-cover bg-center  "
                 style="background-image: url('https://bdbd.ir/wp-content/uploads/2022/09/Layer-3.png');">
            </div>
            <div class="swiper-slide bg-cover bg-center "
                 style="background-image: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1950&q=80');">
            </div>
            <div class="swiper-slide bg-cover bg-center "
                 style="background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1950&q=80');">
            </div>
        </div>
        <div class="swiper-pagination absolute bottom-4 w-full text-center"></div>
    </div>
</section>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var bannerSwiper = new Swiper(".bannerSwiper", {
        slidesPerView: 1,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        effect: 'fade',
    });
</script>



<!-- Why Pixyar -->
<section id="why" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold mb-4" data-aos="fade-up">چرا پیکس یار؟</h2>
        <p class="text-gray-600" data-aos="fade-up" data-aos-delay="100">پیکس یار راهکاری جامع برای مدیریت شبکه‌های اجتماعی کسب‌وکار شماست که همه نیازهایتان را پوشش می‌دهد.</p>
    </div>
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center px-6">
        <div class="relative person-wrapper" data-aos="fade-up">
            <img src="https://pixonik.ir/wp-content/uploads/2025/04/Young-Man-e1741679700473-1.png" alt="Person">
            <div class="circle w-24 h-24 top-0 left-1/4"><span>تحلیل</span></div>
            <div class="circle w-20 h-20 top-1/2 left-0"><span>زمان‌بندی</span></div>
            <div class="circle w-16 h-16 top-2/3 right-1/4"><span>اتوماسیون</span></div>
            <div class="circle w-12 h-12 bottom-0 left-1/3"><span>گزارش</span></div>
        </div>
        <div class="space-y-6" data-aos="fade-left">
            <div class="p-6 bg-white rounded shadow hover:shadow-lg transition">
                <h3 class="font-bold text-xl mb-2">تحلیل دقیق داده‌ها</h3>
                <p>تمام داده‌های شبکه‌های اجتماعی شما جمع‌آوری و تحلیل می‌شود تا تصمیمات هوشمندانه بگیرید.</p>
            </div>
            <div class="p-6 bg-white rounded shadow hover:shadow-lg transition">
                <h3 class="font-bold text-xl mb-2">زمان‌بندی و اتوماسیون</h3>
                <p>پست‌ها و دایرکت‌ها را خودکار زمان‌بندی کنید و وقت خود را صرف کارهای مهم‌تر کنید.</p>
            </div>
            <div class="p-6 bg-white rounded shadow hover:shadow-lg transition">
                <h3 class="font-bold text-xl mb-2">گزارش‌ها و آمار</h3>
                <p>با گزارش‌ها و نمودارهای دقیق عملکرد پیج خود را مشاهده کنید و رشد کسب‌وکار خود را دنبال کنید.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Carousel -->
<section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">ویژگی‌های پیکس یار</h2>
        <div class="swiper mySwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-white p-6 rounded shadow hover:shadow-lg transition text-center">
                    <div class="text-indigo-600 text-5xl mb-4">📊</div>
                    <h3 class="font-bold mb-2">تحلیل دقیق</h3>
                    <p>تمام داده‌های پیج خود را جمع‌آوری و تحلیل کنید و گزارش‌های دقیق بگیرید.</p>
                </div>
                <div class="swiper-slide bg-white p-6 rounded shadow hover:shadow-lg transition text-center">
                    <div class="text-indigo-600 text-5xl mb-4">📝</div>
                    <h3 class="font-bold mb-2">زمان‌بندی پست‌ها</h3>
                    <p>پست‌ها و استوری‌ها را به راحتی زمان‌بندی کنید و تعامل پیج خود را افزایش دهید.</p>
                </div>
                <div class="swiper-slide bg-white p-6 rounded shadow hover:shadow-lg transition text-center">
                    <div class="text-indigo-600 text-5xl mb-4">🤖</div>
                    <h3 class="font-bold mb-2">پاسخ خودکار</h3>
                    <p>کامنت‌ها و دایرکت‌ها را خودکار پاسخ دهید و وقت خود را ذخیره کنید.</p>
                </div>
            </div>
            <div class="swiper-pagination mt-6"></div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section id="stats" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div data-aos="fade-up">
            <h3 class="text-4xl font-bold text-indigo-600">1.2K+</h3>
            <p>کاربر فعال</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-4xl font-bold text-indigo-600">3.5K+</h3>
            <p>پیج مدیریت شده</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-4xl font-bold text-indigo-600">50K+</h3>
            <p>پست منتشر شده</p>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-indigo-600 text-white py-20 text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-6" data-aos="zoom-in">همین حالا شروع کنید</h2>
    <p class="mb-8" data-aos="zoom-in" data-aos-delay="100">ثبت نام رایگان و شروع مدیریت حرفه‌ای شبکه‌های اجتماعی کسب‌وکار شما</p>
    <a href="{{ route('LorR') }}" class="bg-white text-indigo-600 font-bold px-6 py-3 rounded shadow-lg hover:bg-gray-100 transition" data-aos="zoom-in" data-aos-delay="200">ثبت نام</a>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-gray-300 py-6 mt-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
        <p>© 2025 پیکس یار. تمام حقوق محفوظ است.</p>
        <div class="space-x-4 mt-4 md:mt-0">
            <a href="#" class="hover:text-white">اینستاگرام</a>
            <a href="#" class="hover:text-white">تلگرام</a>
            <a href="#" class="hover:text-white">تماس</a>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });

    // Banner Slider
    var bannerSwiper = new Swiper(".bannerSwiper", {
        slidesPerView: 1,
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
    });

    // Features Slider
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
    });
</script>

</body>
</html>

</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/autoplay';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { onMounted } from 'vue';

const images = [
  '/images/insta-analytics.jpg',
  '/images/marketing.jpg',
  '/images/dashboard.jpg'
];


const services = [
  { title: 'استراتژی شبکه اجتماعی', desc: 'یک استراتژی قوی پایه و اساس بازاریابی موفق رسانه های اجتماعی است.', icon: 'fas fa-chart-line' },
  { title: 'تبلیغات شبکه اجتماعی', desc: 'تبلیغات پولی به کسب‌وکارها کمک می‌کند تا به مخاطبان گسترده‌تری دست یابند.', icon: 'fas fa-bullhorn' },
  { title: 'ایجاد محتوا', desc: 'محتوای باکیفیت کلیدی برای جذب مخاطب در شبکه های اجتماعی است.', icon: 'fas fa-pencil-alt' },
  { title: 'مدیریت جامعه', desc: 'ایجاد روابط قوی با مخاطبان به بهبود وفاداری به برند کمک می‌کند.', icon: 'fas fa-users' }
];

const stats = [
  { value: '12K+', label: 'کاربر فعال' },
  { value: '5K+', label: 'پیج تحلیل شده' },
  { value: '98%', label: 'رضایت کاربران' }
];

onMounted(() => {
  AOS.init({ duration: 800, once: true });
});
</script>

<style scoped>
section {
  position: relative;
}
</style>

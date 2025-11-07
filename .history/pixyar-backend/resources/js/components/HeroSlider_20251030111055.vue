<template>
  <section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">
    <!-- منو -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-black/30 backdrop-blur-md py-4 px-6 flex justify-between items-center">
      <h2 class="font-bold text-2xl">Pixyar</h2>
      <ul class="flex space-x-6 rtl:space-x-reverse">
        <li><a href="#features" class="hover:text-yellow-300 transition">خدمات</a></li>
        <li><a href="#stats" class="hover:text-yellow-300 transition">آمار</a></li>
        <li><a href="#pricing" class="hover:text-yellow-300 transition">قیمت</a></li>
        <li><a href="#contact" class="hover:text-yellow-300 transition">تماس</a></li>
      </ul>
    </nav>

    <!-- Hero Content -->
    <div class="relative z-10 text-center py-32 px-6 md:py-48">
      <h1 data-aos="fade-down" class="text-4xl md:text-6xl font-bold mb-6">تحلیل حرفه‌ای پیج اینستاگرام با <span class="text-yellow-300">Pixyar</span></h1>
      <p data-aos="fade-up" class="text-lg md:text-xl text-white/90 mb-8">داده‌های واقعی، تحلیل دقیق، رشد هوشمند برند شما در اینستاگرام</p>
      <a href="#pricing" data-aos="zoom-in" class="bg-yellow-400 text-black font-bold px-8 py-3 rounded-full hover:bg-yellow-300 transition">
        شروع تحلیل رایگان
      </a>
    </div>

    <!-- Swiper Hero -->
    <swiper
      :loop="true"
      :autoplay="{ delay: 5000 }"
      class="h-96 mt-8"
    >
      <swiper-slide v-for="(img, i) in images" :key="i">
        <img :src="img" class="w-full h-96 object-cover opacity-60 rounded-xl" />
      </swiper-slide>
    </swiper>

   <!-- Services Section -->
<div class="relative mt-32 md:mt-40 flex flex-col md:flex-row items-center justify-center gap-12">
  <!-- کارت‌های خدمات -->
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div v-for="(services2, i) in services" :key="i" class="bg-white rounded-xl p-6 shadow-lg flex items-start gap-4 hover:shadow-2xl transition">
      <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-blue-500 text-white">
        <i :class="services.icon"></i>
      </div>
      <div>
        <h4 class="font-bold text-lg text-gray-800">{{ services.title }}</h4>
        <p class="text-gray-600 mt-1 text-sm">{{ services2.desc }}</p>
      </div>
    </div>
  </div>

  <!-- آواتار -->
  <div class="relative">
    <img src="https://pixonik.ir/wp-content/uploads/2025/04/Young-Man-e1741679700473-1.png" class="w-36 h-36 md:w-48 md:h-48 rounded-full border-4 border-blue-500 shadow-xl" />
  </div>
</div>

    <!-- آمار -->
    <section id="stats" class="mt-72 md:mt-96 py-20 bg-white text-gray-800 rounded-t-3xl">
      <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div v-for="(stat, i) in stats" :key="i" data-aos="fade-up" :data-aos-delay="i*150">
          <h3 class="text-4xl font-bold text-indigo-600">{{ stat.value }}</h3>
          <p class="mt-2 text-gray-600">{{ stat.label }}</p>
        </div>
      </div>
    </section>
  </section>
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
  { title: 'تحلیل رشد پیج', desc: 'بررسی دقیق عملکرد پیج شما و پیشنهاد رشد هوشمند' },
  { title: 'یافتن هشتگ‌ها', desc: 'بهترین هشتگ‌ها برای جذب فالوور واقعی' },
  { title: 'بررسی رقبا', desc: 'آنالیز و مقایسه عملکرد پیج رقبای شما' },
  { title: 'گزارش کامل', desc: 'ارائه گزارش تحلیلی دقیق و قابل فهم' }
];
const services2 = [
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

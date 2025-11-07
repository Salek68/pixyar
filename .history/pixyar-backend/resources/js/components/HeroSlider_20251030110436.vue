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

    <!-- آواتار شناور و خدمات -->
    <div class="absolute right-6 bottom-20 md:right-20 md:bottom-32 flex items-center space-x-6 rtl:space-x-reverse z-20">
      <div data-aos="fade-up" class="relative">
        <img src="/images/avatar.png" class="w-28 h-28 md:w-40 md:h-40 rounded-full border-4 border-yellow-400 shadow-lg" />
        <!-- لیست خدمات -->
        <div class="absolute left-full top-1/2 -translate-y-1/2 ml-6 md:ml-10 space-y-4">
          <div v-for="(service, i) in services" :key="i" data-aos="fade-left" :data-aos-delay="i*150" class="bg-white/20 backdrop-blur-md p-4 rounded-xl w-64">
            <h4 class="font-bold text-lg text-yellow-300">{{ service.title }}</h4>
            <p class="text-white/90 text-sm mt-1">{{ service.desc }}</p>
          </div>
        </div>
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

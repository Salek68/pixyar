<template>
  <section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative z-10 text-center py-20 px-6 md:py-32">
      <h1 data-aos="fade-down" class="text-4xl md:text-6xl font-bold mb-6">تحلیل حرفه‌ای پیج اینستاگرام با <span class="text-yellow-300">Pixyar</span></h1>
      <p data-aos="fade-up" class="text-lg md:text-xl text-white/90 mb-8">داده‌های واقعی، تحلیل دقیق، رشد هوشمند برند شما در اینستاگرام</p>
      <a href="#pricing" data-aos="zoom-in" class="bg-yellow-400 text-black font-bold px-8 py-3 rounded-full hover:bg-yellow-300 transition">
        شروع تحلیل رایگان
      </a>
    </div>

    <swiper
      :loop="true"
      :autoplay="{ delay: 5000 }"
      class="h-96"
    >
      <swiper-slide v-for="(img, i) in images" :key="i">
        <img :src="img" class="w-full h-96 object-cover opacity-60" />
      </swiper-slide>
    </swiper>
  </section>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/autoplay';

const images = [
  '/images/insta-analytics.jpg',
  '/images/marketing.jpg',
  '/images/dashboard.jpg'
];
</script>

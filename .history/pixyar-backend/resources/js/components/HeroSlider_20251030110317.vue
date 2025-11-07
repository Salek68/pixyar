<template>
  <section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">

    <!-- موبایل منو -->
    <div class="fixed top-0 left-0 w-full z-50 md:hidden">
      <div class="flex justify-between items-center bg-black/70 p-4">
        <div class="text-2xl font-bold">Pixyar</div>
        <button @click="mobileMenuOpen = !mobileMenuOpen">
          <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <transition name="fade">
        <div v-if="mobileMenuOpen" class="bg-black/90 text-white p-6 flex flex-col space-y-4">
          <a href="#hero" @click="mobileMenuOpen = false">خانه</a>
          <a href="#features" @click="mobileMenuOpen = false">خدمات</a>
          <a href="#pricing" @click="mobileMenuOpen = false">قیمت‌ها</a>
          <a href="#contact" @click="mobileMenuOpen = false">تماس</a>
        </div>
      </transition>
    </div>

    <!-- لایه بک‌گراند سیاه نیمه شفاف -->
    <div class="absolute inset-0 bg-black/30"></div>

    <!-- محتوا -->
    <div class="relative z-10 text-center py-20 px-6 md:py-32 max-w-7xl mx-auto">
      <h1 data-aos="fade-down" class="text-4xl md:text-6xl font-bold mb-6">
        تحلیل حرفه‌ای پیج اینستاگرام با <span class="text-yellow-300">Pixyar</span>
      </h1>
      <p data-aos="fade-up" class="text-lg md:text-xl text-white/90 mb-8">
        داده‌های واقعی، تحلیل دقیق، رشد هوشمند برند شما در اینستاگرام
      </p>
      <a href="#pricing" data-aos="zoom-in" class="bg-yellow-400 text-black font-bold px-8 py-3 rounded-full hover:bg-yellow-300 transition">
        شروع تحلیل رایگان
      </a>
    </div>

    <!-- اسلایدر Swiper -->
    <swiper
      :loop="true"
      :autoplay="{ delay: 5000 }"
      class="h-96 mt-10 md:mt-0"
    >
      <swiper-slide v-for="(img, i) in images" :key="i">
        <img :src="img" class="w-full h-96 object-cover opacity-60" />
      </swiper-slide>
    </swiper>

    <!-- آواتار شناور با خدمات -->
    <div class="absolute left-1/2 transform -translate-x-1/2 bottom-10 md:bottom-20 flex flex-col items-center space-y-6">
      <div class="relative">
        <img src="https://pixonik.ir/wp-content/uploads/2025/04/Young-Man-e1741679700473-1.png" class="w-32 h-32 rounded-full border-4 border-yellow-400 shadow-xl" data-aos="fade-up"/>
        <div class="absolute -top-12 left-full ml-4 flex flex-col space-y-4">
          <div v-for="(service, i) in services" :key="i" class="bg-white text-black p-3 rounded-lg shadow-lg w-48" :data-aos="'fade-left'" :data-aos-delay="i*150">
            <h4 class="font-bold">{{ service.title }}</h4>
            <p class="text-sm">{{ service.description }}</p>
          </div>
        </div>
      </div>
    </div>

  </section>
</template>

<script setup>
import { ref } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/autoplay';

const mobileMenuOpen = ref(false);

const images = [
  '/images/insta-analytics.jpg',
  '/images/marketing.jpg',
  '/images/dashboard.jpg'
];

const services = [
  { title: 'آنالیز پیج', description: 'تحلیل دقیق فالوورها و محتوا' },
  { title: 'رشد هوشمند', description: 'پیشنهادات رشد و بهبود تعامل' },
  { title: 'گزارش حرفه‌ای', description: 'آمار و نمودارهای بصری' },
  { title: 'مدیریت هشتگ', description: 'هشتگ‌های بهینه برای هر پست' }
];
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>

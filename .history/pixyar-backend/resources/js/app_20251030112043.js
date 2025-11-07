import './bootstrap';
import { createApp } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
// import './style.css';


// ایجاد اپ Vue
const app = createApp({});

// ثبت کامپوننت‌ها
app.component('hero-slider', HeroSlider);
app.component('features-section', FeaturesSection);
app.component('pricing-section', PricingSection);
app.component('footer-section', FooterSection);

// mount به app
app.mount('#app');

// فعال‌سازی AOS
AOS.init({
  duration: 800,
  once: true,
});

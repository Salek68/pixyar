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


// mount به app
app.mount('#app');

// فعال‌سازی AOS
AOS.init({
  duration: 800,
  once: true,
});

<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ورود و ثبت نام</title>
  <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div id="app" class="w-full max-w-md">
  <div class="bg-white rounded-xl shadow-lg p-8">

    <!-- سوئیچ بین فرم ورود و ثبت نام -->
    <div class="flex justify-center mb-6">
      <button @click="mode='login'"
              :class="mode==='login' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
              class="px-4 py-2 rounded-l-lg font-bold">
        ورود
      </button>
      <button @click="mode='register'"
              :class="mode==='register' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700'"
              class="px-4 py-2 rounded-r-lg font-bold">
        ثبت نام
      </button>
    </div>

    <!-- پیام خطا -->
  <div v-if="error" class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
  @{{ error }}
</div>

    <!-- فرم ورود -->
    <form v-if="mode==='login'" @submit.prevent="submitLogin">
      <div class="mb-4">
        <label class="block mb-1 font-semibold">ایمیل</label>
        <input type="email" v-model="loginForm.email" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-semibold">رمز عبور</label>
        <input type="password" v-model="loginForm.password" class="w-full border px-3 py-2 rounded" required>
      </div>
      <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-bold hover:bg-indigo-700">
        ورود
      </button>
    </form>

    <!-- فرم ثبت نام -->
    <form v-if="mode==='register'" @submit.prevent="submitRegister">
      <div class="mb-4">
        <label class="block mb-1 font-semibold">نام</label>
        <input type="text" v-model="registerForm.name" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-semibold">ایمیل</label>
        <input type="email" v-model="registerForm.email" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-semibold">رمز عبور</label>
        <input type="password" v-model="registerForm.password" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-semibold">تکرار رمز عبور</label>
        <input type="password" v-model="registerForm.password_confirmation" class="w-full border px-3 py-2 rounded" required>
      </div>
      <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-bold hover:bg-indigo-700">
        ثبت نام
      </button>
    </form>

  </div>
</div>

<script>
const app = Vue.createApp({
  data() {
    return {
      mode: 'login', // login یا register
      error: null,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    async submitLogin() {
      this.error = null;
      try {
        const res = await axios.post('/login', this.loginForm);
        alert('ورود موفقیت آمیز بود!'');
        // اینجا می‌تونی کارهای بعد از لاگین مثل ذخیره توکن انجام بدی
      } catch (err) {
        this.error = err.response?.data?.message || 'خطا در ورود';
      }
    },
    async submitRegister() {
      this.error = null;
      try {
        const res = await axios.post('/register', this.registerForm);
        alert('ثبت نام موفقیت آمیز بود!\nتوکن: ' + res.data.token);
        // بعد از ثبت نام می‌توانیم فرم را به حالت ورود تغییر دهیم
        this.mode = 'login';
      } catch (err) {
        if(err.response?.data?.errors){
          // نمایش خطاهای اعتبارسنجی
          this.error = Object.values(err.response.data.errors).flat().join('\n');
        } else {
          this.error = err.response?.data?.message || 'خطا در ثبت نام';
        }
      }
    }
  }
});

app.mount('#app');
</script>

</body>
</html>

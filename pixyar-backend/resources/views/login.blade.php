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

<div id="app" class="w-full max-w-md" style="margin-top: auto; margin-bottom: auto;">
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
      <button   :disabled="loading" type="submit" class="w-full bg-indigo-600 text-white py-2 rounded font-bold hover:bg-indigo-700">
   @{{ loading ? 'در حال ورود...' : 'ورود' }}
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
       {{-- <div class="mb-4">
       <label class="block mb-1 font-semibold">انتخاب پلن</label>
            <select v-model="registerForm.plan" class="w-full border px-3 py-2 rounded" required>
                <option value="">انتخاب کنید</option>
                <option value="free">Free</option>
                <option value="pro">Pro</option>
                <option value="business">business</option>
            </select>
      </div> --}}
      <!-- انتخاب پلن با کارت -->
<div class="mb-6">
  <label class="block mb-2 font-semibold text-lg"> انتخاب پلن یک ماهه</label>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <!-- پلن Free -->
    <div
      @click="registerForm.plan='free'"
      :class="registerForm.plan==='free' ? 'border-indigo-600 ring-2 ring-indigo-400' : 'border-gray-300'"
      class="cursor-pointer border rounded-xl p-4 text-center hover:shadow-md transition"
    >
      <h3 class="font-bold text-xl mb-2">Free</h3>
      <p class="text-gray-600 text-sm mb-2">مناسب شروع کار مدیریت 1 اکانت بدون ابزار های اختصاصی</p>
      <p class="font-bold text-indigo-600 text-lg">0 تومان</p>
    </div>

    <!-- پلن Pro -->
    <div
      @click="registerForm.plan='pro'"
      :class="registerForm.plan==='pro' ? 'border-indigo-600 ring-2 ring-indigo-400' : 'border-gray-300'"
      class="cursor-pointer border rounded-xl p-4 text-center hover:shadow-md transition"
    >
      <h3 class="font-bold text-xl mb-2">Pro</h3>
      <p class="text-gray-600 text-sm mb-2">برای کاربران حرفه‌ای مدیریت 2 اکانت</p>
      <p class="font-bold text-indigo-600 text-lg">149,000 تومان</p>
    </div>

    <!-- پلن Business -->
    <div
      @click="registerForm.plan='business'"
      :class="registerForm.plan==='business' ? 'border-indigo-600 ring-2 ring-indigo-400' : 'border-gray-300'"
      class="cursor-pointer border rounded-xl p-4 text-center hover:shadow-md transition"
    >
      <h3 class="font-bold text-xl mb-2">Business</h3>
      <p class="text-gray-600 text-sm mb-2">برای تیم‌ها و سازمان‌ها مدیریت 5 اکانت</p>
      <p class="font-bold text-indigo-600 text-lg">349,000 تومان</p>
    </div>

  </div>

  <p v-if="!registerForm.plan" class="text-red-500 text-sm mt-2">
    لطفاً یک پلن انتخاب کنید.
  </p>
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
      loading: false,
      mode: 'login', // login یا register
      error: null,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        plan: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    async submitLogin() {
        this.loading = true;
      this.error = null;
      try {
        const res = await axios.post('/login', this.loginForm);
        alert('ورود موفقیت آمیز بود!');
        // اینجا می‌تونی کارهای بعد از لاگین مثل ذخیره توکن انجام بدی
         setTimeout(() => {
            window.location.href = "{{ route('AdminPanel.select') }}";
        }, 500);
      } catch (err) {
        this.error = err.response?.data?.message || 'خطا در ورود';
      }
    },
    async submitRegister() {
      this.error = null;
      try {
        const res = await axios.post('/register', this.registerForm);
        alert('ثبت نام موفقیت آمیز بود!');
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

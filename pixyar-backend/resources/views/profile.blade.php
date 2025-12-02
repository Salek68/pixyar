    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<div id="app" class="max-w-xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-lg">

    <!-- پیام نکات مهم -->
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6">
        <p class="font-semibold">لطفاً قبل از وارد کردن اطلاعات توجه کنید:</p>
        <ul class="list-disc list-inside mt-2 text-sm space-y-1">
            <li>پیج شما باید <strong>Public</strong> باشد.</li>
            <li>برای تحلیل بهتر، پیج شما بهتر است <strong>Business</strong> باشد.</li>
            <li>برای تایید مالکیت، پیجی که می‌خواهید آنالیز شود باید <strong>@pixonik.ir</strong> را فالو کرده باشد.</li>
        </ul>
    </div>

    <!-- پیام خطا / موفقیت -->
    <transition name="fade">
        <div v-if="message.text"
             :class="message.type==='error' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'"
             class="p-3 rounded mb-4 text-sm">
            @{{ message.text }}
        </div>
    </transition>

    <!-- فرم -->
    <form @submit.prevent="submitForm" class="space-y-4">

        <div>
            <label class="block mb-1 font-semibold">ID پیج</label>
            <input type="text" v-model="form.page_id" class="w-full border px-3 py-2 rounded" required>
        </div>
           <div>
            <label class="block mb-1 font-semibold">موضوع پیج</label>
            <input type="text" v-model="form.type" class="w-full border px-3 py-2 rounded" required>
        </div>

        {{-- <div>
            <label class="block mb-1 font-semibold">انتخاب پلن</label>
            <select v-model="form.plan" class="w-full border px-3 py-2 rounded" required>
                <option value="">انتخاب کنید</option>
                <option value="free">Free</option>
                <option value="pro">Pro</option>
                <option value="business">business</option>
            </select>
        </div> --}}

        <button type="submit"
                :disabled="loading"
                class="w-full bg-indigo-600 text-white py-2 rounded font-bold hover:bg-indigo-700 disabled:opacity-50">
            @{{ loading ? 'در حال ارسال...' : 'ارسال' }}
        </button>

    </form>

</div>

<!-- Vue 3 + Axios -->
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
const app = Vue.createApp({
    data() {
        return {
            form: {
                page_id: '',
                type:''
            },
            message: {
                text: '',
                type: '' // error یا success
            },
            loading: false
        }
    },
    methods: {
        async submitForm() {
            this.loading = true;
            this.message.text = '';
            try {
                const res = await axios.post("{{ route('calldata') }}", this.form, {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                this.message.text = res.data.message || 'اطلاعات با موفقیت ثبت شد.';
                this.message.type = 'success';
                this.form.page_id = '';
                this.form.plan = '';
                this.form.type = '';

                 setTimeout(() => {
            window.location.href = "{{ route('AdminPanel.select') }}";
        }, 3000);

            } catch (err) {
                if (err.response && err.response.data.errors) {
                    this.message.text = Object.values(err.response.data.errors).flat().join('\n');
                } else if (err.response && err.response.data.message) {
                    this.message.text = err.response.data.message;
                } else {
                    this.message.text = 'خطایی رخ داده است.';
                }
                this.message.type = 'error';
            } finally {
                this.loading = false;
            }
        }
    }
});
app.mount('#app');
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>


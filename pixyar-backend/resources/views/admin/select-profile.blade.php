<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>انتخاب پروفایل</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div id="app"></div>

<script>
const app = Vue.createApp({
    data() {
        return {
            profiles: @json($profiles),
        }
    },
    mounted() {
        this.showProfileAlert();
    },
    methods: {
        showProfileAlert() {
            if(!this.profiles.length) return;

            let htmlOptions = this.profiles.map((p, index) =>
                `<button class="swal2-confirm swal2-styled" style="display:block;margin:5px 0;width:100%"
                    onclick="window.vueApp.selectProfile(${p.id})">
                    ${p.username}
                </button>`
            ).join('');

            Swal.fire({
                title: 'انتخاب پروفایل',
                html: htmlOptions,
                showConfirmButton: false,
                width: 400,
            });
        },
        selectProfile(profileId) {
            window.location.href = "{{ route('AdminPanel.Index', ['id' => ':id']) }}".replace(':id', profileId);
        }
    }
});

window.vueApp = app.mount('#app');
</script>

</body>
</html>

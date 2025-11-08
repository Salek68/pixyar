@extends('admin.layout.master')
@section('route')
داشبورد - {{$profiles->full_name}}
@endsection
@section('srcprofile')
{{$profiles->profile_pic}}
@endsection

@section('main-content')
<section class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">رشد فالوئرها</h1>

        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8">
            <canvas id="followersChart" class="w-full h-96"></canvas>
        </div>

        <div class="text-center mt-8">
            <a href="" class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold rounded-2xl shadow-lg hover:from-purple-700 hover:to-pink-600 transition">
                بازگشت به داشبورد
            </a>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('followersChart').getContext('2d');

const labels = {!! json_encode($dates) !!};
const data = {!! json_encode($followers) !!};

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'تعداد فالوئرها',
            data: data,
            fill: true,
            backgroundColor: 'rgba(147, 51, 234, 0.2)',
            borderColor: 'rgba(147, 51, 234, 1)',
            tension: 0.3,
            pointRadius: 5,
            pointBackgroundColor: 'rgba(147, 51, 234, 1)'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                labels: { font: { size: 14 } }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.raw + ' فالوئر';
                    }
                }
            }
        },
        scales: {
            x: {
                title: { display: true, text: 'تاریخ', font: { size: 16 } }
            },
            y: {
                beginAtZero: true,
                title: { display: true, text: 'تعداد فالوئر', font: { size: 16 } }
            }
        }
    }
});
</script>
@endsection

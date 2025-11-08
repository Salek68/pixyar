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
        <h1 class="text-4xl font-extrabold text-gray-800 mb-6 text-center">تقویم محتوایی</h1>

        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4">بهترین زمان‌ها برای پست‌گذاری</h2>
            <ul class="list-disc pl-5">
                @foreach($topTimes as $time)
                    <li>{{ $time['day'] }} ساعت {{ $time['hour'] }} : تعامل {{ $time['engagement'] }}%</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl p-6 overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-2 py-1">روز / ساعت</th>
                        @foreach($hours as $hour)
                            <th class="border border-gray-300 px-2 py-1">{{ $hour }}:00</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $dayIndex => $day)
                        <tr>
                            <td class="border border-gray-300 px-2 py-1 font-bold">{{ $day }}</td>
                            @foreach($hours as $hourIndex)
                                @php
                                    $val = $heatmap[$dayIndex][$hourIndex];
                                    $color = "rgba(147,51,234," . min($val/100,1) . ")";
                                @endphp
                                <td class="border border-gray-300 px-2 py-1 text-center" style="background-color: {{$color}}">
                                    {{ $val }}%
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>



<section class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">بهترین زمان پست‌گذاری</h1>

        {{-- Heatmap Chart --}}
        <div class="bg-white rounded-3xl shadow-2xl p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-6 text-gray-700 text-center">Heatmap تعامل روزها و ساعات</h2>
            <canvas id="heatmapChart" class="w-full h-96"></canvas>
        </div>

        <div class="text-center mt-8">
            <a href="" class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold rounded-2xl shadow-lg hover:from-purple-700 hover:to-pink-600 transition">
                بازگشت به داشبورد
            </a>
        </div>
    </div>
</section>

{{-- Chart.js و Matrix Plugin --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix@2.0.0/dist/chartjs-chart-matrix.min.js"></script>

<script>
// داده‌های نمونه برای تست
const days = {!! json_encode($days) !!};
const hours ={!! json_encode($hours) !!};

// داده نمونه تصادفی 0-100 درصد تعامل
const heatmapData = {!! json_encode($heatmap) !!};

// ساخت داده برای Matrix
const dataset = heatmapData.flatMap((row, dayIndex) =>
    row.map((value, hourIndex) => ({x: hourIndex, y: dayIndex, v: value}))
);

const ctx = document.getElementById('heatmapChart').getContext('2d');

new Chart(ctx, {
    type: 'matrix',
    data: {
        datasets: [{
            label: 'Heatmap تعامل',
            data: dataset,
            backgroundColor: function(ctx) {
                const value = ctx.dataset.data[ctx.dataIndex].v;
                // گرادینت رنگی از روشن به تیره
                const alpha = Math.min(value / 100, 1);
                return `rgba(147, 51, 234, ${alpha})`;
            },
            width: 25,  // اندازه ثابت برای تست
            height: 25,
            borderWidth: 1,
            borderColor: 'rgba(255,255,255,0.2)',
        }]
    },
    options: {
        responsive: true,
        animation: {
            duration: 1000,
            easing: 'easeOutQuart'
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: () => '',
                    label: function(context) {
                        const day = days[context.raw.y];
                        const hour = hours[context.raw.x];
                        const value = context.raw.v;
                        return `ساعت ${hour}:00 - ${day} : ${value}% تعامل`;
                    }
                }
            },
            legend: { display: false }
        },
        scales: {
            x: {
                type: 'linear',
                position: 'bottom',
                ticks: {
                    stepSize: 1,
                    callback: val => val + ':00'
                },
                grid: { display: false }
            },
            y: {
                type: 'linear',
                ticks: {
                    stepSize: 1,
                    callback: val => days[val]
                },
                grid: { display: false }
            }
        }
    }
});
</script>
@endsection

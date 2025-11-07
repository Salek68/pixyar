@extends('admin.layout.master')
@section('route')
داشبورد
@endsection
@section('main-content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="main-content">
    <div class="row no-gutters font-size-13 margin-bottom-10">
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> تعداد تخفیف ها ثبت شده </p>
            {{-- <p>{{$TotalDiscount}}</p> --}}
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p> تخفیف های فعال</p>
            {{-- <p>{{$TotalDiscountActive}}</p> --}}
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
            <p>تخفیف های منقضی</p>
            <p>{{$TotalDiscountDeactive}}</p>
        </div>
        <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
            <p>بازدید از فروشگاه</p>
            <p>{{$TotalView}}</p>
        </div>
    </div>

    <script>

        var chartLabels = @json($labels);
        var chartData = @json($values);

                document.addEventListener("DOMContentLoaded", function () {
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar', // نوع نمودار (bar, line, pie, etc.)
                        data: {
                            labels: chartLabels,
                            datasets: [{
                                label: ' نمودار بازدید هفت روز گذشته',
                                data: chartData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });









         var chartLabels2 = @json($labels2);
        var chartData2 = @json($values2);

                document.addEventListener("DOMContentLoaded", function () {
                    var ctx2 = document.getElementById('myChart2').getContext('2d');
                    var myChart2 = new Chart(ctx2, {
                        type: 'bar', // نوع نمودار (bar, line, pie, etc.)
                        data: {
                            labels: chartLabels2,
                            datasets: [{
                                label: ' نمودار ثبت تخفیف هفت روز گذشته',
                                data: chartData2,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
    <div class="row no-gutters font-size-13 margin-bottom-10">
        <div class="col-6 padding-20 bg-white margin-bottom-10 margin-left-10 border-radius-3">

            <canvas id="myChart" width="400" height="200"></canvas>

        </div>
        <div class="col-6 info-amount padding-20 bg-white margin-bottom-12-p margin-bottom-10 border-radius-3">
            <canvas id="myChart2" width="400" height="200"></canvas>

        </div>
    </div>
    <div class="row bg-white no-gutters font-size-13">
        <div class="title__row">
            <p>تخفیف  های اخیر </p>
            <a class="all-reconcile-text margin-left-20 color-2b4a83">نمایش همه تخفیف ها</a>
        </div>
        <div class="table__box">
            <table width="100%" class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه تخفیف</th>
                    <th>عنوان</th>
                    <th>توضیحات</th>
                    <th>درصد تخفیف</th>
                    <th>تاریخ شروع تخفیف</th>
                    <th>تاریخ پایان تخفیف</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
          @foreach ($discount as $item)
          <tr role="row">
            <td><a href=""> {{$item->id}}</a></td>
            <td><a href=""> {{$item->title}}</a></td>
            <td><a href=""> {{$item->description}}</a></td>
            <td><a href=""> {{$item->discount_percent}}</a></td>
            <td><a href="">{{ \Morilog\Jalali\Jalalian::fromDateTime($item->start_date)->format('Y/m/d') }}</a></td>
            <td><a href="">{{ \Morilog\Jalali\Jalalian::fromDateTime($item->end_date)->format('Y/m/d') }}</a></td>
            <td><a href=""  style="color: {{ \Carbon\Carbon::parse($item->end_date)->isPast() ? 'red' : 'green' }};">  ({{ \Carbon\Carbon::parse($item->end_date)->isPast() ? 'منقضی' : 'فعال' }})</a></td>
            <td class="i__oprations">

                <a href="{{ route('AdminPanel.Discounts.Remove', ['id'=>$item->id]) }}" class="item-delete margin-left-10" title="حذف"></a>
                <a href="{{ route('AdminPanel.DiscountDeactive', ['id'=>$item->id]) }}" class="item-lock margin-left-10" title='غیر فعال کردن'></a>
                <a href="{{ route('AdminPanel.DiscountUpdate.Index', ['id'=>$item->id]) }}" class="item-edit" title='  ویرایش'></a>
            </td>
        </tr>
          @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

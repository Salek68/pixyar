@extends('admin.layout.master')
@section('route')
    تخفیف ها
@endsection
@section('main-content')
<div class="main-content">
    <div class="tab__box">
        <div class="tab__items">


            <a class="tab__item is-active" href="{{ route('AdminPanel.DiscountNew.Index') }}">ایجاد تخفیف جدید</a>

        </div>

    </div>
    <div class="tab__box">

        <div class="tab__items" style="margin-top: 5px;">


            <span  class="tab__item"  style="color: black;">انتخاب برای متن پیش نمایش روی نقشه</span>
            <span  class="tab__item"  style="color: black;">متن فعلی  : @if(isset($discount_top->discount) && $discount_top->discount->title)
                {{ $discount_top->discount->title }}
            @else
                {{ $discount_top }}
            @endif</span>
            <select id="discountlist" class="w-1/2 p-2 border rounded-md" onchange="discountlists()">

                @foreach ($discount as $item)
                <option value="{{$item->id}}">{{$item->title}}</option>
                @endforeach

            </select>

        </div>
    </div>
    <div class="bg-white padding-20">

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
<script>
    alert(' کاربر گرامی برای نمایش فروشگاه شما روی نقشه حتما باید یک تخفیف فعال و متن فعال داشته باشید ')
    //  document.getElementById('discountlist').addEventListener('change', function () {

    //         const discountlist =  this.value;
    //         alret(discountlist)
    //         // const price = document.getElementById('price');

    //         // orderBookBody.innerHTML = '<tr><td colspan="6" class="text-center p-4 text-gray-500">⏳ در حال دریافت داده...</td> </tr>'; // حذف اطلاعات قبلی
    //         // price.innerHTML ='⏳ در حال دریافت داده...';


    //     });

        function discountlists() {
            const discount_ids = document.getElementById('discountlist').value;

            fetch(`/Discounts/DiscountTop`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            discount_id: discount_ids,
        })
    })
    .then(response => response.json())
    .then(data => {

        if (data == "ok") {
            window.location.href = "{{ route('AdminPanel.Discount') }}";
        } else {
            alert("خطایی رخ داد. لطفاً دوباره امتحان کنید.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("مشکلی در ارسال اطلاعات به سرور پیش آمد.");
    });

        }
</script>
@endsection

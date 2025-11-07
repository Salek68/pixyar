@extends('admin.layout.master')
@section('route')
   تبلیغات
@endsection
@section('main-content')
<div class="main-content">
    {{-- <div class="tab__box">
        <div class="tab__items">


            <a class="tab__item is-active" href="{{ route('AdminPanel.DiscountNew.Index') }}">ایجاد تبلیغ جدید</a>

        </div>

    </div> --}}
    <div class="tab__box">

        <div class="tab__items" style="margin-top: 5px;">


            <span  class="tab__item"  style="color: black;">انتخاب برای ارسال نوتیفیکیشن</span>

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
                <th>شناسه </th>
                <th>عنوان</th>
                <th>توضیحات</th>
            </tr>
            </thead>
            <tbody>
      @foreach ($notif as $item)
      <tr role="row">
        <td><a href=""> {{$item->id}}</a></td>
        <td><a href=""> {{$item->title}}</a></td>
        <td><a href=""> {{$item->message}}</a></td>
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

            fetch(`/save-notification`, {
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
            window.location.href = "notifications";
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

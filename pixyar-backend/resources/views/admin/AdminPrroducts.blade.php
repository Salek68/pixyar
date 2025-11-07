@extends('admin.layout.master')
@section('route')
    محصولات
@endsection
@section('main-content')
<div class="main-content">
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="courses.html">لیست محصول ها</a>
            <a class="tab__item" href="approved.html">محصول های  موجود</a>
            <a class="tab__item" href="new-course.html">محصول های  تمام شده</a>
            <a class="tab__item" href="create-new-course.html">ایجاد محصول جدید</a>
        </div>
    </div>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" >
                <div class="t-header-searchbox font-size-13">
                    <div type="text" class="text search-input__box ">جستجوی محصول</div>
                    <div class="t-header-search-content ">
                        <input type="text"  class="text"  placeholder="نام محصول">
                        <input type="text"  class="text" placeholder="قیمت">
                        <input type="text"  class="text margin-bottom-20" placeholder="دسته بندی">
                        <btutton class="btn btn-netcopy_net">جستجو</btutton>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table__box">
        <table class="table">

            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>شناسه</th>
                <th>کد کالا</th>
                <th>دسته کالا</th>
                <th>نام محصول</th>
                <th>قیمت (ریال)</th>
                <th>موجودی</th>
                <th> تعداد فروش</th>
                <th>تعداد بازدید</th>
                <th>ویژه</th>
                <th>وضعیت دوره</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($Products as $item)
                <tr role="row" >
                    <td><a href="">{{$item->sku}}</a></td>
                    <td><a href="">{{$item->id}}</a></td>
                    <td><a href="">{{$item->name}}</a></td>
                    <td><a href="">{{$item->product_name}}</a></td>
                    <td><a href="">{{number_format((float) ($item->price -  (($item->price  *  $item->discount) / 100)   ), 0, '', ',');}}</a></td>
                    <td><a href="">{{$item->stock}}</a></td>
                    <td><a href="">{{$item->sold}}</a></td>
                    <td><a href="">{{$item->view}}</a></td>
                    <td><a href="">@if ($item->is_featured == 1)
                       ویژه است
                    @else
                        ویژه نیست
                    @endif</a></td>
                    <td><a href="">@if ($item->status == "active")
                         فعال
                     @else
                         غیر فعال
                     @endif</a></td>
                    <td>

                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="" class="item-lock mlg-15" title="قفل "></a>
                        <a href="" target="_blank" class="item-eye mlg-15" title="ویژه کردن از ویژه در اوردن"></a>
                        <a href="" class="item-confirm mlg-15" title="باز"></a>
                        <a href="" class="item-edit " title="ویرایش"></a>
                     
                    </td>
                </tr>
                @endforeach



            </tbody>
        </table>
    </div>
</div>

@endsection

@extends('admin.layout.master')
@section('route')
    ویرایش تخفیف
@endsection
@section('main-content')
<!-- CSS برای Pikaday -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

<!-- JS کتابخانه‌ها -->
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/plugins/pikaday-jalali.js"></script>

<style>

    .container {
        max-width: 600px;
        margin-top: 50px;
    }
    .form-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .form-container h3 {
        margin-bottom: 20px;
        color: #343a40;
    }
    .btn-custom {
        background-color: #ffc107;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
    }
    .btn-custom:hover {
        background-color: #e0a800;
    }
    .discount-input {
        border: 2px solid #28a745; /* حاشیه سبز */
        border-radius: 8px; /* گوشه‌های گرد */
        padding: 10px;
        transition: all 0.3s ease-in-out;
    }
    .discount-input:focus {
        border-color: #218838;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
    }
    .description-input {
        border: 2px solid #17a2b8;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease-in-out;
        resize: none;
    }
    .description-input:focus {
        border-color: #138496;
        box-shadow: 0 0 10px rgba(23, 162, 184, 0.5);
    }
</style>

<div class="container">
    <div class="form-container shadow-lg">
        <h3 class="text-center">فرم ویرایش تخفیف</h3>
        <form action="{{ route('AdminPanel.Discount.Update', $discount->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- عنوان -->
            <div class="mb-3">
                <label for="title" class="form-label">عنوان</label>
                <input type="text" class="form-control discount-input" id="title" name="title" value="{{ old('title', $discount->title) }}" placeholder="عنوان تخفیف را وارد کنید" required>
            </div>

            <!-- توضیحات -->
            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea class="form-control description-input" id="description" name="description" rows="3" placeholder="توضیحات تخفیف را وارد کنید" required>{{ old('description', $discount->description) }}</textarea>
            </div>

            <!-- درصد تخفیف -->
            <div class="mb-3">
                <label for="discount" class="form-label">درصد تخفیف</label>
                <input type="number" class="form-control discount-input" id="discount" name="discount" min="1" max="100" value="{{ old('discount', $discount->discount_percent) }}" placeholder="1 تا 100" required>
            </div>

            <!-- تاریخ شروع تخفیف -->
            <div class="mb-3">
                <label for="start_date" class="form-label">تاریخ شروع تخفیف</label>
                <input type="text" class="form-control discount-input" id="start_date" name="start_date"
                    value="{{ old('start_date', \Morilog\Jalali\Jalalian::fromDateTime($discount->start_date)->format('Y/m/d')) }}" required>
            </div>


            <!-- تاریخ پایان تخفیف -->
            <div class="mb-3">
                <label for="end_date" class="form-label">تاریخ پایان تخفیف</label>
                <input type="text" class="form-control discount-input" id="end_date" name="end_date" value="{{ old('start_date', \Morilog\Jalali\Jalalian::fromDateTime($discount->end_date)->format('Y/m/d')) }}" required>
            </div>

            <!-- دکمه ثبت تغییرات -->
            <div class="text-center">
                <button type="submit" class="btn btn-custom">ویرایش تخفیف</button>
            </div>
        </form>
    </div>
</div>

<script>

    function a() {
        var startDatePicker = new Pikaday({
            field: document.getElementById('start_date'),
            format: 'YYYY/MM/DD', // فرمت شمسی
            toPersian: true, // فعال کردن تقویم شمسی
            persianNumbers: true, // اعداد فارسی
            showTime: false, // غیرفعال کردن زمان
            i18n: {
                previousMonth: 'ماه قبل',
                nextMonth: 'ماه بعد',
                months: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                weekdays: ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                weekdaysShort: ['ی', 'د', 'س', 'چ', 'پ', 'ج', 'ش']
            }
        });
        var startDatePicker = new Pikaday({
            field: document.getElementById('end_date'),
            format: 'YYYY/MM/DD', // فرمت شمسی
            toPersian: true, // فعال کردن تقویم شمسی
            persianNumbers: true, // اعداد فارسی
            showTime: false, // غیرفعال کردن زمان
            i18n: {
                previousMonth: 'ماه قبل',
                nextMonth: 'ماه بعد',
                months: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                weekdays: ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                weekdaysShort: ['ی', 'د', 'س', 'چ', 'پ', 'ج', 'ش']
            }
        });
    }
    a();
</script>


@endsection

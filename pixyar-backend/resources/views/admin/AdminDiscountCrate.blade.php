@extends('admin.layout.master')
@section('route')
    تخفیف ها
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
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
    }
    .btn-custom:hover {
        background-color: #218838;
    }
    .discount-input {
        border: 2px solid #28a745; /* حاشیه سبز */
        border-radius: 8px; /* گوشه‌های گرد */
        padding: 10px;
        transition: all 0.3s ease-in-out;
    }

    /* تغییر رنگ حاشیه هنگام فوکوس */
    .discount-input:focus {
        border-color: #218838; /* تغییر رنگ به سبز تیره */
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
    }
    .description-input {
        border: 2px solid #17a2b8; /* حاشیه آبی */
        border-radius: 8px; /* گوشه‌های گرد */
        padding: 10px;
        transition: all 0.3s ease-in-out;
        resize: none; /* جلوگیری از تغییر سایز */
    }

    /* تغییر رنگ حاشیه هنگام فوکوس */
    .description-input:focus {
        border-color: #138496; /* تغییر رنگ به آبی تیره */
        box-shadow: 0 0 10px rgba(23, 162, 184, 0.5);
    }
</style>
<div class="container">
    <div class="form-container shadow-lg">
        <h3 class="text-center">فرم ایجاد تخفیف</h3>
        <form action="{{ route('AdminPanel.Discount.Save') }}" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- عنوان -->
            <div class="mb-3">
                <label for="title" class="form-label">عنوان</label>
                <input type="text" class="form-control discount-input" id="title" name="title" placeholder="عنوان تخفیف را وارد کنید" required>
            </div>

            <!-- توضیحات -->
            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea class="form-control discount-input" id="description" name="description" rows="3" placeholder="توضیحات تخفیف را وارد کنید" required></textarea>
            </div>

            <!-- درصد تخفیف -->
            <div class="mb-3">
                <label for="discount" class="form-label">درصد تخفیف</label>
                <input type="number" class="form-control discount-input" id="discount" name="discount" min="1" max="100" placeholder="1to100" required>
            </div>

            <!-- تاریخ شروع تخفیف -->
            <div class="mb-3">
                <label for="start_date" class="form-label">تاریخ شروع تخفیف</label>
                <input type="text" class="form-control discount-input" id="start_date" name="start_date" value="{{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}"required>
            </div>

            <!-- تاریخ پایان تخفیف -->
            <div class="mb-3">
                <label for="end_date" class="form-label">تاریخ پایان تخفیف</label>
                <input type="text" class="form-control discount-input" id="end_date" name="end_date" value="{{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}" required>
            </div>

            <!-- دکمه ثبت -->
            <div class="text-center">
                <button type="submit" class="btn btn-custom">ثبت تخفیف</button>
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

@extends('layouts.app')

@section('title', '403 - دسترسی غیرمجاز')

@section('content')
<div style="text-align:center; padding:50px;">
    <h1 style="font-size:80px; color:#ff4444;">403</h1>
    <h2>دسترسی غیرمجاز</h2>
    <p>{{ $exception->getMessage() ?? 'شما به این قسمت دسترسی ندارید.' }}</p>

    <a href="{{ url()->previous() }}"
       style="display:inline-block; margin-top:20px; padding:10px 20px;
              background:#444; color:#fff; border-radius:6px; text-decoration:none;">
        بازگشت
    </a>
</div>
@endsection

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pixyar | تحلیل هوشمند اینستاگرام' }}</title>
    <meta name="description" content="پلتفرم هوش مصنوعی تحلیل و رشد پیج اینستاگرام — Pixyar">
    <meta name="keywords" content="Pixyar, Instagram Analytics, SaaS, داشبورد تحلیلی, آنالیز اینستاگرام">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="/images/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <div id="app">
        @yield('content')
    </div>
</body>
</html>

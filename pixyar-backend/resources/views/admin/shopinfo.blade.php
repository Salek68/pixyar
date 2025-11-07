<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نقشه ریسپانسیو</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="manifest" href="{{ asset('pwa/manifest.json') }}">
    <style>
        /* استایل ریسپانسیو نقشه */
        #map {
            z-index: 0;
            width: 100%;
            height: 100%; /* پیش‌فرض دسکتاپ */
        }

        @media (max-width: 768px) {
            #map {
                height: 100vh; /* در موبایل ارتفاع بیشتر می‌شود */
            }
            #coordinates {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                text-align: center;
                padding: 10px;
                font-size: 18px;
            }
        }

        .custom-tooltip {
            font-size: 1.2vw; /* اندازه فونت نسبت به عرض صفحه تغییر می‌کند */
            font-weight: bold;
            background: white;
            padding: 4px 8px;
            border-radius: 5px;
            border: 1px solid #555;
            color: #333;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .leaflet-control-attribution{
            display: none;
        }
        .filter-menu {
        position: fixed;
        bottom: -100%;
        left: 0;
        width: 100%;
        background: white;
        transition: 0.3s;
        padding: 15px;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
        border-radius: 15px 15px 0 0;
        max-height: 50vh; /* تنظیم حداکثر ارتفاع */
        overflow-y: auto; /* فعال‌سازی اسکرول */
    }
    .filter-menu.open {
        bottom: 0;
    }
    .filter-toggle {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        font-size: 2vh;
        font-weight: bold;
    }
    .filter-toggle1 {

        position: fixed;
        bottom: 93%;
        left: 86%;
        transform: translateX(-50%);
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 100%;
        cursor: pointer;
        font-size: 18px;
        width: 100%;
        height: 100%;
    }
    .filter-menu a, .filter-menu label {
        display: block;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        color: #333;
        text-decoration: none;
    }
    .filter-menu label { cursor: pointer; }

    /* دکمه بستن */
    .close-filter {
        font-size: 30px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 40px;
        color: #ff0000;
        cursor: pointer;
    }
</style>


<body>
    <script src="{{ asset('service-worker-registration.js') }}"></script>



<div id="map"></div>



<style>
  .circle {
    width: 5vh;
    height: 5vh;
    background-color: rgb(255, 255, 255);
    border-radius: 50%;
    position: absolute;
    bottom: 93%;
    left: 84%;

    /* مرکز کردن محتوا */
    display: flex;
    justify-content: center;
    align-items: center;

    /* سایه زیبا */
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
  }

  .logout i {
    font-size: 3vh; /* اندازه آیکون */
    color: rgb(0, 0, 0); /* رنگ آیکون */
    margin-left: 5px;
  }
  .category-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* فاصله بین آیتم‌ها */
}

.category-item {
    display: inline-block;
    padding: 5px 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-decoration: none;
    color: #333;
    transition: all 0.2s ease;
}

.category-item.hidden {
    visibility: hidden;
    position: absolute;
    width: 0;
    height: 0;
    margin: 0;
    padding: 0;
}

</style>






<script>
alert("برای تعغیر لوکیشن فروشگاه روی مکان مورد نظر در نقشه کلیک کنید ")


// function updateLocation() {
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(function (position) {
//             let latitude = position.coords.latitude;
//             let longitude = position.coords.longitude;

//             // اگر مارکر قبلاً وجود داشته باشد، آن را حذف کنید
//             if (userMarker) {
//                 map.removeLayer(userMarker);
//             }

//             // مارکر جدید برای موقعیت کاربر
//             userMarker = L.marker([latitude, longitude]).addTo(map);
//             userMarker.bindPopup("موقعیت شما").openPopup();

//             // موقعیت نقشه را به موقعیت کاربر تغییر دهید
//             map.setView([latitude, longitude], 13);

//             // اضافه کردن ابر به موقعیت کاربر
//             L.circle([latitude, longitude], {
//                 color: 'blue',
//                 fillColor: '#30f',
//                 fillOpacity: 0.2,
//                 radius: 200
//             }).addTo(map).bindPopup('این موقعیت شما است!');
//         }, function (error) {
//             alert("خطا در دریافت موقعیت: ", error);
//         });
//     } else {
//         alert("مرورگر شما از Geolocation پشتیبانی نمی‌کند.");
//     }
// }


// // هر 60 ثانیه موقعیت را بروزرسانی کنید
// // setInterval(updateLocation, 60000);

// // اولین بار موقعیت را بروزرسانی کنید
// updateLocation();



 // بررسی اینکه آیا مرورگر قابلیت دسترسی به موقعیت جغرافیایی دارد یا نه


 var map = L.map('map', {
    center: [36.3186, 59.5890], // مشهد
    zoom: 13,
    zoomControl: false // غیرفعال کردن دکمه‌های زوم
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var stores = @json($stores); // تبدیل داده‌های لاراول به جاوا اسکریپت
// console.log(stores);

var markers = []; // ذخیره‌ی مارکرها

stores.forEach(store => {
    var discountsList = store.discounts.length > 0
        ? `<ul style="text-align: right; padding: 0; list-style: none;">
            ${store.discounts.map(discount => `<li>• ${discount.description}</li>`).join('')}
           </ul>`
        : '<p>تخفیفی موجود نیست</p>';

    var marker = L.marker([store.latitude, store.longitude]).addTo(map)
        .bindPopup(`
            <div style="text-align: center;">
                <h3>${store.name}</h3>
                <p><b>آدرس:</b> ${store.address}</p>
                <p><b>تخفیفات:</b></p>
                ${discountsList}
                <button onclick="navigateTo(${store.latitude}, ${store.longitude})"
                    style="background: green; color: white; padding: 5px 10px; border: none; cursor: pointer; margin-top: 10px;">
                    مسیریابی
                </button>
            </div>
        `);

    if (stores.length < 20) {
        marker.tooltip = marker.bindTooltip(store.category.name, {
            permanent: true,
            direction: "right",
            offset: [15, 0],
            opacity: 0.9,
        }).openTooltip();
    }

    markers.push(marker);

    marker.on('click', function () {
    map.setView([store.latitude, store.longitude], 20);
});

});
map.on('click', function (e) {
    var lat = e.latlng.lat.toFixed(6);
    var lng = e.latlng.lng.toFixed(6);

  var storeId = @json(Crypt::decrypt(session('store_id')));;
  var userId = @json(Crypt::decrypt(session('user_id')));;


    fetch(`/Stores/${storeId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            latitude: lat,
            longitude: lng,
            user_id: userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.store.id) {
            alert("فروشگاه با موفقیت به‌روزرسانی شد!\n" + data.adress);
            window.location.href = "{{ route('AdminPanel.Index') }}";
        } else {
            alert("خطایی رخ داد. لطفاً دوباره امتحان کنید.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("مشکلی در ارسال اطلاعات به سرور پیش آمد.");
    });
});

map.on('zoomend', function () {
    var currentZoom = map.getZoom();

    markers.forEach(marker => {
        // مدیریت نمایش یا مخفی‌سازی تولتیپ
        if (marker.tooltip) {
            if (currentZoom <= 13) {
                marker.getTooltip().setOpacity(0);
            } else {
                marker.getTooltip().setOpacity(0.9); // نمایش مجدد تولتیپ
            }
        }

        // تغییر اندازه مارکر
        var baseSize = 32; // اندازه پیش‌فرض
        var minSize = 16;  // کمترین اندازه مارکر
        var newSize = currentZoom < 10 ? minSize : baseSize;

        marker.setIcon(L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
            iconSize: [newSize, newSize],
            iconAnchor: [newSize / 2, newSize],
            popupAnchor: [0, -newSize]
        }));
    });
});

// function navigateTo(lat,lon) {
//     var neshanUrl = `https://neshan.org/maps/routing/car/destination/${lat},${lon}`;

//     // باز کردن لینک در تب جدید
//     window.open(neshanUrl, '_blank');
// }

function navigateTo(lat, lon) {
    var userAgent = navigator.userAgent || navigator.vendor;

    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        window.location.href = `neshan://maps/directions?destination=${lat},${lon}`;
    } else {
        window.location.href = `https://maps.google.com/?daddr=${lat},${lon}`;
}
}
</script>


</body>
</html>

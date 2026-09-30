<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حالة الطقس</title>
    <style>
        body { font-family: Tahoma, sans-serif; padding: 20px; text-align: center; background-color: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 400px; margin: 0 auto; }
        input[type="text"] { padding: 10px; width: 60%; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>استعلم عن حالة الطقس</h2>

    <!-- نموذج البحث عن مدينة -->
    <form action="{{ route('weather.show') }}" method="GET" style="margin-bottom: 20px;">
        <input type="text" name="city" placeholder="أدخل اسم المدينة (مثال: Cairo)" value="{{ $city }}">
        <button type="submit">ابحث</button>
    </form>

    <div class="card">
        @if(isset($error))
            <div class="error">{{ $error }}</div>
        @elseif(isset($weather))
            <!-- عرض بيانات الطقس -->
            <h3>المدينة: {{ $weather['name'] }}</h3>

            <!-- جلب أيقونة الطقس من الـ API -->
            <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" alt="أيقونة الطقس">

            <p><strong>الوصف:</strong> {{ $weather['weather'][0]['description'] }}</p>
            <p><strong>درجة الحرارة:</strong> {{ $weather['main']['temp'] }} °C</p>
            <p><strong>الرطوبة:</strong> {{ $weather['main']['humidity'] }}%</p>
            <p><strong>سرعة الرياح:</strong> {{ $weather['wind']['speed'] }} م/ث</p>
        @endif
    </div>

</body>
</html>

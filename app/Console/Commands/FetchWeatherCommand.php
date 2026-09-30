<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FetchWeatherCommand extends Command
{
    // اسم الأمر الذي سنستخدمه لتشغيله (مثلاً: php artisan weather:fetch)
    protected $signature = 'weather:fetch';

    // وصف قصير للأمر يظهر عند طباعة php artisan list
    protected $description = 'يجلب حالة الطقس للمدن الكبرى ويحفظها في الكاش';

    public function handle()
    {
        // قائمة المدن الكبرى التي نريد تحديثها دورياً
        $cities = ['Damascus', 'Aleppo', 'Homs', 'Latakia'];
        $apiKey = config('services.openweathermap.key');

        $this->info('جاري بدء تحديث بيانات الطقس...'); // رسالة تظهر في الـ Terminal

        foreach ($cities as $city) {
            $cacheKey = 'weather_' . strtolower($city);

            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'ar'
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();

                Cache::put($cacheKey, $weatherData, now()->addMinutes(65));

                $this->info("تم تحديث الكاش بنجاح لمدينة: {$city}");
            } else {
                $this->error("فشل في جلب بيانات المدينة: {$city}");
            }
        }

        $this->info('اكتملت المهمة.');
    }
}

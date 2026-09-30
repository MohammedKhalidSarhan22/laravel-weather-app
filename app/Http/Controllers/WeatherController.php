<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function show(Request $request)
    {
        $city = $request->input('city', 'Damascus');
        $apiKey = config('services.openweathermap.key');

        $cacheKey = 'weather_' . strtolower($city);

        $weatherData = Cache::get($cacheKey);

        if (! $weatherData) {

            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'ar'
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();

                Cache::put($cacheKey, $weatherData, now()->addMinutes(15));
            } else {
                Log::error('Weather API failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                return view('weather', [
                    'error' => 'عذراً، لم نتمكن من جلب حالة الطقس لمدينة ' . $city . '. تأكد من صحة الاسم.',
                    'city' => $city
                ]);
            }
        }

        return view('weather', [
            'weather' => $weatherData,
            'city' => $city
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Collection;

class AppService
{
    public static function getPublicInformation() : Collection
    {
        $settings = Setting::whereIn('key', ['app_name', 'app_logo'])->get();
        $settings = $settings->keyBy('key');

        $settings = $settings->map(function($item) {
            return $item['value'];
        });

        return $settings;
    }
}

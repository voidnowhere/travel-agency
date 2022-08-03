<?php

namespace App\Iframes;

class CityIframe
{
    public static string $iframeCUId = 'iframe_city_cu';
    public static string $parentIframeId = 'iframe_cities';

    public static function iframeCUClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . static::$iframeCUId . "').classList.add('hidden');";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(int $country_id): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.cities', ['country' => $country_id]) . "';";
        $script .= '</script>';
        return $script;
    }

    public static function unloadParent(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . static::$parentIframeId . "').src = '';";
        $script .= '</script>';
        return $script;
    }
}

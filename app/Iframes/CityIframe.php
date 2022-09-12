<?php

namespace App\Iframes;

class CityIframe
{
    public static string $iframeCUId = 'iframe_city_cu';
    public static string $iframeDId = 'iframe_city_d';
    public static string $parentIframeId = 'iframe_cities';

    public static function iframeCUClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$iframeCUId . "').classList.add('hidden');";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(int $countryId): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.cities', ['country' => $countryId]) . "';";
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

    public static function hideIframeD()
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . static::$iframeDId . "').classList.add('hidden')";
        $script .= '</script>';
        return $script;
    }
}

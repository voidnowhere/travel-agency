<?php

namespace App\Iframes;

class CityIframe
{
    public static string $iframeId = 'iframe_city_cu';
    public static string $parentIframeId = 'iframe_cities';

    public static function iframeClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.querySelector('#" . static::$iframeId . "').classList.add('hidden');";
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').contentDocument.location.reload()";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(int $country_id): string
    {
        $script = '<script>';
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').src = '';";
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').src = '" . route('admin.cities', ['country' => $country_id]) . "';";
        $script .= '</script>';
        return $script;
    }

    public static function unLoadParent(): string
    {
        $script = '<script>';
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').src = '';";
        $script .= '</script>';
        return $script;
    }
}

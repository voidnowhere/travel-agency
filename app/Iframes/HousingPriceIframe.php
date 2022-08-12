<?php

namespace App\Iframes;

class HousingPriceIframe
{
    public static string $iframeCUId = 'iframe_housing_prices_cu';
    public static string $iframeDId = 'iframe_housing_prices_d';
    public static string $parentIframeId = 'iframe_housing_prices';

    public static function iframeCUClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$iframeCUId . "').classList.add('hidden');";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.housing.prices') . "'";
        $script .= '</script>';
        return $script;
    }
}

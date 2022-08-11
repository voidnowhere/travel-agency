<?php

namespace App\Iframes;

class HousingIframe
{
    public static string $iframeCUId = 'iframe_housing_cu';
    public static string $iframeDId = 'iframe_housing_d';
    public static string $parentIframeId = 'iframe_housings';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.housings') . "'";
        $script .= '</script>';
        return $script;
    }
}

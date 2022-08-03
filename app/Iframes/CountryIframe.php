<?php

namespace App\Iframes;

class CountryIframe
{
    public static string $iframeCUId = 'iframe_country_cu';
    public static string $parentIframeId = 'iframe_countries';

    public static function iframeCUClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . static::$iframeCUId . "').classList.add('hidden');";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(bool $fromCUIframe = false): string
    {
        $script = '<script>';
        $script .= ($fromCUIframe) ? 'parent.' : '';
        $script .= "document.location.href = '" . route('admin.countries') . "'";
        $script .= '</script>';
        return $script;
    }
}

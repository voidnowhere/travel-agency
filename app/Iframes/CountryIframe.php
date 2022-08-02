<?php

namespace App\Iframes;

class CountryIframe
{
    public static string $iframeId = 'iframe_country_cu';
    public static string $parentIframeId = 'iframe_countries';

    public static function iframeClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.querySelector('#" . static::$iframeId . "').classList.add('hidden');";
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').contentDocument.location.reload()";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(): string
    {
        $script = '<script>';
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').src = '';";
        $script .= "parent.document.querySelector('#" . static::$parentIframeId . "').src = '" . route('admin.countries') . "';";
        $script .= '</script>';
        return $script;
    }
}

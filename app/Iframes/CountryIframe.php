<?php

namespace App\Iframes;

class CountryIframe
{
    public static string $iframeCUId = 'iframe_country_cu';
    public static string $iframeDId = 'iframe_country_d';
    public static string $parentIframeId = 'iframe_countries';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.countries') . "'";
        $script .= '</script>';
        return $script;
    }

    public static function parentFocusRow(int $countryId): string
    {
        $script = '<script>';
        $script .= "let iframe = parent.document.getElementById('" . self::$parentIframeId . "');";
        $script .= "function focusTableTr() { iframe.contentWindow.focusTableTr(" . $countryId . "); iframe.removeEventListener('load', focusTableTr); }";
        $script .= "iframe.addEventListener('load', focusTableTr);";
        $script .= '</script>';
        return $script;
    }
}

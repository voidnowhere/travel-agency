<?php

namespace App\Iframes;

class SeasonIframe
{
    public static string $iframeCUId = 'iframe_season_cu';
    public static string $iframeDId = 'iframe_season_d';
    public static string $parentIframeId = 'iframe_seasons';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.seasons') . "'";
        $script .= '</script>';
        return $script;
    }
}

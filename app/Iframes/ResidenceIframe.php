<?php

namespace App\Iframes;

class ResidenceIframe
{
    public static string $iframeCUId = 'iframe_residence_cu';
    public static string $iframeDId = 'iframe_residence_d';
    public static string $parentIframeId = 'iframe_residences';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.residences') . "'";
        $script .= '</script>';
        return $script;
    }
}

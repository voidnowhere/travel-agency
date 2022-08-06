<?php

namespace App\Iframes;

class ResidenceCategoryIframe
{
    public static string $iframeCUId = 'iframe_residence_category_cu';
    public static string $iframeDId = 'iframe_residence_category_d';
    public static string $parentIframeId = 'iframe_residence_categories';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.residence.categories') . "'";
        $script .= '</script>';
        return $script;
    }
}

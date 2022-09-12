<?php

namespace App\Iframes;

class HousingCategoryIframe
{
    public static string $iframeCUId = 'iframe_housing_category_cu';
    public static string $iframeDId = 'iframe_housing_category_d';
    public static string $parentIframeId = 'iframe_housing_categories';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.housing.categories') . "'";
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

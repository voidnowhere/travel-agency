<?php

namespace App\Iframes;

class HousingFormulaIframe
{
    public static string $iframeCUId = 'iframe_housing_formula_cu';
    public static string $iframeDId = 'iframe_housing_formula_d';
    public static string $parentIframeId = 'iframe_housing_formulas';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.housing.formulas') . "'";
        $script .= '</script>';
        return $script;
    }
}

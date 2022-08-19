<?php

namespace App\Iframes;

class OrderIframe
{
    public static string $iframeCUId = 'iframe_order_cu';
    public static string $iframeDId = 'iframe_order_d';
    public static string $parentIframeId = 'iframe_orders';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('orders') . "'";
        $script .= '</script>';
        return $script;
    }
}

<?php

namespace App\Iframes;

class OrderIframe
{
    public static string $iframeCUId = 'iframe_order_cu';
    public static string $iframeDId = 'iframe_order_d';
    public static string $priceDetailIframeId = 'iframe_order_price_details';
    public static string $parentIframeId = 'iframe_orders';

    public static function iframeCUClose(): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$iframeCUId . "').classList.add('hidden');";
        $script .= '</script>';
        return $script;
    }

    public static function reloadParent(int $userId): string
    {
        $script = '<script>';
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.orders', ['user' => $userId]) . "'";
        $script .= '</script>';
        return $script;
    }
}

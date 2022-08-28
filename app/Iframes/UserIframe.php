<?php

namespace App\Iframes;

class UserIframe
{
    public static string $iframeCUId = 'iframe_user_cu';
    public static string $parentIframeId = 'iframe_users';

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
        $script .= "parent.document.getElementById('" . self::$parentIframeId . "').src = '" . route('admin.users') . "'";
        $script .= '</script>';
        return $script;
    }
}

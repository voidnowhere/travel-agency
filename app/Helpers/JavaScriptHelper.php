<?php

namespace App\Helpers;

class JavaScriptHelper
{
    public static function alert(string $message): string
    {
        $script = '<script>';
        $script .= 'alert("' . $message . '")';
        $script .= '</script>';
        return $script;
    }
}

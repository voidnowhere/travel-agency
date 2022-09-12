<?php

namespace App\Helpers;

use App\CDN\PackageCDN;

class NotiflixHelper
{
    public static function report(string $message, string $type, string $iframeDId): string
    {
        $script = '<body>';
        $script .= PackageCDN::notiflix();
        $script .= '<script>';

        if ($type === 'failure') {
            $script .= 'try {';
            $script .= 'Notiflix.Report.failure(';
            $script .= "'Error',";
            $script .= "'$message',";
            $script .= "'Okay',";
            $script .= "() => { parent.document.getElementById('$iframeDId').classList.add('hidden'); },";
            $script .= "{ backOverlay: false, },);";
            $script .= "} catch (err) { alert('$message'); }";
        }

        $script .= '</script>';
        $script .= '</body>';

        return $script;
    }
}

<?php

namespace App\CDN;

class PackageCDN
{
    public static function alpinejs()
    {
        return '<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.3/cdn.js" integrity="sha512-KnYVZoWDMDmJwjmoUEcEd//9bap1dhg0ltiMWtdoKwvVdmEFZGoKsFhYBzuwP2v2iHGnstBor8tjPcFQNgI5cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
    }

    public static function notiflix()
    {
        return '<script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/dist/notiflix-aio-3.2.5.min.js" integrity="sha256-LQj8h+SKqntnw8M/FP7QM+3dTqgHvB1JzZMVPD868Rg=" crossorigin="anonymous"></script>';
    }

    public static function jquery()
    {
        return '<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>';
    }

    public static function jqueryUI()
    {
        return '<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>';
    }

    public static function jqueryUICSS()
    {
        return '<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">';
    }
}

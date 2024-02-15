<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;



if (! function_exists('convertLocalToUTC')) {
    function convertLocalToUTC($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'Europe/Paris')->setTimezone('UTC');
    }
}

if (! function_exists('convertUTCToLocal')) {
    function convertUTCToLocal($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time, 'UTC')->setTimezone('Europe/Paris');
    }
}


if (! function_exists('base64url_encode')) {
    function base64url_encode($plainText)
    {
        return strtr(base64_encode($plainText), '+/=', '-_,');
    }
}

if (! function_exists('base64url_decode')) {
    function base64url_decode($b64Text)
    {
        return base64_decode(strtr($b64Text, '-_,', '+/='));
    }
}

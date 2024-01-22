<?php

namespace App\Util;

class AuthorizationResponses
{
    public static string $NOT_ALLOWED;

    public static function notAllowedResponse(): string
    {
        self::$NOT_ALLOWED = 'You are not permitted to do this action.';

        return self::$NOT_ALLOWED;
    }
}

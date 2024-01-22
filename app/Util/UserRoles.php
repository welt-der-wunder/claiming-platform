<?php

namespace App\Util;

class UserRoles
{
    public static string $ROLE_USER = 'User';
    public static string $ROLE_ADMIN = 'Admin';

    /**
     * @return string|string[]
     */
    public static function getAllRoles(bool $implode = false)
    {
        $arr = [
            self::$ROLE_USER,
            self::$ROLE_ADMIN
        ];

        return $implode ? implode(',', $arr) : $arr;
    }
}

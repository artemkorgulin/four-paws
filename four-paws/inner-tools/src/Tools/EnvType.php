<?php

namespace FourPaws\Innertools\Tools;

class EnvType
{
    const PROD = 'prod';

    const DEV = 'dev';

    /**
     * @return string
     */
    public static function getServerType()
    {
        if (
            (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == self::DEV)
            || (isset($_SERVER['HTTP_APP_ENV']) && $_SERVER['HTTP_APP_ENV'] == self::DEV)
            || (isset($_COOKIE['DEV']) && $_COOKIE['DEV'] == 'Y')
            || getenv('APP_ENV') == self::DEV
        ) {
            return self::DEV;
        } else {
            return self::PROD;
        }
    }

    /**
     * @return bool
     */
    public static function isProd()
    {
        return self::getServerType() === self::PROD;
    }

    /**
     * @return bool
     */
    public static function isDev()
    {
        return self::getServerType() === self::DEV;
    }

}

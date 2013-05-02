<?php
/**
 * Класс-фасад для кэша
 * @file    Cache.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Ноя 16 20:42:01 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache;

use \Veles\Config;
use \Veles\Cache\Drivers\iCacheDriver;

/**
 * Класс AbstractCache
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Cache
{
    private static $driver;

    /**
     * Инициализация драйвера кэша
     * @param string $driver_name Имя дравйвера
     * @return iCacheDriver
     */
    final public static function init($driver_name = 'APC')
    {
        $driver_class = "\\Veles\\Cache\\Drivers\\$driver_name";
        static::$driver = new $driver_class;

        return static::$driver;
    }

    /**
     * Инстанс кэша
     * @return Cache
     */
    final public static function getDriver()
    {
        if (self::$driver instanceof iCacheDriver) {
            return static::$driver;
        }

        return static::init();
    }

    /**
     * Получение данных
     * @param string $key Ключ
     * @return mixed
     */
    final static public function get($key)
    {
        return self::getDriver()->get($key);
    }

    /**
     * Сохранение данных
     * @param string $key Ключ
     * @param mixed $value Данные
     * @return bool
     */
    final public static function set($key, $value)
    {
        return self::getDriver()->set($key, $value);
    }

    /**
     * Проверка существуют ли данные в кэше
     * @param string $key Ключ
     * @return bool
     */
    final public static function has($key)
    {
        return self::getDriver()->has($key);
    }

    /**
     * Удаление данных
     * @param string $key Ключ
     * @return bool
     */
    final public static function del($key)
    {
        return self::getDriver()->del($key);
    }

    /**
     * Очистка кэша
     * @return bool
     */
    final public static function clear()
    {
        return self::getDriver()->clear();
    }
}
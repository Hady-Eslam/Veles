<?php
/**
 * Adapter for APC cache
 *
 * @file    ApcAdapter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Птн Ноя 16 22:09:28 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Cache\Drivers;

use Exception;

/**
 * Class ApcAdapter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class ApcAdapter extends CacheAdapterAbstract implements iCacheAdapter
{
	/** @var iCacheAdapter */
	private static $instance;

	/**
	 * Constructor
	 */
	final protected function __construct()
	{
		if (!function_exists('apc_add')) {
			throw new Exception('APC cache not installed!');
		}
	}

	/**
	 * @return iCacheAdapter
	 */
	final public static function instance()
	{
		if (null === static::$instance) {
			$class = get_called_class();
			static::$instance = new $class;
		}

		return static::$instance;
	}

	/**
	 * Get data
	 * @param string $key Key
	 * @return mixed
	 */
	public function get($key)
	{
		return apc_fetch($key);
	}

	/**
	 * Save data
	 *
	 * @param string $key Key
	 * @param mixed $value Data
	 * @param int $ttl Time to live
	 * @return mixed
	 */
	public function set($key, $value, $ttl = 0)
	{
		return apc_add($key, $value, $ttl);
	}

	/**
	 * Check if data stored in cache
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function has($key)
	{
		apc_exists($key);
	}

	/**
	 * Delete data
	 *
	 * @param string $key Key
	 * @return bool
	 */
	public function del($key)
	{
		return apc_delete($key);
	}

	/**
	 * Cache cleanup
	 *
	 * @return bool
	 */
	public function clear()
	{
		return apc_clear_cache();
	}
}
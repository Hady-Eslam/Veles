<?php
/**
 * Byte values validator
 * @file    Byte.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Фев 17 10:48:43 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Validators;

/**
 * Class Byte
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class Byte implements iValidator
{

	/**
	 * Check byte values
	 * @param mixed $size Size in bytes
	 * @return bool
	 */
	public function check($size)
	{
		return is_numeric($size);
	}

	/**
	 * Convert byte values to human readable format
	 * @param int $size Size in bytes
	 * @param int $precision Precision of returned values
	 * @return string
	 */
	public static function format($size, $precision = 2)
	{
		$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

		$size = max($size, 0);
		$pow = floor(($size ? log($size) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$size /= (1 << (10 * $pow));

		return number_format($size, $precision) . ' ' . $units[$pow];
	}
}

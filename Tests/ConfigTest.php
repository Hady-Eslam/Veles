<?php
/**
 * Юнит-тест для класса Config
 * @file    ConfigTest.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Янв 22 22:12:23 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests;

use PHPUnit_Framework_TestCase;
use Veles\Config;

if (!defined('ENVIRONMENT')) {
	define('ENVIRONMENT', 'development');
}

if (!defined('CONFIG_FILE')) {
	define('CONFIG_FILE', __DIR__ . '/Project/settings.ini');
}

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-22 at 22:11:53.
 * @group RootClasses
 */
class ConfigTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for Config::getParams
	 * @group RootClasses
	 * @covers Veles\Config::getParams
	 * @covers Veles\Config::read
	 * @covers Veles\Config::getParams
	 * @covers Veles\Config::buildPramsTree
	 * @covers Veles\Config::initInheritance
	 * @dataProvider getParamsProvider
	 * @see    Veles\Config
	 */
	public function testGetParams($param, $expected)
	{
		ConfigChild::dataCleanup();

		$result = Config::getParams($param);

		$msg = 'Config returned wrong params';
		self::assertEquals($expected, $result, $msg);
	}

	/**
	 * Data-provider for testGetParams
	 */
	public function getParamsProvider()
	{
		$php = [
			'display_errors'  => '1',
			'log_errors'      => '1',
			'' => [
				'xdebug.cli_color'                => '1',
				'xdebug.var_display_max_children' => '-1',
			]
		];
		return [['php', $php], ['db', []]];
	}
}

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

namespace Veles\Tests\Validators;

use PHPUnit_Framework_TestCase;
use Veles\Validators\Number;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-05-24 at 08:30:49.
 */
class NumberTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Number
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Number;
	}

	/**
	 * @covers Veles\Validators\Number::check
	 * @group  Validators
	 * @see	   Number::check()
	 * @dataProvider checkProvider
	 */
	public function testCheck($number, $expected)
	{
		$result = $this->object->check($number);

		$msg = 'Wrong Number::check() validation';
		$this->assertSame($expected, $result, $msg);
	}

	public function checkProvider()
	{
		return array(
			array(34, true),
			array('34', true),
			array(2147483649, false)
		);
	}
}

<?php
/**
 * Byte values validator
 * @file    Byte.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Фев 17 10:48:43 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests\Validators;

use PHPUnit_Framework_TestCase;
use Veles\Validators\RegEx;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-05-26 at 09:40:24.
 */
class RegExTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Veles\Validators\RegEx::check
	 * @covers Veles\Validators\RegEx::__construct
     * @group Validators
	 * @see RegEx::check()
	 * @dataProvider checkProvider
     */
    public function testCheck($pattern, $value, $expected)
    {
		$object = new RegEx($pattern);

		$msg = 'Wrong value of RegEx::pattern';
		$this->assertAttributeSame($pattern, 'pattern', $object, $msg);

		$result = $object->check($value);

		$msg = 'Wrong RegEx::check() validation';
		$this->assertSame($expected, $result, $msg);
    }

	public function checkProvider()
	{
		return [
			[
				'/^\/(?:index.html|page\-(\d+)\.html)?$/',
				'/index.html',
				true
			],
			[
				'/^\/(?:index.html|page\-(\d+)\.html)?$/',
				'/page-19.html',
				true
			],
			[
				'/^\/(?:index.html|page\-(\d+)\.html)?$/',
				'/page-1d9.html',
				false
			]
		];
	}

    /**
     * @covers Veles\Validators\RegEx::validate
	 * @group Validators
	 * @see RegEx::validate()
	 * @dataProvider validateProvider
     */
    public function testValidate($pattern, $value, $expected)
    {
		$result = RegEx::validate($pattern, $value);

		$msg = 'Wrong RegEx::validate() validation';
		$this->assertSame($expected, $result, $msg);
    }

	public function validateProvider()
	{
		return [
			[
				'/^\/(?:index.html|page\-(\d+)\.html)?$/',
				'/index.html',
				true
			],
			[
				'/^\/(?:index.html|page\-(\d+)\.html)?$/',
				'/page-19.html',
				true
			],
			[
				'/^\/(?:index.html|page\-(\d+)\.html)?$/',
				'/page-1d9.html',
				false
			]
		];
	}
}

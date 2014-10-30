<?php
/**
 * Юнит-тест для класса Helper
 * @file    HelperTest.php
 *
 * PHP version 5.4+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Янв 20 15:25:01 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests;

use PHPUnit_Framework_TestCase;
use Veles\Helper;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-20 at 12:06:50.
 */
class HelperTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for Helper::getStr
	 * @group RootClasses
	 * @covers Veles\Helper::genStr
	 * @dataProvider genStrProvider
	 * @see Helper::getStr
	 */
	public function testGenStr($length, $letters)
	{
		if (null === $length && null === $letters) {
			$length  = 22;
			$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
			$result  = Helper::genStr();
		} else {
			$result = Helper::genStr($length, $letters);
		}

		$result_length = strlen($result);
		$unknown_array = [];

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('string', $result, $msg);

		$msg = "Wrong result length: $result_length";
		$this->assertSame($length, $result_length, $msg);

		for ($i = 0; $i < $result_length; ++$i) {
			if (false === strpos($letters, $result[$i])) {
				$unknown_array[] = '"' . $result[$i] . '"';
			}
		}

		$msg = 'Result contains unknown symbols: ' . implode(',', $unknown_array);
		$this->assertTrue(empty($unknown_array), $msg);
	}

	/**
	 * DataProvider for HelperTest::testGenStr()
	 */
	public function genStrProvider()
	{
		return [
			[null, null],
			[21, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./'],
			[30, 'ABCDEFGHIJKLMNOPQRSTUVWX%$#'],
			[30, 'A|@абвгдеёжзийклмнопрстуфхцчшщъыьэюя%$#']
		];
	}

	/**
	 * Unit-test for Helper::validateEmail
	 * @group RootClasses
	 * @covers Veles\Helper::validateEmail
	 * @dataProvider validateEmailProvider
	 * @see Helper::validateEmail
	 */
	public function testValidateEmail($email, $expected)
	{
		$result = Helper::validateEmail($email);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('bool', $result, $msg);

		$txt_result = $result ? 'true' : 'false';
		$msg = "Email $email has wrong validation result: $txt_result";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for HelperTest::testValidateEmail
	 */
	public function validateEmailProvider()
	{
		return [
			['nd_lk.test-pro@mail.ru', true],
			['nd/lk@mail.ru', false],
			['false/email@mailer.ru', false],
			['email@wrong-domain', false],
			['email@wrong_domain.wrongLd', false],
			['email@wrong_domain.wro-d', false]
		];
	}

	/**
	 * Unit-test for Helper::checkEmailDomain
	 * @group RootClasses
	 * @covers Veles\Helper::checkEmailDomain
	 * @dataProvider checkEmailDomainProvider
	 * @see Helper::checkEmailDomain
	 * @todo Find faster way to check domain
	 */
	public function testCheckEmailDomain($email, $expected)
	{
//		$this->markTestSkipped('Skipped, because this test is too slow');
		$result = Helper::checkEmailDomain($email);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('bool', $result, $msg);

		$txt_result = $result ? 'true' : 'false';
		$msg = "Email $email has wrong validation result: $txt_result";
		$this->assertTrue($expected === $result, $msg);
	}

	/**
	 * DataProvider for HelperTest::testCheckEmailDomain
	 */
	public function checkEmailDomainProvider()
	{
		return [
			['webmaster@itvault.info', true],
			['false@itvault.info', true]
		];
	}

	/**
	 * Unit-test for Helper::translit
	 * @group RootClasses
	 * @covers Veles\Helper::translit
	 * @dataProvider translitProvider
	 * @see Helper::translit
	 */
	public function testTranslit($text, $expected)
	{
		$result = Helper::translit($text);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('string', $result, $msg);

		$msg = "Text \"$text\" has wrong translit result: \"$result\"";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for HelperTest::testTranslit
	 */
	public function translitProvider()
	{
		return [
			[
				'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёждийклмнопрстуфхцчшщъыьэюя ".,!?()#@*&[]:;<>+',
				'abvgdeyozhzijklmnoprstufhtschshshhyeyuyaabvgdeyozhdijklmnoprstufhtschshshhyeyuya-'
			]
		];
	}

	/**
	 * Unit-test for Helper::makeAlias
	 * @group RootClasses
	 * @covers Veles\Helper::makeAlias
	 * @depends testTranslit
	 * @dataProvider makeAliasProvider
	 * @see Helper::makeAlias
	 */
	public function testMakeAlias($url, $expected)
	{
		$result = Helper::makeAlias($url);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('string', $result, $msg);

		$msg = "URL \"$url\" has wrong make alias result: \"$result\"";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for HelperTest::testMakeAlias
	 */
	public function makeAliasProvider()
	{
		return [
			['Кровельная черепица', 'krovelnaya-cherepitsa'],
			['Внеземные цивилизации', 'vnezemnye-tsivilizatsii']
		];
	}
}

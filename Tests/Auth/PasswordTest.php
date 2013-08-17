<?php
/**
 * Юнит-тест для класса Password
 * @file    PasswordTest.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Вск Янв 20 15:58:07 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests\Auth;

use PHPUnit_Framework_TestCase;
use Veles\Auth\Password;
use Veles\Helper;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-22 at 08:31:29.
 */
class PasswordTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Unit-test for Password::checkCookieHash
	 * @group Auth
	 * @covers Veles\Password::checkCookieHash
	 * @dataProvider checkCookieHashProvider
	 * @see Password::checkCookieHash
	 */
	public function testCheckCookieHash($user, $cookie_hash, $expected)
	{
		$result = Password::checkCookieHash($user, $cookie_hash);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('bool', $result, $msg);

		$txt_result = $result ? 'true' : 'false';
		$msg = "CheckCookieHash \"$cookie_hash\" has wrong result: $txt_result";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for PasswordTest::testCheckCookieHash
	 */
	public function checkCookieHashProvider()
	{
		$user = new User;
		$user->hash = crypt('password', '$2a$07$' . Helper::genStr() . '$');

		return array(
			array($user, $user->getCookieHash(), true),
			array($user, 'wrongHash', false)
		);
	}

	/**
	 * Unit-test for Password::check
	 * @group Auth
	 * @covers Veles\Password::check
	 * @dataProvider checkProvider
	 * @see Password::check
	 */
	public function testCheck($user, $password, $expected)
	{
		$result = Password::check($user, $password);

		$msg = 'Wrong result type: ' . gettype($result);
		$this->assertInternalType('bool', $result, $msg);

		$txt_result = $result ? 'true' : 'false';
		$msg = "Password::check \"$password\" has wrong result: $txt_result";
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * DataProvider for PasswordTest::testCheck
	 */
	public function checkProvider()
	{
		$user = new User;
		$user->hash = crypt('password', '$2y$07$' . Helper::genStr());

		return array(
			array($user, 'password', true),
			array($user, 'wrongPassword', false)
		);
	}
}

<?php
namespace Veles\Tests\Auth\Strategies;

use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\Db;
use Veles\Model\User;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-25 at 23:09:50.
 */
class LoginFormStrategyTest extends \PHPUnit_Framework_TestCase
{
	protected static $tbl_name;

	public static function setUpBeforeClass()
	{
		// Create test table
		$tbl_name = static::$tbl_name = User::TBL_NAME;

		Db::setAdapter(PdoAdapter::instance());
		Db::query("
			CREATE TABLE $tbl_name (
			  id int(10) unsigned NOT NULL DEFAULT '0',
			  `group` tinyint(3) unsigned NOT NULL DEFAULT '16',
			  email char(30) NOT NULL,
			  hash char(60) NOT NULL,
			  short_name char(30) NOT NULL,
			  name char(30) NOT NULL DEFAULT 'n\\a',
			  patronymic char(30) NOT NULL DEFAULT 'n\\a',
			  surname char(30) NOT NULL DEFAULT 'n\\a',
			  birth_date date NOT NULL,
			  last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (id),
			  KEY email (email)
			) ENGINE=INNODB DEFAULT CHARSET=utf8
		");
		// superpass GlOaUExBSD9HxuEYk2ZFaeDhggU716O
		Db::query("
			INSERT INTO $tbl_name
				(id, email, hash, short_name, birth_date)
			VALUES
				(?, ?, ?, ?, ?)
		", [
			1, 'mail@mail.org',
			'$2a$07$usesomesillystringforeGlOaUExBSD9HxuEYk2ZFaeDhggU716O',
			'uzzy', '1980-12-12'
		], 'issss');
	}

	public static function tearDownAfterClass()
	{
		$table =& static::$tbl_name;
		Db::query("DROP TABLE $table");
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Auth\Strategies\LoginFormStrategy::identify
	 * @covers Veles\Auth\Strategies\LoginFormStrategy::checkInput
	 * @dataProvider identifyProvider
	 */
	public function testIdentify($mail, $pass, $expected)
	{
		$_SERVER['REQUEST_TIME'] = time();
		$_SERVER['HTTP_HOST'] = 'somehost.com';
		$_REQUEST['ln'] = $mail;
		$_REQUEST['pw'] = $pass;
		$_COOKIE['id'] = true;
		$_COOKIE['pw'] = true;

		$object = new LoginFormStrategyCopy;
		$result = $object->identify();

		$msg = 'LoginFormStrategy::identify() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function identifyProvider()
	{
		return [
			['mail@mail.org', 'superpass', true],
			['zzz', 'asf1900', false],
			['mail500@mail.org', 'asf1900', false],
			['mail@mail.org', 'superpasslakj()', false],
			['mail@mail.org', 'usell', false]
		];
	}

	/**
	 * @covers Veles\Auth\Strategies\LoginFormStrategy::__construct
	 * @dataProvider constructProvider
	 */
	public function testConstruct($mail, $pass)
	{
		$_REQUEST['ln'] = $mail;
		$_REQUEST['pw'] = $pass;

		$object = new LoginFormStrategyCopy;

		$msg = 'Wrong behavior of LoginFormStrategy::__construct()!';
		$this->assertAttributeSame($mail, 'email', $object, $msg);

		$msg = 'Wrong behavior of LoginFormStrategy::__construct()!';
		$this->assertAttributeSame($pass, 'password', $object, $msg);
	}

	public function constructProvider()
	{
		return [
			['mail200@mail.org', 'superpass3'],
			['mail300@mail.org', 'superpass2'],
			['mail500@mail.org', 'superpass1']
		];
	}
}

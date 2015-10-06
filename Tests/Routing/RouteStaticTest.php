<?php
namespace Veles\Tests\Routing;

use Veles\Routing\RouteStatic;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-23 at 06:58:58.
 * @group route
 */
class RouteStaticTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var RouteStatic
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new RouteStatic;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\Routing\RouteStatic::check
	 * @dataProvider testCheckProvider
	 */
	public function testCheck($pattern, $url, $expected)
	{
		$result = $this->object->check($pattern, $url);

		$msg = 'RouteStatic::check() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function testCheckProvider()
	{
		return [
			['/route/static/', '/route/static/', true],
			['/route/static/', '/route/', false],
			['/index.php', '/index.php', true],
			['/route/static/', '/route/static/index.php', true],
			['/route/static', '/route/static/index.php', true]
		];
	}
}

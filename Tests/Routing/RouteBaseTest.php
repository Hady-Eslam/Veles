<?php
namespace Veles\Tests\Routing;

use Veles\Routing\IniConfigLoader;
use Veles\Routing\RouteBase;
use Veles\Routing\RoutesConfig;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-24 at 17:15:24.
 * @group route
 */
class RouteBaseTest extends \PHPUnit_Framework_TestCase
{
	/** @var  RouteBase */
	protected $object;

	protected function setUp()
	{
		$this->object = new RouteBase;
		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object->setConfigHandler($config);
	}

	/**
	 * @covers Veles\Routing\RouteBase::setConfigHandler
	 */
	public function testSetConfigHandler()
	{
		$routes_loader = new IniConfigLoader(TEST_DIR . '/Project/routes.ini');
		$expected = new RoutesConfig($routes_loader);
		$this->object->setConfigHandler($expected);

		$msg = 'Wrong value of RouteBase::$config_handler!';
		$this->assertAttributeSame($expected, 'config_handler', $this->object, $msg);
	}

	/**
	 * @covers Veles\Routing\RouteBase::getConfigHandler
	 */
	public function testGetConfigHandler()
	{
		$routes_loader = new IniConfigLoader(TEST_DIR . '/Project/routes.ini');
		$expected = new RoutesConfig($routes_loader);
		$this->object->setConfigHandler($expected);

		$result = $this->object->getConfigHandler();
		$msg = 'RouteBase::getConfigHandler() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Routing\RouteBase::setNotFoundException
	 */
	public function testSetNotFoundException()
	{
		$expected = '\Veles\Exceptions\HttpResponseException';
		$this->object->setEx404($expected);

		$msg = 'RouteBase::setNotFoundException() wrong behavior!';
		$this->assertAttributeSame($expected, 'ex404', $this->object, $msg);
	}
}

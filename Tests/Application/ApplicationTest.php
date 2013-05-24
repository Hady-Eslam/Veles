<?php
/**
 * Юнит-тест для класса Application
 * @file    Application.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Янв 22 22:53:39 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests\Application;

use PHPUnit_Framework_TestCase;
use Veles\Application\Application;
use Veles\Routing\Route;
use Veles\View\View;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-22 at 22:53:39.
 */
class ApplicationTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var View
	 */
	protected $view;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->view = new View;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		$this->view->del(array('a', 'b', 'c'));
	}

	/**
	 * Unit-test for Application::run
	 * @covers Veles\Application::run
	 * @dataProvider runProvider
	 */
	public function testRun($url, $expected)
	{
		$_SERVER['REQUEST_URI'] = $url;
		$this->expectOutputString($expected['output']);

		Application::run();

		$route  = Route::instance();
		$result = $route->getMap();

		$msg = "Wrong Route::map in $url";
		$this->assertSame($expected['map'], $result, $msg);
	}

	/**
	 * DataProvider for Application::run
	 */
	public function runProvider()
	{
		$uri      = '/page-2.html';
		$expected = array(
			'map'    => array('page' => '2'),
			'output' => <<<EOF
<!DOCTYPE html>
<html>
<head>
	<title>Veles is a fast PHP framework</title>
</head>
<body>
	<div id="main_wrapper">
		Test complete!
	</div>
	<div id="footer_wrapper">
		Hello World!
	</div>
</body>
</html>

EOF
		);

		return array(array($uri, $expected));
	}
}

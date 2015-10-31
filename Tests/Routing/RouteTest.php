<?php
namespace Veles\Tests\Routing;

use Controllers\Frontend\Home;
use Exception;
use Veles\Routing\IniConfigLoader;
use Veles\Routing\Route;
use Veles\Routing\RoutesConfig;
use Veles\View\Adapters\NativeAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-22 at 09:52:48.
 * @group route
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{
	/** @var  Route */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Route;
		$config = new RoutesConfig(
			new IniConfigLoader(TEST_DIR . '/Project/routes.ini')
		);
		$this->object->setConfigHandler($config);
	}

	/**
	 * @covers Veles\Routing\Route::init
	 * @expectedException \Veles\Routing\Exceptions\NotFoundException
	 */
	public function testNotFoundException()
	{
		$_SERVER['REQUEST_URI'] = '/not-found';

		$this->object->init();
	}

	/**
	 * @covers Veles\Routing\Route::isAjax
	 * @covers Veles\Routing\Route::checkAjax
	 */
	public function testIsAjax()
	{
		$_SERVER['REQUEST_URI'] = '/';
		$expected = false;
		$result = $this->object->init()->isAjax();

		$msg = 'Wrong Route::isAjax() result!';
		$this->assertSame($expected, $result, $msg);

		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
		$_SERVER['REQUEST_URI'] = '/contacts';
		$expected = true;
		$result = $this->object->init()->isAjax();

		$msg = 'Wrong Route::isAjax() result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Routing\Route::checkAjax
	 * @expectedException Exception
	 * @expectedExceptionMessage AJAX-route got non-AJAX request!
	 */
	public function testCheckAjaxException()
	{
		$_SERVER['REQUEST_URI'] = '/contacts';
		$this->object->init()->getController();
	}

	/**
	 * @covers Veles\Routing\Route::getController
	 */
	public function testGetController()
	{
		$_SERVER['REQUEST_URI'] = '/';
		$expected = new Home;
		$result = $this->object->init()->getController();

		$msg = 'Route::getController() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Не указан контроллер!
	 */
	public function testGetControllerException()
	{
		$_SERVER['REQUEST_URI'] = '/user';
		$this->object->init()->getController();
	}

	/**
	 * @covers Veles\Routing\Route::getActionName
	 */
	public function testGetActionName()
	{
		$_SERVER['REQUEST_URI'] = '/';
		$expected = 'index';
		$result = $this->object->init()->getActionName();

		$msg = 'Route::getActionName() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Не указан экшен!
	 */
	public function testGetActionNameException()
	{
		$_SERVER['REQUEST_URI'] = '/user';
		$this->object->init()->getActionName();
	}

	/**
	 * @covers Veles\Routing\Route::getAdapter
	 */
	public function testGetAdapter()
	{
		$_SERVER['REQUEST_URI'] = '/';
		$expected = NativeAdapter::instance();
		$result = $this->object->init()->getAdapter();

		$msg = 'Route::getAdapter() returns wrong result!';
		$this->assertEquals($expected, $result, $msg);
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Не указан адаптер!
	 */
	public function testGetAdapterException()
	{
		$_SERVER['REQUEST_URI'] = '/user';
		$this->object->init()->getAdapter();
	}

	/**
	 * @covers Veles\Routing\Route::getPageName
	 */
	public function testGetPageName()
	{
		$_SERVER['REQUEST_URI'] = '/';
		$expected = 'Home';
		$result = $this->object->init()->getPageName();

		$msg = 'Route::getPageName() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers       Veles\Routing\Route::getParams
	 * @covers       Veles\Routing\Route::init
	 * @dataProvider getParamsProvider
	 *
	 * @param $url
	 * @param $expected
	 */
	public function testGetParams($url, $expected)
	{
		$_SERVER['REQUEST_URI'] = $url;

		$this->object->init();
		$msg = 'Route::$params wrong value!';
		$this->assertAttributeSame($expected, 'params', $this->object, $msg);

		$result = $this->object->init()->getParams();

		$msg = 'Route::getParams() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	public function getParamsProvider()
	{
		return [
			['/page-2.html', ['page' => '2']],
			['/page-8.html', ['page' => '8']],
			['/book/5/user/4', ['book_id' => '5', 'user_id' => '4']],
			['/book/5000/user/43', ['book_id' => '5000', 'user_id' => '43']],
			['/book/15/user/14', ['book_id' => '15', 'user_id' => '14']],
			['/book/500/user/143', ['book_id' => '500', 'user_id' => '143']]
		];
	}

	/**
	 * @covers Veles\Routing\Route::getTemplate
	 * @covers Veles\Routing\Route::init
	 */
	public function testGetTemplate()
	{
		$_SERVER['REQUEST_URI'] = '/';
		$expected = 'Frontend/index.phtml';
		$result = $this->object->init()->getTemplate();

		$msg = 'Route::getTemplate() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}
}

<?php
namespace Veles\Tests\View\Adapters;

use Veles\View\Adapters\NativeAdapter;
use Veles\View\Adapters\ViewAdapterAbstract;
use Veles\View\View;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-19 at 11:42:12.
 * @group View
 */
class ViewAdapterAbstractTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var ViewAdapterAbstract
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = ViewAdapterAbstractChild::instance();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::instance
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::invokeLazyCalls
	 */
	public function testInstance()
	{
		$this->object->setCalls(null);
		$this->object->setInstance(null);
		$expected = '\Veles\Tests\View\Adapters\ViewAdapterAbstractChild';
		$result = $this->object->instance();

		$msg = 'ViewAdapterAbstract::instance() returns wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);

		$this->assertAttributeInstanceOf(
			$expected, 'instance', $this->object, $msg
		);

		$this->object->setInstance(null);
		$this->object->setCalls([[
			'method'    => 'testCall',
			'arguments' => ['string']
		]]);

		$result = $this->object->instance();

		$msg = 'ViewAdapterAbstract::instance() returns wrong result!';
		$this->assertInstanceOf($expected, $result, $msg);

		$result = $this->object->getCalls();
		$this->assertSame(null, $result);

		View::setAdapter(NativeAdapter::instance());
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::setDriver
	 */
	public function testSetDriver()
	{
		$expected = null;
		$this->object->setDriver($expected);

		$msg = 'Wrong ViewAdapterAbstract::setDriver() behavior!';
		$this->assertAttributeSame($expected, 'driver', $this->object, $msg);

		$expected = $this->object;
		$this->object->setDriver($expected);

		$msg = 'Wrong ViewAdapterAbstract::setDriver() behavior!';
		$this->assertAttributeSame($expected, 'driver', $this->object, $msg);
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::getDriver
	 * @depends testSetDriver
	 */
	public function testGetDriver()
	{
		$expected = null;
		$this->object->setDriver($expected);

		$result = $this->object->getDriver();

		$msg = 'Wrong ViewAdapterAbstract::getDriver() behavior!';
		$this->assertSame($expected, $result, $msg);

		$expected = $this->object;
		$this->object->setDriver($expected);

		$result = $this->object->getDriver();

		$msg = 'Wrong ViewAdapterAbstract::getDriver() behavior!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::__call
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::setCall
	 */
	public function test__call()
	{
		$this->object->setDriver(new ViewDriver);
		$expected = [[
			'method' => 'testExec',
			'arguments' => ['value']
		]];

		$variable = 'value';
		$this->object->testExec($variable);

		$msg = 'Wrong ViewAdapterAbstract::__call() behavior!';
		$this->assertAttributeSame($expected, 'calls', $this->object, $msg);

		$this->object->setCalls(null);
		$this->object->setDriver($this->object);
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::__call
	 * @expectedException Exception
	 */
	public function testCallException()
	{
		$this->object->lalala();
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::set
	 */
	public function testSet()
	{
		$expected = [
			'variable-1' => 'value-1',
			'variable-2' => 'value-2'
		];
		$this->object->set($expected);

		$object = new \ReflectionObject($this->object);

		$prop = $object->getProperty('variables');
		$prop->setAccessible(true);
		$result = $prop->getValue($this->object);

		$msg = 'Wrong ViewAdapterAbstract::set() behavior!';
		foreach ($expected as $var => $value) {
			$this->assertSame($value, $result[$var], $msg);
		}
	}

	/**
	 * @covers Veles\View\Adapters\ViewAdapterAbstract::del
	 */
	public function testDel()
	{
		$this->object->set(['lalala' => 'value']);
		$this->object->del(['lalala']);

		$object = new \ReflectionObject($this->object);

		$prop = $object->getProperty('variables');
		$prop->setAccessible(true);
		$result = $prop->getValue(View::getAdapter());
		$expected = ['lalala' => false];
		$msg = 'Wrong ViewAdapterAbstract::del() behavior!';

		foreach ($expected as $var => $value) {
			$this->assertSame($value, isset($result[$var]), $msg);
		}
	}
}

<?php
namespace Veles\Tests\Cache\Adapters;

use Veles\Cache\Cache;
use Veles\Cache\Adapters\CacheAdapterAbstract;
use Exception;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-03 at 16:52:22.
 */
class CacheAdapterAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::instance
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::invokeLazyCalls
	 */
	public function testInstance()
	{
		$expected = __NAMESPACE__ . '\CacheAdapterAbstractChild';
		CacheAdapterAbstractChild::setInstance(null);
		CacheAdapterAbstractChild::setCalls(null);
		$result = CacheAdapterAbstractChild::instance();

		$msg = 'Adapter returned wrong instance object!';
		$this->assertInstanceOf($expected, $result, $msg);

		CacheAdapterAbstractChild::setInstance(null);
		CacheAdapterAbstractChild::setCalls(array(array(
			'method'    => 'testCall',
			'arguments' => array('string')
		)));

		$result = CacheAdapterAbstractChild::instance();

		$msg = 'Adapter returned wrong instance object!';
		$this->assertInstanceOf($expected, $result, $msg);

		$result = CacheAdapterAbstractChild::getCalls();
		$this->assertSame(null, $result);

		Cache::setAdapter();
	}

	/**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::__call
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::setCall
	 */
	public function test__call()
	{
		$result = CacheAdapterAbstractChild::instance()->testCall('string');

		$msg = 'Adapter returned wrong result while calling getOption()!';
		$this->assertSame(null, $result, $msg);

		$result = CacheAdapterAbstractChild::getCalls();
		$expected = array(array(
			'method' => 'testCall',
			'arguments' => array('string')
		));

		$msg = 'Driver calls was not saved correctly!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Adapters\CacheAdapterAbstract::__call
	 * @expectedException Exception
	 */
	public function test__callException()
	{
		CacheAdapterAbstractChild::instance()->wrongCall('string');
	}
}

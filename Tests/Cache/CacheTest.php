<?php
namespace Veles\Tests\Cache;

use Exception;
use Memcached;
use PHPUnit_Framework_TestCase;
use Veles\Cache\Adapters\ApcAdapter;
use Veles\Cache\Adapters\iCacheAdapter;
use Veles\Cache\Adapters\MemcacheAdapter;
use Veles\Cache\Adapters\MemcachedAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-02 at 17:46:39.
 */
class CacheTest extends PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass()
	{
		Cache::setAdapter(MemcachedAdapter::instance());
	}

	public static function tearDownAfterClass()
	{
		Cache::setAdapter(ApcAdapter::instance());
	}

	/**
	 * @covers       Veles\Cache\Cache::setAdapter
	 * @dataProvider setAdapterProvider
	 *
	 * @param iCacheAdapter $adapter Adapter
	 */
	public function testSetAdapter($adapter)
	{
		$expected = $adapter;
		Cache::setAdapter($adapter);

		$msg = 'Wrong Cache::$adapter property value!';
		$this->assertAttributeEquals(
			$expected, 'adapter', 'Veles\Tests\Cache\Cache', $msg
		);
	}

	public function setAdapterProvider()
	{
		return [
			[MemcacheAdapter::instance()],
			[MemcachedAdapter::instance()],
			[ApcAdapter::instance()]
		];
	}

	/**
	 * @covers Veles\Cache\Cache::getAdapter
	 * @depends testSetAdapter
	 */
	public function testGetAdapter()
	{
		Cache::setAdapter(ApcAdapter::instance());
		$result = Cache::getAdapter();

		$this->assertTrue($result instanceof ApcAdapter);

		Cache::setAdapter(MemcachedAdapter::instance());
		$result = Cache::getAdapter();

		$this->assertTrue($result instanceof MemcachedAdapter);
	}

	/**
	 * @covers Veles\Cache\Cache::getAdapter
	 * @expectedException Exception
	 */
	public function testSetAdapterException()
	{
		Cache::unsetAdapter();
		Cache::getAdapter();
	}

	/**
	 * @covers Veles\Cache\Cache::get
	 * @depends testSetAdapter
	 * @depends testGetAdapter
	 */
	public function testGet()
	{
		$cache = new Memcached;
		$cache->addServer('localhost', 11211);
		$params = [];

		for ($i = 0; $i < 3; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			$cache->set($key, $value, 10);
			$params[] = [$key, $value];
		}

		Cache::setAdapter(MemcachedAdapter::instance());
		foreach ($params as $param) {
			$result   = Cache::get($param[0]);
			$expected = $param[1];

			$msg = 'Wrong Cache::get result!';
			$this->assertSame($expected, $result, $msg);
		}
	}

	/**
	 * @covers Veles\Cache\Cache::set
	 * @depends testSetAdapter
	 * @depends testGetAdapter
	 */
	public function testSet()
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$expected = uniqid();
		Cache::set($key, $expected, 10);

		$cache = new Memcached;
		$cache->addServer('localhost', 11211);
		$result = $cache->get($key);

		$msg = 'Wrong Cache::set result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Cache::has
	 * @depends testSet
	 */
	public function testHas()
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$value = uniqid();
		Cache::set($key, $value, 10);

		$result = Cache::has($key);

		$msg = 'Wrong Cache::has result!';
		$this->assertSame(true, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Cache::del
	 * @depends testSet
	 */
	public function testDel()
	{
		$key = uniqid('VELES::UNIT-TEST::');
		$value = uniqid();
		Cache::set($key, $value, 10);

		$result = Cache::del($key);

		$msg = 'Wrong Cache::del result!';
		$this->assertSame(true, $result, $msg);

		$result = Cache::has($key);

		$msg = 'Cache value wasn\'t deleted!';
		$this->assertSame(false, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Cache::increment
	 * @depends testSet
	 */
	public function testIncrement()
	{
		// for default offset testing
		$key    = uniqid('VELES::UNIT-TEST::');
		$value  = mt_rand(0, 1000);
		Cache::set($key, $value, 10);
		$params = [[$key, null, ++$value]];

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('VELES::UNIT-TEST::');
			$value  = mt_rand(0, 1000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = [$key, $offset, $value + $offset];
		}

		foreach ($params as $param) {
			list($key, $offset, $expected) = $param;
			$result = (null === $offset)
				? Cache::increment($key)
				: Cache::increment($key, $offset);

			$msg = 'Cache::increment returned wrong result type!';
			$this->assertInternalType('integer', $result, $msg);
			$msg = 'Cache::increment returned wrong result value!';
			$this->assertSame($expected, $result, $msg);
		}
	}

	/**
	 * @covers Veles\Cache\Cache::decrement
	 * @depends testSet
	 */
	public function testDecrement()
	{
		// for default offset testing
		$key    = uniqid('VELES::UNIT-TEST::');
		$value  = mt_rand(1, 1000);
		Cache::set($key, $value, 10);
		$params = [[$key, null, --$value]];

		for ($i = 0; $i < 5; ++$i) {
			$key    = uniqid('VELES::UNIT-TEST::');
			$value  = mt_rand(1000, 2000);
			$offset = mt_rand(0, 1000);
			Cache::set($key, $value, 10);
			$params[] = [$key, $offset, $value - $offset];
		}

		foreach ($params as $param) {
			list($key, $offset, $expected) = $param;
			$result = (null === $offset)
				? Cache::decrement($key)
				: Cache::decrement($key, $offset);

			$msg = 'Cache::decrement returned wrong result type!';
			$this->assertInternalType('integer', $result, $msg);
			$msg = 'Cache::decrement returned wrong result value!';
			$this->assertSame($expected, $result, $msg);
		}
	}

	/**
	 * @covers Veles\Cache\Cache::clear
	 * @depends testSet
	 */
	public function testClear()
	{
		$params = [];

		for ($i = 0; $i < 10; ++$i) {
			$key = uniqid('VELES::UNIT-TEST::');
			$value = uniqid();
			Cache::set($key, $value, 10);
			$params[] = $key;
		}

		$result = Cache::clear();

		$msg = 'Wrong Cache::clear() result!';
		$this->assertSame(true, $result, $msg);

		$result = false;
		foreach ($params as $key) {
			if (Cache::has($key)) $result = true;
		}

		$msg = 'Cache was not cleared!';
		$this->assertSame(false, $result, $msg);
	}

	/**
	 * @covers Veles\Cache\Cache::delByTemplate
	 * @depends testSet
	 */
	public function testDelByTemplate()
	{
		Cache::setAdapter(MemcachedAdapter::instance());
		$key = uniqid('VELES::UNIT-TEST::DEL-BY-TPL::');
		$value = uniqid();
		Cache::set($key, $value, 10);

		$result = Cache::delByTemplate('VELES::UNIT-TEST::DEL-BY-TPL::');

		$msg = 'Cache::delByTemplate return wrong result!';
		$this->assertSame(true, $result, $msg);

		$result = Cache::has($key);
		$msg = 'Key was not deleted by template!';
		$this->assertSame(false, $result, $msg);
	}
}

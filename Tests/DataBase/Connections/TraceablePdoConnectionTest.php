<?php
namespace Veles\Tests\DataBase\Connections;

use DebugBar\StandardDebugBar;
use Veles\DataBase\Adapters\PdoAdapter;
use Veles\DataBase\Connections\TraceablePdoConnection;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-12-19 at 17:18:53.
 * @group database
 */
class TraceablePdoConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TraceablePdoConnection
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new TraceablePdoConnection('debug-conn');
    }

    /**
     * @covers Veles\DataBase\Connections\TraceablePdoConnection::create
     */
    public function testCreate()
    {
		$msg = 'Wrong initial value of TraceablePdoConnectionTest::resource';
		$this->assertAttributeSame(null, 'resource', $this->object, $msg);

		// Получаем параметры соединения у текущего адаптера
		$conn = PdoAdapter::instance()->getPool()->getConnection('master');
		$bar  = new StandardDebugBar();
		$this->object->setDsn($conn->getDsn())
			->setUserName($conn->getUserName())
			->setPassword($conn->getPassword())
			->setBar($bar);

		$this->object->create();

		$this->assertAttributeInstanceOf(
			'\DebugBar\DataCollector\PDO\TraceablePDO',
			'resource', $this->object, $msg
		);

		$this->object->create();

		$msg = 'Wrong behavior of TraceablePdoConnectionTest::create';
		$this->assertTrue($bar->hasCollector('pdo'), $msg);
    }

    /**
     * @covers Veles\DataBase\Connections\TraceablePdoConnection::setBar
     */
    public function testSetBar()
    {
		$msg = 'Wrong initial value of TraceablePdoConnectionTest::bar';
        $this->assertAttributeSame(null, 'bar', $this->object, $msg);

		$expected = new StandardDebugBar;
		$this->object->setBar($expected);
		$msg = 'Wrong value of TraceablePdoConnectionTest::bar';
		$this->assertAttributeSame($expected, 'bar', $this->object, $msg);
    }
}
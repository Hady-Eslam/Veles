<?php
namespace Veles\Tests\DataBase;

use Symfony\Component\Yaml\Unescaper;
use Veles\DataBase\DbFilter;
use Veles\DataBase\DbPaginator;
use Veles\Tests\Model\News;
use Veles\DataBase\Adapters\PdoAdapter;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-27 at 18:28:23.
 */
class DbPaginatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var DbPaginator
	 */
	protected $object;
	/**
	 * Final HTML output
	 * @var string
	 */
	protected $html;
	protected static $tbl_name;

	public static function setUpBeforeClass()
	{
		// Create test table
		$tbl_name = static::$tbl_name = News::TBL_NAME;

		Db::setAdapter(PdoAdapter::instance());
		Db::query("
			CREATE TABLE IF NOT EXISTS $tbl_name (
			  id int(10) unsigned NOT NULL,
			  title char(30) NOT NULL,
			  content char(60) NOT NULL,
			  author char(30) NOT NULL,
			  PRIMARY KEY (id)
			) ENGINE=INNODB DEFAULT CHARSET=utf8
		");
		for ($i = 0; $i < 20; ++$i) {
			Db::query("
				INSERT INTO $tbl_name
					(id, title, content, author)
				VALUES
					(?, ?, ?, ?)
			", [$i, uniqid(), uniqid(), uniqid()], 'isss');
		}
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
		$this->object = new DbPaginator;
		$this->html = <<<EOL
			<span class="curr">1</span>
					<a href="/page-2.html" class="pager-margin">2</a>
			<a href="/page-3.html" class="pager-margin">3</a>
			<a href="/page-4.html" class="pager-margin">4</a>
		<a href="/page-5.html" class="pager-margin">&raquo;</a>

EOL;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::__toString
	 */
	public function test__toString()
	{
		$this->expectOutputString($this->html);

		$news = new News;
		$this->object->setLimit(4);
		$filter = new DbFilter;
		$news->getAll($filter, $this->object);

		echo $this->object;
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::getOffset
	 */
	public function testGetOffset()
	{
		$expected = 0;
		$result = $this->object->getOffset();
		$msg = 'DbPaginator::getOffset() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::getLimit
	 */
	public function testGetLimit()
	{
		$expected = 40;
		$this->object->setLimit($expected);
		$result = $this->object->getLimit();
		$msg = 'DbPaginator::getLimit() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::setLimit
	 * @dataProvider setLimitProvider
	 */
	public function testSetLimit($limit, $expected)
	{
		$this->object->setLimit($limit);
		$msg = 'Wrong DbPaginator::setLimit() behavior!';
		$this->assertAttributeSame($expected, 'limit', $this->object, $msg);
	}

	public function setLimitProvider()
	{
		return [
			['lalala', 5],
			[10, 10],
			['200', 200]
		];
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::getSqlLimit
	 */
	public function testGetSqlLimit()
	{
		$expected = ' LIMIT 0, 5';
		$result = $this->object->getSqlLimit();
		$msg = 'DbPaginator::getSqlLimit() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::getMaxPages
	 * @covers Veles\Model\QueryBuilder::setPage
	 */
	public function testGetMaxPages()
	{
		$expected = 4;
		$news = new News;
		$news->getAll();

		$result = $this->object->getMaxPages();
		$msg = 'DbPaginator::getMaxPages() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$expected = 5;
		$news = new News;
		$this->object->setLimit(4);
		$filter = new DbFilter;
		$news->getAll($filter, $this->object);

		$result = $this->object->getMaxPages();
		$msg = 'DbPaginator::getMaxPages() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::calcMaxPages
	 */
	public function testCalcMaxPages()
	{
		$expected = 5;
		$news = new News;
		$this->object->setLimit(4);
		$filter = new DbFilter;
		$news->getAll($filter, $this->object);

		$msg = 'Wrong DbPaginator::calcMaxPages() behavior!';
		$this->assertAttributeSame($expected, 'page_nums',$this->object, $msg);
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::getCurrPage

	 */
	public function testGetCurrPage()
	{
		$expected = 1;
		$result = $this->object->getCurrPage();
		$msg = 'DbPaginator::getCurrPage() returns wrong result!';
		$this->assertSame($expected, $result, $msg);

		$expected = 5;
		$object = new DbPaginator('', 5);
		$result = $object->getCurrPage();
		$msg = 'DbPaginator::getCurrPage() returns wrong result!';
		$this->assertSame($expected, $result, $msg);
	}

	/**
	 * @covers Veles\DataBase\DbPaginator::__construct
	 */
	public function testConstruct()
	{
		$expected = 'paginator_default.phtml';
		$object = new DbPaginator();
		$msg = 'Wrong DbPaginator::__construct() behavior!';
		$this->assertAttributeSame($expected, 'template', $object, $msg);

		$expected = 'new-template.phtml';
		$object = new DbPaginator($expected, 5);
		$msg = 'Wrong DbPaginator::__construct() behavior!';
		$this->assertAttributeSame($expected, 'template', $object, $msg);
	}
}

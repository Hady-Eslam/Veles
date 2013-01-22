<?php
/**
 * Unit-test for View class
 * @file    ViewTest.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Вск Янв 20 18:40:31 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tests;

use \Veles\View;
use \PHPUnit_Framework_TestCase;
use \ReflectionObject;

define(
    'TEMPLATE_PATH',
    rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
);

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 18:39:47.
 */
class ViewTest extends PHPUnit_Framework_TestCase
{
    /**
     * Container for View object
     * @var View
     */
    protected static $object;

    /**
     * File name of template
     * @var string
     */
    protected $tpl;

    /**
     * Final HTML output
     * @var string
     */
    protected $html;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        static::$object = new View;
        $this->tpl = 'view.phtml';
        $file_name = TEMPLATE_PATH . $this->tpl;

        $fp = fopen($file_name, 'w+');

        $phtml = <<<'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>PHP Unit test template</title>
</head>
<body>
    <div id="main_wrapper">
        <?=$a?> Hello
    </div>
    <div id="main_wrapper">
        <?=$b?> <?=$c?> World!!
    </div>
</body>
</html>
EOF;
        fputs($fp, $phtml);
        fclose($fp);

        $this->html = <<<EOF
<!DOCTYPE html>
<html>
<head>
    <title>PHP Unit test template</title>
</head>
<body>
    <div id="main_wrapper">
        value Hello
    </div>
    <div id="main_wrapper">
        1 c_value World!!
    </div>
</body>
</html>
EOF;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $file_name = TEMPLATE_PATH . $this->tpl;
        unlink($file_name);
    }

    /**
     * Unit-test for View::set
     *
     * @covers Veles\View::set
     * @dataProvider setExceptionProvider
     * @expectedException Exception
     * @expectedExceptionMessage View can set variables only in arrays!
     * @see View::set
     */
    public function testSetException($vars)
    {
        static::$object->set($vars);
    }

    /**
     * DataProvider for VewTest::testSetException
     */
    public function setExceptionProvider()
    {
        return array(array(1, array(1)));
    }

    /**
     * Unit-test for View::set
     * @covers Veles\View::set
     * @dataProvider setProvider
     * @see View::set
     */
    public function testSet($vars, $expected)
    {
        static::$object->set($vars);

        $object = new ReflectionObject(static::$object);
        $prop = $object->getProperty('variables');

        $msg = 'Property View::$variables not private';
        $this->assertTrue($prop->isPrivate(), $msg);

        $prop->setAccessible(true);
        $result = $prop->getValue();

        $msg = 'Wrong result of View::$variables property';
        $this->assertTrue($result === $expected, $msg);
    }

    /**
     * DataProvider for HelperTest::testTranslit
     */
    public function setProvider()
    {
        return array(
            array(
                array('a' => 'value', 'b' => 1),
                array('a' => 'value', 'b' => 1)
            ),
            array(
                array('c' => 'c_value'),
                array('a' => 'value', 'b' => 1, 'c' => 'c_value')
            )
        );
    }

    /**
     * Unit-test for View::show
     * @covers Veles\View::show
     * @depends testSet
     * @see View::show
     */
    public function testShow()
    {
        $this->expectOutputString($this->html);

        static::$object->show($this->tpl);
    }

    /**
     * Unit-test for View::get
     * @covers Veles\View::get
     * @depends testSet
     * @see View::get
     */
    public function testGet()
    {
        $expected =& $this->html;

        $result = static::$object->get($this->tpl);

        $msg = 'Wrong result type: ' . gettype($result);
        $this->assertInternalType('string', $result, $msg);

        $msg = 'Wrong content of HTML in View::get()';
        $this->assertSame($expected, $result, $msg);
    }
}

<?php
namespace Veles\ErrorHandler\HtmlBuilders;

use Veles\ErrorHandler\ExceptionHandler;
use Veles\ErrorHandler\Subscribers\ErrorRenderer;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-11-06 at 08:29:36.
 * @group error-handler
 */
class ErrorBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var ErrorBuilder
	 */
	protected $object;
	protected $message = 'Test exception!';
	protected $html;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new ErrorBuilder;
		$this->html = <<<EOL
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	$this->message</body>
</html>

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
	 * @covers Veles\ErrorHandler\HtmlBuilders\ErrorBuilder::getHtml
	 * @covers Veles\ErrorHandler\HtmlBuilders\AbstractBuilder::convertTypeToString
	 * @covers Veles\ErrorHandler\HtmlBuilders\AbstractBuilder::formatBacktrace
	 */
	public function testGetHtml()
	{
		$exception = new \Exception($this->message);
		$handler = new ExceptionHandler;

		$this->object->setTemplate('Errors/exception.phtml');
		$this->object->setHandler($handler);
		$renderer = new ErrorRenderer;
		$renderer->setMessageBuilder($this->object);

		$this->expectOutputString($this->html);

		$handler->attach($renderer);
		$handler->run($exception);
	}
}

<?php
/**
 * Base class for controllers
 *
 * @file      BaseController.php
 *
 * PHP version 5.4+
 *
 * @author    Yancharuk Alexander <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      2016-10-21 16:43
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>
 */

namespace Controllers;

use Application\ApplicationTrait;

/**
 * Class   BaseController
 *
 * @author Yancharuk Alexander <alex at itvault dot info>
 */
class BaseController
{
	use ApplicationTrait;

	/**
	 * Getting route params
	 *
	 * @param string $name
	 *
	 * return string
	 */
	protected function getParam($name)
	{
		$params = $this->getApplication()->getRoute()->getParams();

		return $params[$name];
	}
}

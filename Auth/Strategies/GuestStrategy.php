<?php
/**
 * Guest authentication strategy
 *
 * @file      GuestStrategy,php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk
 * @date      Вск Янв 27 21:43:51 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;

/**
 * Class GuestStrategy
 *
 * @author  Alexander Yancharuk <alex at itvault dot info>
 */
class GuestStrategy extends AbstractAuthStrategy
{
	/**
	 * Guest authentication
	 *
	 * @return bool
	 */
	public function identify()
	{
		$props = ['group' => UsrGroup::GUEST];
		$this->user->setProperties($props);

		return false;
	}
}

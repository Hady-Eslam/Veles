<?php
/**
 * Usr authentication strategy base class
 *
 * @file      AbstractAuthStrategy.php
 *
 * PHP version 5.6+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @copyright © 2012-2016 Alexander Yancharuk <alex at itvault at info>
 * @date      Вск Янв 27 17:29:50 2013
 * @license   The BSD 3-Clause License
 *            <https://tldrlegal.com/license/bsd-3-clause-license-(revised)>.
 */

namespace Veles\Auth\Strategies;

use Veles\Auth\UsrGroup;
use Veles\DataBase\DbFilter;
use Veles\Model\User;

/**
 * Class AbstractAuthStrategy
 *
 * @author   Alexander Yancharuk <alex at itvault dot info>
 */
abstract class AbstractAuthStrategy
{
	const ERR_USER_NOT_FOUND   = 1;
	const ERR_WRONG_PASSWORD   = 2;

	// This var contains bit-wise error info
	protected $errors = 0;
	protected $user;

	/**
	 * Constructor
	 *
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * User authentication
	 *
	 * @return bool
	 */
	abstract public function identify();

	/**
	 * Auth cookies setup
	 *
	 * @param array $params		Cookie params
	 */
	protected function setCookie(array $params = [])
	{
		$expire = $path = $domain = $secure = $http_only = null;
		extract($params, EXTR_IF_EXISTS);
		$user = $this->getUser();

		setcookie('id', $user->id, $expire, $path, $domain, $secure, $http_only);
		setcookie('pw', $user->hash, $expire, $path, $domain, $secure, $http_only);
	}

	/**
	 * Delete auth cookies
	 *
	 * @param array $params
	 */
	protected function delCookie(array $params = [])
	{
		$expire = $path = $domain = $secure = $http_only = null;
		extract($params, EXTR_IF_EXISTS);

		setcookie('id', null, $expire, $path, $domain, $secure, $http_only);
		setcookie('pw', null, $expire, $path, $domain, $secure, $http_only);
	}

	/**
	 * User search
	 *
	 * @param DbFilter $filter
	 *
	 * @return bool
	 */
	protected function findUser(DbFilter $filter)
	{
		if ($this->getUser()->find($filter)) {
			return true;
		}

		$this->delCookie();

		$props = ['group' => UsrGroup::GUEST];
		$this->getUser()->setProperties($props);

		$this->errors |= self::ERR_USER_NOT_FOUND;

		return false;
	}

	/**
	 * Get user
	 *
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Get errors
	 *
	 * @return int
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}

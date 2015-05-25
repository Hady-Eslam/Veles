<?php
/**
 * Модель пользователя
 * @file      User.php
 *
 * PHP version 5.4+
 *
 * @author    Alexander Yancharuk <alex at itvault dot info>
 * @date      Пнд Мар 05 21:39:43 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\Model;

use Veles\Auth\UsrGroup;

/**
 * Модель пользователя
 */
class User extends ActiveRecord
{
	const TBL_NAME      = 'users';
	const TBL_USER_INFO = 'users_info';

	protected $map = [
		'id'         => 'int',
		'email'      => 'string',
		'hash'       => 'string',
		'group'      => 'int',
		'last_login' => 'string'
	];

	/**
	 * Метод для получения ID пользователя
	 * @return int|null
	 */
	public function getId()
	{
		return isset($this->id) ? (int) $this->id : null;
	}

	/**
	 * Метод для получения хэша пользователя, взятого из базы
	 * @return string|null
	 */
	public function getHash()
	{
		return isset($this->hash) ? $this->hash : null;
	}

	/**
	 * Метод для получения хэша для кук
	 * @return string|null
	 */
	public function getCookieHash()
	{
		return isset($this->hash) ? substr($this->hash, 29) : null;
	}

	/**
	 * Метод для получения соли хэша
	 * @return string|null
	 */
	public function getSalt()
	{
		return isset($this->hash) ? substr($this->hash, 0, 28) : null;
	}

	/**
	 * Метод для получения группы пользователя
	 * @return int
	 */
	public function getGroup()
	{
		return isset($this->group) ? (int) $this->group : UsrGroup::GUEST;
	}
}

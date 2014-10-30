<?php
/**
 * Фильтр для выборки моделей
 * @file    DbFilter.php
 *
 * PHP version 5.3.9+
 *
 * @author  Alexander Yancharuk <alex@itvault.info>
 * @date    Втр Авг 07 23:14:17 2012
 * @copyright The BSD 3-Clause License
 */

namespace Veles\DataBase;

/**
 * Класс DbFilter
 * @author  Alexander Yancharuk <alex@itvault.info>
 */
class DbFilter
{
	protected $where  = '';
	protected $group  = '';
	protected $having = '';
	protected $order  = '';

	/**
	 * Метод для получения where
	 * @return string
	 */
	public function getWhere()
	{
		return $this->where;
	}

	/**
	 * Метод для получения group by
	 * @return string
	 */
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * Метод для получения having
	 * @return string
	 */
	public function getHaving()
	{
		return $this->having;
	}

	/**
	 * Метод для получения order by
	 * @return string
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Метод для установки значения where
	 * @param string $where WHERE для sql-запроса
	 */
	public function setWhere($where)
	{
		$this->where = "WHERE $where";
	}

	/**
	 * Метод для установки значения group by
	 * @param string $group GROUP BY для sql-запроса
	 */
	public function setGroup($group)
	{
		$this->group = "GROUP BY $group";
	}

	/**
	 * Метод для установки значения having
	 * @param string $having HAVING для sql-запроса
	 */
	public function setHaving($having)
	{
		$this->having = "HAVING $having";
	}

	/**
	 * Метод для установки значения order by
	 * @param string $order ORDER BY для sql-запроса
	 */
	public function setOrder($order)
	{
		$this->order = "ORDER BY $order";
	}
}

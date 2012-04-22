<?php
/**
 * @file    Db.php
 * @brief   Класс соединения с базой. Для использования необходимо в php наличие
 * mysqli расширения.
 *
 * PHP version 5.3+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Мар 09 03:25:07 2012
 * @version
 */

// Не допускаем обращения к файлу напрямую
if (basename(__FILE__) === basename($_SERVER['PHP_SELF'])) exit();

/**
 * @class   Db
 * @brief   Класс соединения с базой
 */
class Db {
    const MYSQL_SERVER   = 'localhost';
    const MYSQL_USER     = 'root';
    const MYSQL_PASSWORD = '';
    const MYSQL_BASE     = 'ts';

    private static $db;
    private static $errors = array();

    /**
     * @fn    connect
     * @brief Метод создаёт экземпляр mysqli класса и сохраняет его в self::$db.
     * Нечто наподобие классического синглтона.
     */
    private static function connect()
    {
        try {
            self::$db = mysqli_connect(
                self::MYSQL_SERVER,
                self::MYSQL_USER,
                self::MYSQL_PASSWORD,
                self::MYSQL_BASE
            );

            if (!self::$db instanceof mysqli) {
                throw new DbException('Не удалось подключиться к mysql');
            }
        }
        catch (DbException $e) {
            self::$errors[] = $e;
        }
    }

    /**
     * @fn      q
     * @brief   Метод для выполнения запросов
     *
     * @param   string Sql-запрос
     * @return  bool Если запрос выполенен без ошибок, возвращает TRUE
     */
    final public static function q($sql)
    {
        if (!self::$db instanceof mysqli)
            self::connect();

        try {
            $result = mysqli_query(self::$db, $sql, MYSQLI_USE_RESULT);
            if ($result === FALSE) {
                throw new DbException(
                    'Не удалось выполнить запрос', self::$db, $sql
                );
            }
        }
        catch (DbException $e) {
            self::$errors[] = $e;
        }

        if ($result instanceof MySQLi_Result) {
            if ($result->num_rows > 1)
                while ($return[] = mysqli_fetch_assoc($result));
            else
                $return = mysqli_fetch_assoc($result);

            $result->free();
        }
        else
            return $result;

        return $return;
    }

    /**
     * @fn    getLastInsertId
     * @brief Функция получения LAST_INSERT_ID()
     */
    final public static function getLastInsertId()
    {
        try {
            $result = mysqli_insert_id(self::$db);
            if ($result === FALSE) {
                throw new DbException(
                    'Не удалось выполнить запрос', self::$db, $sql
                );
            }
        }
        catch (DbException $e) {
            self::$errors[] = $e;
        }

        return $result;
    }

    /**
     * @fn      getErrors
     * @brief   Метод возвращает массив с ошибками
     *
     * @return  array $errors
     */
    final public static function getErrors()
    {
        return self::$errors;
    }
}
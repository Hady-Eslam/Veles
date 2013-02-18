<?php
/**
 * Цвета для консольного вывода
 * @file    CliColor.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Фев 15 21:54:29 2013
 * @copyright The BSD 3-Clause License.
 */

namespace Veles\Tools;

use \Exception;


/**
 * Класс CliColor
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
/** @noinspection PhpDocMissingReturnTagInspection */
class CliColor
{
    private $color;

    private $style;

    private $string;

    private static $colors = array(
        'black'  => '0',
        'red'    => '1',
        'green'  => '2',
        'yellow' => '3',
        'blue'   => '4',
        'purple' => '5',
        'cyan'   => '6',
        'white'  => '7'
    );

    private static $styles = array(
        '0' => 'default',
        '1' => 'bold',
        '2' => 'dark',
        '4' => 'underline',
        '7' => 'invert',
        '9' => 'strike'
    );

    /**
     * При вызове оборачивает строку esc-последовательностями цвета
     * @param string $string Строка
     * @return string
     */
    final public function __invoke($string = null)
    {
        if (null === $string) {
            if (null === $this->string) {
                return '';
            }

            $string =& $this->string;
        }

        return "\033[{$this->getStyle()};3{$this->getColor()}m$string\033[0m";
    }

    /**
     * Конструктор
     * @param string $color Цвет
     * @throws Exception
     * @param array $style Массив со стилями
     */
    final public function __construct(
        $color = 'green', $style = array('default')
    ) {
        if (!is_array($style)) {
            throw new Exception('Style parameter must be an array!');
        }

        if (!isset(self::$colors[$color])) {
            throw new Exception('Not valid color!');
        }

        $this->color = $color;
        $this->style = $style;
    }

    /**
     * Вывод объекта в виде строки
     * @return mixed
     */
    final public function __toString()
    {
        if (null === $this->string) {
            return null;
        }

        $style = $this->getStyle();
        $color = $this->getColor();

        return "\033[$style;3{$color}m$this->string\033[0m";
    }

    /**
     * Добавление строки
     * @param string $string Строка для последующего вывода в цвете
     * @throws Exception
     * @return CliColor
     */
    final public function setString($string = null)
    {
        if (null === $string) {
            throw new Exception('Not valid string!');
        }

        $this->string = (string) $string;

        return $this;
    }

    /**
     * Установка стиля
     * @param array $style Стиль
     * @throws Exception
     * @return CliColor
     */
    final public function setStyle($style = array())
    {
        if (!is_array($style)) {
            throw new Exception('Not valid style!');
        }

        $styles = array_flip(self::$styles);

        foreach ($style as $value) {
            if (!isset($styles[$value])) {
                throw new Exception("Not valid style: '$value'!");
            }
        }

        $this->style = $style;

        return $this;
    }

    /**
     * Установка цвета
     * @param string $color Цвет
     * @throws Exception
     * @return CliColor
     */
    final public function setColor($color = null)
    {
        if (null === $color || !is_string($color)) {
            throw new Exception('Not valid color!');
        }

        if (!isset(self::$colors[$color])) {
            throw new Exception("Not valid color: '$color'!");
        }

        $this->color = $color;

        return $this;
    }

    /**
     * Получение стиля
     * @return string
     */
    private function getStyle()
    {
        $styles = array_keys(array_intersect(self::$styles, $this->style));

        return implode(';', $styles);
    }

    /**
     * Получение цвета
     * @return string
     */
    private function getColor()
    {
        return self::$colors[$this->color];
    }
}
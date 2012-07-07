<?php
/**
 * Класс реализующий MVC-архитектуру проекта
 * @file    Application.php
 *
 * PHP version 5.3.9+
 *
 * @author  Yancharuk Alexander <alex@itvault.info>
 * @date    Птн Июн 08 18:10:37 2012
 * @version
 */

namespace Veles;

use \Veles\Routing\Route;

/**
 * Класс Application
 * @author  Yancharuk Alexander <alex@itvault.info>
 */
class Application
{
    /**
     * Старт приложения
     */
    final public static function run()
    {
        self::setPhpSettings();

        CurrentUser::instance();

        // Получаем имя контроллера и метода
        $route      = Route::instance();
        $controller = $route->getController();
        $action     = $route->getAction();
        $page_name  = $route->getPageName();

        if (!$route->isAjax()) {
            Navigation::instance($route->getPageName());
        }

        // Запускаем контроллер
        $variables = $controller->$action();

        // Инициализируем переменные во view
        View::set($page_name, $variables);

        // Запускаем view
        View::show();
    }

    /**
     * Устанавливаем настройки php, прописанные в конфиге
     */
    private static function setPhpSettings()
    {
        if (NULL === ($settings = Config::getParams('php')))
            return;

        foreach ($settings as $param => $value) {
            ini_set($param, $value);
        }
    }
}
<?php
namespace MVC;

class Controller
{
    /**
     * @param $controllerName
     * @return \MVC\Controllers\AbstractController
     */
    public static function factory($controllerName)
    {
        $controllerName = '\\MVC\\Controllers\\' . $controllerName . 'Controller';

        if (!class_exists($controllerName)) {
            // todo throw
        }

        return new $controllerName();
    }
}
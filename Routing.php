<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/ErrorController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/AddClientController.php';
require_once 'src/controllers/ChangePasswordController.php';
require_once 'src/controllers/BoxController.php';
require_once 'src/controllers/FruitController.php';


class Routing{
    public static $routes;


    public static function get($url, $controller){
        self::$routes[$url] = $controller;
    }
    public static function post($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function run ($url) {
        $action = explode("/", $url)[0];
        
        if (!array_key_exists($action, self::$routes)) {
            $error = new ErrorController();
            return $error->FileNotFound();
        }
    
        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'panel_logowania';

        $object->$action();
    }

}
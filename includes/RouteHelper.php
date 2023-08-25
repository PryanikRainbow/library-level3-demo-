<?php

namespace Includes;

class RouteHelper
{
    public const USER_OBJS = ['Books', 'Book', 'Counter'];
    public const ADMIN_OBJS = [
          'AdminBooks', 'AdminBook', 'AdminCounter',
          'Image', 'Login', 'Logout'
        ];
    public const ERROR_OBJS = ['Error'];

    public const MAIN_PAGE = "Books";
    private static $actions = [];

    private static string $object;
    private static $params = [];

    public static function simpleRoute($pathURI, $requestURI)
    {
        if ($pathURI === $requestURI) {
            self::determineObject($pathURI);
            // echo self::getAction() . PHP_EOL;
            // print_r(self::getParams());
            return true;
        }
        //спрацювало з другою підумовою, без другої не працювало
        if (strpos($requestURI, $pathURI) === 0 && $pathURI !== "/") {
            // echo $pathURI;
            self::determineObject($pathURI);
            self::$params[] = substr($requestURI, strlen($pathURI));
            // echo self::getAction() . PHP_EOL;
            // print_r(self::getParams());
            return true;
        }
        return false;
    }

    public static function queryRoute($requestURI)
    {
        $parsedUrl = parse_url($requestURI);

        if (isset($parsedUrl['query'])) {
            $actionPath = $parsedUrl['path'];
            self::determineObject($actionPath);
             parse_str($parsedUrl['query'], self::$params);
            // echo "query";
            // echo PHP_EOL;
            // var_dump(self::getParams());

            return true;
        }

        return false;
    }

    public static function isNumParam()
    {
        return is_numeric(self::$params[0]);
    }

    private static function determineObject($pathURI)
    {
        if ($pathURI === "/") {
            self::setObject(self::MAIN_PAGE);
            return true;
        } elseif (!empty($pathURI)) {
            $pathURI = trim($pathURI, '/');
            $pathComponents = explode('/', $pathURI);

            $result = "";
            foreach ($pathComponents as $component) {
                $result .= ucfirst($component);
            }
            self::setObject($result);
            return true;
        }
        return false;
    }

    public static function getObject()
    {
        return self::$object;
    }

    public static function setObject($object)
    {
        self::$object = $object;
    }

    public static function getParams()
    {
        return self::$params;
    }

    public static function isUserController(){
        return in_array(self::$object, self::USER_OBJS);

    }

    public static function isAdminController(){
        return in_array(self::$object, self::ADMIN_OBJS);

    }

    public static function isErrorController(){
        return in_array(self::$object, self::ERROR_OBJS);

    }
}

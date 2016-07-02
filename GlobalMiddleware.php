<?php


//TODO: Fix a check to make sure that global middleware is an array of executable objects.
class GlobalMiddleware
{

    private static $middleware = NULL;

    public static function add($middleware) {
        self::$middleware = $middleware;
    }

    public static function execute($request, $response) {
        if(self::$middleware)
        {
            foreach(self::$middleware as $middleware)
            {
                $middleware($request, $response);
            }
        }
    }
}
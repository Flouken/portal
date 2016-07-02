<?php

/*
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/RouteParser.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/Route.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/UrlScanner.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/Dispatcher.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/Request.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/Response.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/GlobalMiddleware.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/portal/Stop.php';
*/

include_once 'RouteParser.php';
include_once 'Route.php';
include_once 'UrlScanner.php';
include_once 'Dispatcher.php';
include_once 'Request.php';
include_once 'Response.php';
include_once 'GlobalMiddleware.php';
include_once 'Stop.php';

class Portal
{

    public function __construct($global_middleware = NULL)
    {
        $this->dispatcher = new Dispatcher();
        GlobalMiddleware::add($global_middleware);
    }

    public function get($url_pattern, $callback, $middleware = [])
    {
        $routeParser = new RouteParser($url_pattern);
        $this->dispatcher->add_get_route($routeParser, $callback, $middleware);
    }

    public function post($url_pattern, $callback, $middleware = [])
    {
        $routeParser = new RouteParser($url_pattern);
        $this->dispatcher->add_post_route($routeParser, $callback, $middleware);
    }

    public function patch($url_pattern, $callback, $middleware = [])
    {
        $routeParser = new RouteParser($url_pattern);
        $this->dispatcher->add_patch_route($routeParser, $callback, $middleware);
    }

    public function delete($url_pattern, $callback, $middleware = [])
    {
        $routeParser = new RouteParser($url_pattern);
        $this->dispatcher->add_delete_route($routeParser, $callback, $middleware);
    }

    public function run()
    {
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->dispatcher->execute_requested_route($request_method, UrlScanner::active_route());
        print(UrlScanner::active_route());
    }
}
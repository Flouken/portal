<?php


class Route
{
    public function __construct($routeParser, $callback, $middleware)
    {
        $this->routeParser  = $routeParser;
        $this->callback     = $callback;
        $this->middleware   = $middleware;
    }

    public function execute_middleware_pipe($request, $response)
    {
        foreach($this->middleware as $middleware)
        {
            $middleware($request, $response);
        }
    }
}
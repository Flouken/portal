<?php


class Dispatcher
{
    public function __construct()
    {
        $this->get_routes     = [];
        $this->post_routes    = [];
        $this->patch_routes   = [];
        $this->delete_routes  = [];
    }

    public function add_get_route($routeParser, $callback, $middleware)
    {
        $route = new Route($routeParser, $callback, $middleware);
        if(array_key_exists($routeParser->route_id, $this->get_routes))
            throw new Exception('Duplicate routes are not possible!');
        $this->get_routes[$routeParser->route_id] = $route;
    }
    public function add_post_route($routeParser, $callback, $middleware)
    {
        $route = new Route($routeParser, $callback, $middleware);
        if(array_key_exists($routeParser->route_id, $this->post_routes))
            throw new Exception('Duplicate routes are not possible!');
        $this->post_routes[$routeParser->route_id] = $route;
    }
    public function add_patch_route($routeParser, $callback, $middleware)
    {
        $route = new Route($routeParser, $callback, $middleware);
        if(array_key_exists($routeParser->route_id, $this->patch_routes))
            throw new Exception('Duplicate routes are not possible!');
        $this->patch_routes[$routeParser->route_id] = $route;
    }
    public function add_delete_route($routeParser, $callback, $middleware)
    {
        $route = new Route($routeParser, $callback, $middleware);
        if(array_key_exists($routeParser->route_id, $this->delete_routes))
            throw new Exception('Duplicate routes are not possible!');
        $this->delete_routes[$routeParser->route_id] = $route;
    }
    public function execute_requested_route($request_method, $active_url)
    {
        $body = file_get_contents("php://input");
        $request = new Request($body);
        $response = new Response();

        if($request_method === 'get')
        {
            $route = $this->get_routes[$active_url];
            if($route === null)
                Stop::bad_request();
            $request->append_url_parameters($route->routeParser->parameter_values());
            GlobalMiddleware::execute($request, $response);
            $route->execute_middleware_pipe($request, $response);
            call_user_func($route->callback, $request, $response);
        }
        if($request_method === 'post')
        {
            $route = $this->post_routes[$active_url];
            if($route === null)
                Stop::bad_request();
            $request->append_url_parameters($route->routeParser->parameter_values());
            GlobalMiddleware::execute($request, $response);
            $route->execute_middleware_pipe($request, $response);
            call_user_func($route->callback, $request, $response);
        }
        if($request_method === 'patch')
        {
            $route = $this->patch_routes[$active_url];
            if($route === null)
                Stop::bad_request();
            $request->append_url_parameters($route->routeParser->parameter_values());
            GlobalMiddleware::execute($request, $response);
            $route->execute_middleware_pipe($request, $response);
            call_user_func($route->callback, $request, $response);
        }
        if($request_method === 'delete')
        {
            $route = $this->delete_routes[$active_url];
            if($route === null)
                Stop::bad_request();
            $request->append_url_parameters($route->routeParser->parameter_values());
            GlobalMiddleware::execute($request, $response);
            $route->execute_middleware_pipe($request, $response);
            call_user_func($route->callback, $request, $response);
        }
    }
}
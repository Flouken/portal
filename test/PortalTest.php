<?php

include_once 'Portal.php';

class PortalTest extends PHPUnit_Framework_TestCase
{
    public function test_can_create_get_route() // Rest of the routes are not needed to test since they are identical logic
    {
        $app = new Portal();
        $app->get('/users/:id', function(){

        });
        $this->assertInstanceOf(Route::class, $app->dispatcher->get_routes['users']);
    }
    public function test_can_add_middleware_to_route()
    {
        $app = new Portal();
        $app->get('/cars/:id', function(){

        }, ['middleware_1', 'middleware_2', 'middleware_3']);
        print_r($app->dispatcher->get_routes['cars']->middleware);
    }
    /**
     * @expectedException Exception
     * Duplicate routes are not possible!
     */
    public function test_duplicate_routes_should_raise_exception()
    {
        $app = new Portal();
        $app->get('/users/:id', function(){

        });
        $app->get('/users/:id', function(){

        });
    }
}


<?php

include_once 'RouteParser.php';
include_once 'UrlScanner.php';

class RouteParserTest extends PHPUnit_Framework_TestCase
{
    public function test_route_pattern_segments_correct_pattern_isArray()
    {
        $url_pattern = '/users/:id';
        $routeParser = new RouteParser($url_pattern);

        $this->assertEquals('array', gettype($routeParser->route_pattern_segments));
    }
    public function test_route_pattern_segments_correct_pattern_trailing_slash_isArray()
    {
        $url_pattern = '/users/:id/';
        $routeParser = new RouteParser($url_pattern);

        $this->assertEquals('array', gettype($routeParser->route_pattern_segments));
    }
    public function test_route_pattern_segments_faulty_pattern_isArray()
    {
        $url_pattern = 'sdfsdf';
        $routeParser = new RouteParser($url_pattern);
        $this->assertEquals('array', gettype($routeParser->route_pattern_segments));
    }
    public function test_url_pattern_variations()
    {
        $url_pattern = 'accounts/';
        $routeParser = new RouteParser($url_pattern);
        $url_pattern = '/accounts';
        $routeParser = new RouteParser($url_pattern);
        $url_pattern = '/accounts/';
        $routeParser = new RouteParser($url_pattern);
    }

    /**
     * @expectedException Exception
     * $url_pattern must be a string
     */
    public function test_route_pattern_segments_invalid_input_shouldRaiseException()
    {
        $url_pattern = 123452345;
        $routeParser = new RouteParser($url_pattern);

    }
    /**
     * @expectedException Exception
     * $url_pattern must contain a noun
     */
    public function test_route_pattern_segments_empty_string_shouldRaiseException()
    {
        $url_pattern = '';
        $routeParser = new RouteParser($url_pattern);

    }
    /**
     * @expectedException Exception
     * Url pattern is not in valid format
     */
    public function test_route_pattern_invalid_shouldRaiseException()
    {
        $url_pattern = '/users/{id';
        $routeParser = new RouteParser($url_pattern);
    }
    /**
     * @expectedException Exception
     * Url pattern is not in valid format, should not contain white space
     */
    public function test_route_pattern_invalid_white_space_shouldRaiseException()
    {
        $url_pattern = '/users/:i d';
        $routeParser = new RouteParser($url_pattern);
    }
}

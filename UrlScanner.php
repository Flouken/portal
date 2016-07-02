<?php


class UrlScanner
{
    public static function url_segments()
    {
        $url = isset($_REQUEST['URL_STR']) ? $_REQUEST['URL_STR'] : '';
        $segments = explode('/', $url);
        return array_values(array_filter($segments));
    }
    public static function request_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    public static function active_route()
    {
        $url_segments = UrlScanner::url_segments();
        $apply_segment = true;
        $active_route = '';
        for($i=0; $i < count($url_segments); $i++) {
            if($apply_segment)
                $active_route .= $url_segments[$i];
            $apply_segment = !$apply_segment;
        }
        $active_route .= count($url_segments);
        return $active_route;
    }
}
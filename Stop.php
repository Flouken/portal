<?php


class Stop
{
    // Server script runtime error.
    public static function internal_server_error($status_code=500) {
        Stop::stop_with_status_code($status_code);
    }

    // Generic client error. Example, bad data passed to server or bad login.
    public static function bad_request($status_code=400) {
        Stop::stop_with_status_code($status_code);
    }

    // Missing login.
    public static function unauthorized($status_code=401) {
        Stop::stop_with_status_code($status_code);
    }

    // Permission on user is to low.
    public static function forbidden($status_code=403) {
        Stop::stop_with_status_code($status_code);
    }

    private static function stop_with_status_code($status_code) {
        http_response_code($status_code);
        exit();
    }

}
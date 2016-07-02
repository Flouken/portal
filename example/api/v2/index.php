<?php


header('Content-Type: application/json; charset=utf-8');

include_once $_SERVER['DOCUMENT_ROOT'] . '/portal/Portal.php';

$app = new Portal();

$app->get('/hello/:username', function($request, $response) {
    $response->send(['Hello ' . $request->args->username . '! You called a GET route on API V2']);
});

$app->post('/hello/:username', function($request, $response) {
    $response->send(['Hello ' . $request->args->username . '! You called a POST route on API V2']);
});


$app->run();
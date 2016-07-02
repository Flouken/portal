<?php


header('Content-Type: application/json; charset=utf-8');

include_once $_SERVER['DOCUMENT_ROOT'] . '/portal/Portal.php';

$app = new Portal();

// Add a GET route for getting all users
$app->get('/users', function($request, $response) {
    /*
     * This route will respond with a JSON.
     *
        {
          "users": [
            1,
            2,
            3,
            4,
            5
          ]
        }
     */
    $response->send(['users' => [1,2,3,4,5]]);
});

// Add a GET route with url-parameter username
$app->get('/users/:username', function($request, $response) {
    /*
    * The $request->args contains the populated values in the URL in this case $request->args->username
    * contains the value from url /username/foo
    *
    * $response->send(array, http_status_code=200) prints a json-formated response back to client.
    * default status code is 200 you can add your own code there. Example
    * $response->send(['Getting ' . $request->args->username], 500); would be a internal server error status
    */
    $response->send(['Getting ' . $request->args->username]);
});

// Add a POST route
$app->post('/users', function($request, $response) {
    /*
     * All the json-data from clients can be reached from the $request->payload->foo
     * If client sends no payload then the attribute will contain NULL value.
     * It's also possible to use the URL-arguments if you wish so
     */
    $response->send(['Posting a new user ' . $request->payload->username]);
});

// Ways to handle a stop
$app->post('/messages', function($request, $response) {
    /*
     * Payloads that are not populated will contain NULL value.
     */

    // Here we set http status code to 400 bad request
    if($request->payload->message === NULL)
        $response->send(['id is not set!'], 400);

    // Another way is to call Stop::bad_request();
    if($request->payload->message === NULL)
        Stop::bad_request();

    $response->send(['message is ' . $request->payload->message]);
});

/*
 *
 * Example with middleware
 *
 * Middleware is an array of functions that will get called in a sequence before the route is executed.
 * There are two types of middleware sequences.
 * 1. global
 * 2. route specific
 * The global sequence will apply to all routes. While route specific only apply to the specified route.
 * The use of middleware is to perform some rutines before the route is called. This can be an authentication check.
 * To pass data between the middlewares consider adding the data to. $request->mw_data->my_Attribute = 45
 * that is an ArrayObject() set with flag ArrayObject::ARRAY_AS_PROPS. You can then set data and get data between
 * middlewares and finaly at the route itself.
 */

function check_session($request, $response) {
    //Do some logic here to check session
    $request->mw_data->user_level = 1;
}

function logger($request, $response) {
    //do some logging here after the check_session is done
    //log_write_session_check($request->mw_data->user_level);
}

//How to register the middleware route specific
$app->get('/checkpoint', function($request, $response) {
    $user_level = $request->mw_data->user_level; //get the user_level from middleware
    $response->send(['user_level' => $user_level]);
}, [check_session, logger]); //register route specific middlewares like this in an array

//How to register middleware global to all routes
$app_with_global_middleware = new Portal([check_session, logger]);


/*
 *
 * Chain populate response
 * Is a way that you can simply add attributes to $response->payload which gets accumulated and finaly
 * sent when calling $response->send(); Remember that this can be reached from all middlewares also.
 *
*/

$app->get('/accumulated', function($request, $response) {
    $response->payload->username = 'Foo';
    $response->payload->id = 45;
    $response->payload->items = ['type' => 'pencil', 'amount' => 23, 'price' => 10, 'currency' => 'SEK'];
    $response->send();
    /*
     * Returns this to client
     * {
     *    "username": "Foo",
     *    "id": 45,
     *    "items": {
     *      "type": "pencil",
     *      "amount": 23,
     *      "price": 10,
     *      "currency": "SEK"
     *    }
     *  }
     */
});
$app->run();
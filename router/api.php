<?php

use App\Models\exampleModel;
use FastRoute\RouteCollector;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

use Rakit\Validation\Validator;
use App\respHandler;

$resp = new respHandler();
$result = "";
global $serversetup;

//    $data = new SigningModel();
function error()
{
    return [
        'status' => 405,
        'message' => 'error variable for api is not enough . Please see Documents !',
    ];
}
function exampleRoute()
{
    try {

        $data = new exampleModel();
        $dataProdiuce = $data->exampleFunction($params['value']);
        $tmp_res = [
            'status' => 200,
            'message' => 'success',
            'responce' => $dataProdiuce
        ];
        return $GLOBALS['resp']->success_response($tmp_res, 33, 'task select all successfully.');
    } catch (Exception $exeption) {
        return $GLOBALS['resp']->error_response($exeption->getMessage(), 44, 'task select action failed.');
    }
}

function get_start()
{
    return [
        'status' => 200,
        'message' => 'Hello Marcro Is Working !',
        'vars' => [
            'vars' => '',
            '$_GET' => $_GET,
            '$_POST' => $_POST,
        ],

    ];
}




$dispatcher = FastRoute\cachedDispatcher(function (RouteCollector $r) {
    $r->addRoute('POST', '/', 'get_start');
    $r->addRoute('GET', '/', 'get_start');
    $r->addRoute('POST', '/exampleroute', 'exampleRoute');
    $r->addRoute('POST', '/exampleroute', 'exampleRoute');

}, [
        'cacheFile' => __DIR__ . '/route.cache' /* required */
    ]);

function handleRequest($dispatcher, $request_method, $request_uri)
{


    list($code, $handler, $vars) = $dispatcher->dispatch($request_method, $request_uri);


    switch ($code) {
        case FastRoute\Dispatcher::NOT_FOUND:
            $result = [
                'status' => 404,
                'message' => 'Not Found',
                'errors' => [
                    sprintf('The URI "%s" was not found', $request_uri)
                ]
            ];
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $handler;
            $result = [
                'status' => 405,
                'message' => 'Method Not Allowed',
                'errors' => [
                    sprintf('Method "%s" is not allowed', $request_method)
                ]
            ];
            break;
        case FastRoute\Dispatcher::FOUND:

            $result = call_user_func($handler, $vars);

            break;
    }

    return $result;
}


$server = new Server($swoolhost, $swoolport, SWOOLE_PROCESS);
$server->set(SERVER_SET_UP);
// a swoole server is evented just like express
$server->on('start', function (Server $server) use ($swoolhostname, $swoolport) {
    echo sprintf('Swoole http server is started at http://%s:%s' . PHP_EOL, $swoolhostname, $swoolport);
});

// handle all requests with this response
$server->on('request', function (Request $request, Response $response) use ($dispatcher) {
    $request_method = $request->server['request_method'];
    $request_uri = $request->server['request_uri'];
    /****************
     * Check Api
     ***************/
    $apiKey = getenv('API-KEY');
    $apiGetKey = $request->header['x-api-key'];
    if ($apiKey != $apiGetKey) {
        $response->header('Content-Type', 'application/json');
        $result = handleRequest($dispatcher, $request_method, $request_uri);
        $response->end(json_encode([
            'status' => 405,
            'message' => 'Wrong API Method !',
        ]));
        return;
    }
    /****************
     * END OF Check Api
     ***************/
    // populate the global state with the request info
    $_SERVER['REQUEST_URI'] = $request_uri;
    $_SERVER['REQUEST_METHOD'] = $request_method;
    $_SERVER['REMOTE_ADDR'] = $request->server['remote_addr'];

    $_GET = $request->get ?? [];
    $_FILES = $request->files ?? [];

    // form-data and x-www-form-urlencoded work out of the box so we handle JSON POST here
    if ($request_method === 'POST' && $request->header['content-type'] === 'application/json') {
        $body = $request->rawContent();


        $_POST = empty($body) ? [] : json_decode($body);
    } else {
        $_POST = $request->post ?? [];
    }

    // global content type for our responses
    $response->header('Content-Type', 'application/json');

    $result = handleRequest($dispatcher, $request_method, $request_uri);

    // write the JSON string out
    $response->end(json_encode($result));
});

$server->start();

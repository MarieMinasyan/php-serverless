<?php

// Invoke Composer's autoloader so that we'll be able to use Guzzle and any other 3rd party libraries we need
require $_ENV['LAMBDA_TASK_ROOT'] . '/vendor/autoload.php';

// This is the request processing loop. Barring unrecoverable failure, this loop runs until the environment shuts down.
do {
    // Ask the runtime API for a request to handle.
    $request = getNextRequest();

    // Obtain the function name from the _HANDLER environment variable and ensure the function's code is available.
    list($handlerFile, $handlerFunction) = explode(".", $_ENV['_HANDLER']);
    require_once $_ENV['LAMBDA_TASK_ROOT'] . '/src/' . $handlerFile . '.php';

    // Execute the desired function and obtain the response.
    $response = $handlerFunction($request['payload']);

    // Submit the response back to the runtime API.
    sendResponse($request['invocationId'], $response);
} while (true);

function getNextRequest()
{
    $client = new \GuzzleHttp\Client();
    $response = $client->get(sprintf(
        'http://%s/2018-06-01/runtime/invocation/next',
        $_ENV['AWS_LAMBDA_RUNTIME_API']
    ));

    return [
        'invocationId' => $response->getHeader('Lambda-Runtime-Aws-Request-Id')[0],
        'payload'      => json_decode((string) $response->getBody(), true)
    ];
}

function sendResponse($invocationId, $response)
{
    $client = new \GuzzleHttp\Client();
    $client->post(
        sprintf(
            'http://%s/2018-06-01/runtime/invocation/%s/response',
            $_ENV['AWS_LAMBDA_RUNTIME_API'],
            $invocationId
        ),
        ['body' => $response]
    );
}

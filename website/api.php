<?php

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i','', array_shift($request));

if ($method === 'POST' && $table === 'transactions') {
    require_once('rest.php');
    $rest = new REST();

    $value = $rest->getCurrentMealValue();
    $value = - abs($value);

    $result = $rest->insertTransaction($input['id'], $value, $input['restaurant']);
    if (is_numeric($result)) {
        echo $result;
    }
    else {
        http_response_code(400);
        echo $result;
    }

    exit();
}
<?php
require_once __DIR__ . '/../controllers/AuthController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

// Determine  the request path for routing
if(isset($_SERVER['PATH_INFO'])){
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
} else {
    // fallback: parse the request URI to script name 
    $script_name = dirname($_SERVER['SCRIPT_NAME']);
    $request_uri = $_SERVER['REQUEST_URI'];
    $path = substr($request_uri, strlen($script_name));
    $path = strtok($path, '?'); // remove query string
    $request = explode('/', trim($path, '/'));
}

// handle preflight OPTIONS request
if($method === 'OPTIONS'){
    http_response_code(200);
    exit();
}
$authController = new AuthController();

if($request[0] === 'register' && $method === 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $authController->register($data);
} elseif($request[0] === 'login' && $method === 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $authController->login($data);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}






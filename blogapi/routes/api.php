<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/CategoryController.php';

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
$categoryController = new CategoryController();

if($request[0] === 'register' && $method === 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $authController->register($data);
} elseif($request[0] === 'login' && $method === 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $authController->login($data);
}elseif($request[0]=== 'categories'){
    if($method==='GET'){
        if(isset($request[1])){
            $categoryController->getCategory($request[1]);
        }else{
            $categoryController->getAllCategories();
        }
    }elseif($method==='POST'){
        $data = json_decode(file_get_contents("php://input"), true);
        $categoryController->createCategory($data);
    }elseif($method==='PUT' && isset($request[1])){
        $data = json_decode(file_get_contents("php://input"), true);
        $categoryController->updateCategory($request[1], $data);
    }elseif($method==='DELETE' && isset($request[1])){
        $categoryController->deleteCategory($request[1]);
    } else {
        http_response_code(405);
        echo json_encode(['message' => 'method not allowed']);
    }
        
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}






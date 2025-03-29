<?php 
session_start(); 
require_once 'app/models/ProductModel.php'; 
require_once 'app/helpers/SessionHelper.php'; 

// Product/add 
$url = $_GET['url'] ?? ''; 
$url = rtrim($url, '/'); 
$url = filter_var($url, FILTER_SANITIZE_URL); 
$url = explode('/', $url); 

// Kiểm tra phần đầu tiên của URL để xác định controller 
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'ProductController'; 
$controllerPath = 'app/controllers/' . $controllerName . '.php';

// Check for admin namespace
if (isset($url[0]) && $url[0] == 'admin' && isset($url[1])) {
    $controllerName = ucfirst($url[1]) . 'Controller';
    $controllerPath = 'app/controllers/admin/' . $controllerName . '.php';
    $action = isset($url[2]) && $url[2] != '' ? $url[2] : 'index';
    $paramOffset = 3; // Offset for parameters in admin routes
} else {
    $action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';
    $paramOffset = 2; // Offset for parameters in regular routes
}

// Kiểm tra xem controller và action có tồn tại không 
if (!file_exists($controllerPath)) { 
    // Xử lý không tìm thấy controller 
    die('Controller not found: ' . $controllerPath); 
} 

require_once $controllerPath; 

// Không cần ghi đè tên controller cho admin namespace nữa
$controller = new $controllerName(); 

if (!method_exists($controller, $action)) { 
    // Xử lý không tìm thấy action 
    die('Action not found: ' . $action); 
} 

// Gọi action với các tham số còn lại (nếu có) 
call_user_func_array([$controller, $action], array_slice($url, $paramOffset));

// Xử lý các request AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');
}
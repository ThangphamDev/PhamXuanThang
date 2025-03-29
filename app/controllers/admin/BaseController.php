<?php
require_once 'app/config/database.php';
require_once 'app/helpers/SessionHelper.php';

class BaseController
{
    protected $db;
    
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Check if user is admin
        if (!$this->isAdmin()) {
            header('Location: /account/login');
            exit;
        }
    }
    
    // Helper method to check if user is an admin
    protected function isAdmin()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    // Helper method to load models
    protected function model($modelName)
    {
        require_once 'app/models/' . $modelName . '.php';
        return new $modelName($this->db);
    }
    
    // Helper method to load views
    protected function view($viewName, $data = [])
    {
        // Extract data to make variables available in view
        extract($data);
        
        // Load the view
        require_once 'app/views/' . $viewName . '.php';
    }
    
    // Check if a page is current
    public function isCurrentPage($page)
    {
        $url = $_GET['url'] ?? '';
        return strpos($url, trim($page, '/')) === 0;
    }
    
    // Liệt kê danh sách người dùng (để quản lý)
    public function listUsers() 
    {
        // Redirect to account controller method
        header('Location: /account/listUsers');
        exit;
    }
} 
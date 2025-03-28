<?php

class Controller {
    protected $db;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
    }
    
    protected function view($view, $data = []) {
        // Extract data to make variables available in the view
        extract($data);
        
        // Include the view file
        include 'app/views/' . $view . '.php';
    }
    
    protected function model($model) {
        require_once 'app/models/' . $model . 'Model.php';
        $modelClass = $model . 'Model';
        return new $modelClass($this->db);
    }
} 
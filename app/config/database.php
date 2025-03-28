<?php 
class Database { 
    private $host = "localhost"; 
    private $db_name = "my_store"; 
    private $username = "root"; 
    private $password = ""; 
    public $conn; 

    public function getConnection() { 
        $this->conn = null; 

        try { 
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, $this->password, 
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) // Bật chế độ báo lỗi
            ); 
            $this->conn->exec("set names utf8"); 
        } catch(PDOException $exception) { 
            die("Connection error: " . $exception->getMessage()); // Dừng chương trình nếu có lỗi
        } 

        return $this->conn; 
    } 
}

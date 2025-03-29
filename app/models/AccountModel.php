<?php
class AccountModel 
{
    private $conn;
    private $table_name = "users"; // Đổi từ "account" thành "users"

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username) 
    {
        $query = "SELECT * FROM users WHERE username = :username"; // Đổi "account" thành "users"
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function save($username, $name, $password, $role = "user") 
    {
        $query = "INSERT INTO " . $this->table_name . " (username, name, password, role) 
                  VALUES (:username, :name, :password, :role)";
        
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $username = htmlspecialchars(strip_tags($username));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getAccountById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    public function updateAccount($id, $data)
    {
        // Xây dựng câu lệnh SQL động dựa trên dữ liệu cần cập nhật
        $updateFields = [];
        $updateData = [];

        // Xử lý trường fullname thành name trong cơ sở dữ liệu
        if (isset($data['fullname'])) {
            $updateFields[] = "name = :name";
            $updateData[':name'] = htmlspecialchars(strip_tags($data['fullname']));
            unset($data['fullname']);
        }
        
        // Xử lý các trường khác
        foreach ($data as $key => $value) {
            $updateFields[] = "{$key} = :{$key}";
            $updateData[":{$key}"] = htmlspecialchars(strip_tags($value));
        }
        
        if (empty($updateFields)) {
            return false; // Không có gì để cập nhật
        }
        
        $updateFieldsStr = implode(", ", $updateFields);
        $query = "UPDATE " . $this->table_name . " SET {$updateFieldsStr} WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind tham số ID
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Bind các tham số khác
        foreach ($updateData as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function countTotalUsers() 
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }
    
    public function getAllUsers($limit = 10, $offset = 0) 
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function deleteAccount($id) 
    {
        // Kiểm tra xem tài khoản có phải là admin không
        $query = "SELECT role FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($result && $result->role === 'admin') {
            return false; // Không cho phép xóa tài khoản admin
        }
        
        // Tiến hành xóa tài khoản
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>
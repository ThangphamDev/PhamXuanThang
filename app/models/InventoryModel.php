<?php

class InventoryModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProductInventory($productId) {
        $sql = "SELECT * FROM inventory WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateQuantity($productId, $quantity) {
        $sql = "UPDATE inventory 
                SET quantity = :quantity, 
                    last_updated = CURRENT_TIMESTAMP 
                WHERE product_id = :product_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':product_id', $productId);
        
        return $stmt->execute();
    }

    public function checkStock($productId, $requestedQuantity) {
        $inventory = $this->getProductInventory($productId);
        return $inventory && $inventory->quantity >= $requestedQuantity;
    }

    public function getLowStockProducts() {
        $sql = "SELECT i.*, p.name as product_name, p.price, c.name as category_name 
                FROM inventory i 
                JOIN product p ON i.product_id = p.id 
                JOIN category c ON p.category_id = c.id 
                WHERE i.quantity <= i.min_quantity
                ORDER BY i.quantity ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getInventoryStats() {
        $sql = "SELECT 
                    COUNT(*) as total_products,
                    SUM(quantity) as total_quantity,
                    COUNT(CASE WHEN quantity <= min_quantity THEN 1 END) as low_stock_count,
                    COUNT(CASE WHEN quantity = 0 THEN 1 END) as out_of_stock_count
                FROM inventory";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getInventoryByCategory($categoryId = null) {
        $sql = "SELECT i.*, p.name as product_name, p.price, p.image, c.name as category_name 
                FROM inventory i 
                JOIN product p ON i.product_id = p.id 
                JOIN category c ON p.category_id = c.id";
        
        if ($categoryId) {
            $sql .= " WHERE p.category_id = :category_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':category_id', $categoryId);
        } else {
            $stmt = $this->conn->prepare($sql);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addInventory($productId, $quantity, $minQuantity, $maxQuantity) {
        $sql = "INSERT INTO inventory (product_id, quantity, min_quantity, max_quantity) 
                VALUES (:product_id, :quantity, :min_quantity, :max_quantity)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':min_quantity', $minQuantity);
        $stmt->bindParam(':max_quantity', $maxQuantity);
        
        return $stmt->execute();
    }

    public function deleteInventory($productId) {
        $sql = "DELETE FROM inventory WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        
        return $stmt->execute();
    }
} 
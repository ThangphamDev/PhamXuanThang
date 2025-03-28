<?php

class Inventory {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Lấy thông tin tồn kho của một sản phẩm
    public function getProductInventory($productId) {
        $this->db->query('SELECT * FROM inventory WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);
        return $this->db->single();
    }

    // Cập nhật số lượng tồn kho
    public function updateQuantity($productId, $quantity) {
        $this->db->query('UPDATE inventory SET quantity = :quantity, last_updated = CURRENT_TIMESTAMP WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':quantity', $quantity);
        return $this->db->execute();
    }

    // Kiểm tra số lượng tồn kho có đủ không
    public function checkStock($productId, $requestedQuantity) {
        $inventory = $this->getProductInventory($productId);
        return $inventory && $inventory->quantity >= $requestedQuantity;
    }

    // Lấy danh sách sản phẩm sắp hết hàng (dưới min_quantity)
    public function getLowStockProducts() {
        $this->db->query('
            SELECT i.*, p.name as product_name, p.price, c.name as category_name 
            FROM inventory i 
            JOIN product p ON i.product_id = p.id 
            JOIN category c ON p.category_id = c.id 
            WHERE i.quantity <= i.min_quantity
            ORDER BY i.quantity ASC
        ');
        return $this->db->resultSet();
    }

    // Lấy thống kê tồn kho
    public function getInventoryStats() {
        $this->db->query('
            SELECT 
                COUNT(*) as total_products,
                SUM(quantity) as total_quantity,
                COUNT(CASE WHEN quantity <= min_quantity THEN 1 END) as low_stock_count,
                COUNT(CASE WHEN quantity = 0 THEN 1 END) as out_of_stock_count
            FROM inventory
        ');
        return $this->db->single();
    }

    // Lấy danh sách tồn kho theo danh mục
    public function getInventoryByCategory($categoryId = null) {
        $sql = '
            SELECT i.*, p.name as product_name, p.price, c.name as category_name 
            FROM inventory i 
            JOIN product p ON i.product_id = p.id 
            JOIN category c ON p.category_id = c.id
        ';
        
        if ($categoryId) {
            $sql .= ' WHERE p.category_id = :category_id';
            $this->db->query($sql);
            $this->db->bind(':category_id', $categoryId);
        } else {
            $this->db->query($sql);
        }
        
        return $this->db->resultSet();
    }

    // Thêm mới bản ghi tồn kho
    public function addInventory($productId, $quantity, $minQuantity, $maxQuantity) {
        $this->db->query('
            INSERT INTO inventory (product_id, quantity, min_quantity, max_quantity) 
            VALUES (:product_id, :quantity, :min_quantity, :max_quantity)
        ');
        
        $this->db->bind(':product_id', $productId);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':min_quantity', $minQuantity);
        $this->db->bind(':max_quantity', $maxQuantity);
        
        return $this->db->execute();
    }

    // Xóa bản ghi tồn kho
    public function deleteInventory($productId) {
        $this->db->query('DELETE FROM inventory WHERE product_id = :product_id');
        $this->db->bind(':product_id', $productId);
        return $this->db->execute();
    }
} 
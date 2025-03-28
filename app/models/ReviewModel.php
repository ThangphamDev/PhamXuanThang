<?php
class ReviewModel 
{
    private $conn;
    private $table_name = "reviews";

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    // Lấy tất cả đánh giá
    public function getAllReviews($page = 1, $per_page = 10) 
    {
        $offset = ($page - 1) * $per_page;
        
        $query = "SELECT r.*, p.name as product_name, p.image as product_image, u.username, u.name as user_fullname
                  FROM " . $this->table_name . " r
                  LEFT JOIN product p ON r.product_id = p.id
                  LEFT JOIN users u ON r.user_id = u.id
                  ORDER BY r.created_at DESC
                  LIMIT :offset, :per_page";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy tổng số đánh giá
    public function getTotalReviews() 
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    // Lấy đánh giá theo ID
    public function getReviewById($id) 
    {
        $query = "SELECT r.*, p.name as product_name, p.image as product_image, u.username, u.name as user_fullname
                  FROM " . $this->table_name . " r
                  LEFT JOIN product p ON r.product_id = p.id
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lấy đánh giá của một sản phẩm
    public function getReviewsByProductId($product_id, $page = 1, $per_page = 5) 
    {
        $offset = ($page - 1) * $per_page;
        
        $query = "SELECT r.*, u.username, u.name as user_fullname
                  FROM " . $this->table_name . " r
                  LEFT JOIN users u ON r.user_id = u.id
                  WHERE r.product_id = :product_id
                  ORDER BY r.created_at DESC
                  LIMIT :offset, :per_page";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy tổng số đánh giá của một sản phẩm
    public function getTotalReviewsByProductId($product_id) 
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    // Lấy đánh giá của một người dùng
    public function getReviewsByUserId($user_id, $page = 1, $per_page = 10) 
    {
        $offset = ($page - 1) * $per_page;
        
        $query = "SELECT r.*, p.name as product_name, p.image as product_image
                  FROM " . $this->table_name . " r
                  LEFT JOIN product p ON r.product_id = p.id
                  WHERE r.user_id = :user_id
                  ORDER BY r.created_at DESC
                  LIMIT :offset, :per_page";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy tổng số đánh giá của một người dùng
    public function getTotalReviewsByUserId($user_id) 
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }

    // Lấy phân phối đánh giá theo số sao
    public function getRatingDistribution() 
    {
        $query = "SELECT rating, COUNT(*) as count 
                  FROM " . $this->table_name . " 
                  GROUP BY rating 
                  ORDER BY rating DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy sản phẩm có đánh giá cao nhất
    public function getTopRatedProducts($limit = 5) 
    {
        $query = "SELECT p.id, p.name, p.image, p.rating, p.rating_count,
                      (SELECT content FROM " . $this->table_name . " WHERE product_id = p.id ORDER BY created_at DESC LIMIT 1) as latest_review
                  FROM product p
                  WHERE p.rating_count > 0
                  ORDER BY p.rating DESC, p.rating_count DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?> 
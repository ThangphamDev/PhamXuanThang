<?php 
class ProductModel 
{ 
    private $conn; 
    private $table_name = "product"; 
 
    public function __construct($db) 
    { 
        $this->conn = $db; 
    } 
 
    public function getProducts($page = 1, $per_page = 12) 
    { 
        $offset = ($page - 1) * $per_page;
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN category c ON p.category_id = c.id
                  LIMIT :offset, :per_page"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        $stmt->execute(); 
        $result = $stmt->fetchAll(PDO::FETCH_OBJ); 
        return $result; 
    } 

    public function getFilteredProducts($category_id = null, $min_price = 0, $max_price = null, $rating = null, $page = 1, $per_page = 12) 
    {
        $offset = ($page - 1) * $per_page;
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE 1=1";
        
        $params = [];
        
        if ($category_id !== null && $category_id !== 'all') {
            $query .= " AND p.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        
        if ($min_price !== null) {
            $query .= " AND p.price >= :min_price";
            $params[':min_price'] = $min_price;
        }
        
        if ($max_price !== null) {
            $query .= " AND p.price <= :max_price";
            $params[':max_price'] = $max_price;
        }
        
        if ($rating !== null) {
            $query .= " AND p.rating >= :rating";
            $params[':rating'] = $rating;
        }
        
        // Thêm phân trang
        $query .= " LIMIT :offset, :per_page";
        $params[':offset'] = $offset;
        $params[':per_page'] = $per_page;
        
        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $value) {
            if ($key == ':offset' || $key == ':per_page') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProductCount($category_id = null) 
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " p";
        $params = [];
        
        if ($category_id !== null && $category_id !== 'all') {
            $query .= " WHERE p.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        
        // Add conditions for price and rating if they exist in the request
        if (isset($_GET['min_price'])) {
            $query .= ($category_id === null ? " WHERE" : " AND") . " p.price >= :min_price";
            $params[':min_price'] = $_GET['min_price'];
        }
        
        if (isset($_GET['max_price'])) {
            $query .= ($category_id === null && !isset($_GET['min_price']) ? " WHERE" : " AND") . " p.price <= :max_price";
            $params[':max_price'] = $_GET['max_price'];
        }
        
        if (isset($_GET['rating'])) {
            $query .= ($category_id === null && !isset($_GET['min_price']) && !isset($_GET['max_price']) ? " WHERE" : " AND") . " p.rating >= :rating";
            $params[':rating'] = $_GET['rating'];
        }
        
        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count;
    }
    
    public function getProductById($id) 
    { 
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':id', $id); 
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ); 
        return $result; 
    } 
 
    public function addProduct($name, $description, $price, $category_id, $image) 
    { 
        $errors = []; 
        if (empty($name)) { 
            $errors['name'] = 'Tên sản phẩm không được để trống'; 
        } 
        if (empty($description)) { 
            $errors['description'] = 'Mô tả không được để trống'; 
        } 
        if (!is_numeric($price) || $price < 0) { 
            $errors['price'] = 'Giá sản phẩm không hợp lệ'; 
        } 
        if (count($errors) > 0) { 
            return $errors; 
        } 
 
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, 
category_id, image) VALUES (:name, :description, :price, :category_id, :image)"; 
        $stmt = $this->conn->prepare($query); 
 
        $name = htmlspecialchars(strip_tags($name)); 
        $description = htmlspecialchars(strip_tags($description)); 
        $price = htmlspecialchars(strip_tags($price)); 
        $category_id = htmlspecialchars(strip_tags($category_id)); 
        $image = htmlspecialchars(strip_tags($image)); 
 
        $stmt->bindParam(':name', $name); 
        $stmt->bindParam(':description', $description); 
        $stmt->bindParam(':price', $price); 
        $stmt->bindParam(':category_id', $category_id); 
        $stmt->bindParam(':image', $image); 
 
        if ($stmt->execute()) { 
            return true; 
        } 
 
        return false; 
    } 
 
    public function updateProduct($id, $name, $description, $price, $category_id, 
$image) 
    {
        $query = "UPDATE " . $this->table_name . " SET name=:name, 
description=:description, price=:price, category_id=:category_id, image=:image WHERE 
id=:id"; 
$stmt = $this->conn->prepare($query); 
$name = htmlspecialchars(strip_tags($name)); 
$description = htmlspecialchars(strip_tags($description)); 
$price = htmlspecialchars(strip_tags($price)); 
$category_id = htmlspecialchars(strip_tags($category_id)); 
$image = htmlspecialchars(strip_tags($image)); 
$stmt->bindParam(':id', $id); 
$stmt->bindParam(':name', $name); 
$stmt->bindParam(':description', $description); 
$stmt->bindParam(':price', $price); 
$stmt->bindParam(':category_id', $category_id); 
$stmt->bindParam(':image', $image); 
if ($stmt->execute()) { 
return true; 
} 
return false; 
} 
public function deleteProduct($id) 
{ 
$query = "DELETE FROM " . $this->table_name . " WHERE id=:id"; 
$stmt = $this->conn->prepare($query); 
$stmt->bindParam(':id', $id); 
if ($stmt->execute()) { 
return true; 
} 
return false; 
} 

public function getPriceRange() 
{
    $query = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

public function searchProducts($keyword, $page = 1, $per_page = 12) 
{
    $offset = ($page - 1) * $per_page;
    $query = "SELECT p.*, c.name as category_name 
              FROM " . $this->table_name . " p 
              LEFT JOIN category c ON p.category_id = c.id
              WHERE p.name LIKE :keyword OR p.description LIKE :keyword
              LIMIT :offset, :per_page";
    
    $stmt = $this->conn->prepare($query);
    $keyword = "%{$keyword}%";
    $stmt->bindParam(':keyword', $keyword);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function sortProducts($sortBy = 'popular', $page = 1, $per_page = 12) 
{
    $offset = ($page - 1) * $per_page;
    $query = "SELECT p.*, c.name as category_name 
              FROM " . $this->table_name . " p 
              LEFT JOIN category c ON p.category_id = c.id";
    
    switch ($sortBy) {
        case 'price_asc':
            $query .= " ORDER BY p.price ASC";
            break;
        case 'price_desc':
            $query .= " ORDER BY p.price DESC";
            break;
        case 'newest':
            $query .= " ORDER BY p.id DESC";
            break;
        case 'oldest':
            $query .= " ORDER BY p.id ASC";
            break;
        case 'popular':
        default:
            $query .= " ORDER BY p.id ASC";
            break;
    }
    
    $query .= " LIMIT :offset, :per_page";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function getTotalSearchResults($keyword)
{
    $query = "SELECT COUNT(*) as count 
              FROM " . $this->table_name . " p 
              WHERE p.name LIKE :keyword OR p.description LIKE :keyword";
    
    $stmt = $this->conn->prepare($query);
    $keyword = "%{$keyword}%";
    $stmt->bindParam(':keyword', $keyword);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->count;
}

public function getTotalFilteredProducts($category_id = null, $min_price = 0, $max_price = null, $rating = null)
{
    $query = "SELECT COUNT(*) as count 
              FROM " . $this->table_name . " p 
              WHERE 1=1";
    
    $params = [];
    
    if ($category_id !== null && $category_id !== 'all') {
        $query .= " AND p.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }
    
    if ($min_price !== null) {
        $query .= " AND p.price >= :min_price";
        $params[':min_price'] = $min_price;
    }
    
    if ($max_price !== null) {
        $query .= " AND p.price <= :max_price";
        $params[':max_price'] = $max_price;
    }
    
    if ($rating !== null) {
        $query .= " AND p.rating >= :rating";
        $params[':rating'] = $rating;
    }
    
    $stmt = $this->conn->prepare($query);
    
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->count;
}

public function getTotalProducts() 
{
    $query = "SELECT COUNT(*) as count FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result->count;
}

public function getProductReviews($productId) {
    $sql = "SELECT r.*, u.name as user_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.product_id = :product_id 
            ORDER BY r.created_at DESC";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':product_id', $productId);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function getRelatedProducts($productId, $categoryId, $limit = 4) {
    $sql = "SELECT * FROM product 
            WHERE category_id = :category_id 
            AND id != :product_id 
            ORDER BY RAND() 
            LIMIT :limit";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':category_id', $categoryId);
    $stmt->bindParam(':product_id', $productId);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function updateProductRating($productId) {
    // Tính toán rating trung bình
    $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as rating_count 
            FROM reviews 
            WHERE product_id = :product_id";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':product_id', $productId);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    // Cập nhật rating của sản phẩm
    $sql = "UPDATE product 
            SET rating = :rating, rating_count = :rating_count 
            WHERE id = :product_id";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':rating', $result->avg_rating);
    $stmt->bindParam(':rating_count', $result->rating_count);
    $stmt->bindParam(':product_id', $productId);
    
    return $stmt->execute();
}
} 
?>
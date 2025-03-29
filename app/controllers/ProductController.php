<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/InventoryModel.php');
require_once('app/controllers/Controller.php');

class ProductController extends Controller 
{
    private $productModel;
    private $inventoryModel;

    public function __construct() 
    {
        parent::__construct();
        $this->productModel = new ProductModel($this->db);
        $this->inventoryModel = new InventoryModel($this->db);
    }

    
    public function filter() 
    {
        // Get filter parameters from GET request
        $category_id = isset($_GET['category']) ? $_GET['category'] : null;
        $min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
        $max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
        $rating = isset($_GET['rating']) ? (int)$_GET['rating'] : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $products_per_page = 12; // 4 dòng x 3 cột
        
        // Lấy tổng số sản phẩm để tính số trang
        $total_count = $this->productModel->getTotalFilteredProducts($category_id, $min_price, $max_price, $rating);
        $total_pages = ceil($total_count / $products_per_page);
        
        // Đảm bảo trang hiện tại hợp lệ
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        
        // Get filtered products with pagination
        $products = $this->productModel->getFilteredProducts($category_id, $min_price, $max_price, $rating, $page, $products_per_page);
        
        // Get all categories for the filter sidebar
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        
        // Add product count to each category based on current filters
        foreach ($categories as $category) {
            $category->product_count = $this->productModel->getProductCount($category->id);
        }
        
        // Get price range for products
        $price_range = $this->productModel->getPriceRange();
        $min_product_price = $price_range->min_price ?? 0;
        $max_product_price = $price_range->max_price ?? 1000000;
        
        // Chuẩn bị thông tin phân trang
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $products_per_page,
            'total_products' => $total_count
        ];
        
        // If this is an AJAX request, return JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'products' => $products,
                'min_price' => $min_product_price,
                'max_price' => $max_product_price,
                'categories' => $categories,
                'pagination' => $pagination
            ]);
            exit;
        }
        
        // Otherwise, include the view
        include 'app/views/product/list.php';
    }

    public function search() 
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $products_per_page = 12; // 4 dòng x 3 cột
        
        // Lấy tổng số sản phẩm thỏa mãn tìm kiếm
        if (!empty($keyword)) {
            $total_count = $this->productModel->getTotalSearchResults($keyword);
            $products = $this->productModel->searchProducts($keyword, $page, $products_per_page);
        } else {
            $total_count = $this->productModel->getTotalProducts();
            $products = $this->productModel->getProducts();
        }
        
        $total_pages = ceil($total_count / $products_per_page);
        
        // Đảm bảo trang hiện tại hợp lệ
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        
        // Get all categories for the filter sidebar
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        
        // Get price range for products
        $price_range = $this->productModel->getPriceRange();
        $min_product_price = $price_range->min_price ?? 0;
        $max_product_price = $price_range->max_price ?? 1000000;
        
        // Chuẩn bị thông tin phân trang
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $products_per_page,
            'total_products' => $total_count
        ];
        
        // If this is an AJAX request, return JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'products' => $products,
                'min_price' => $min_product_price,
                'max_price' => $max_product_price,
                'categories' => $categories,
                'pagination' => $pagination
            ]);
            exit;
        }
        
        // Otherwise, include the view
        include 'app/views/product/list.php';
    }

    public function sort() 
    {
        $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'popular';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $products_per_page = 12; // 4 dòng x 3 cột
        
        // Lấy tổng số sản phẩm
        $total_count = $this->productModel->getTotalProducts();
        $total_pages = ceil($total_count / $products_per_page);
        
        // Đảm bảo trang hiện tại hợp lệ
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        
        // Get sorted products with pagination
        $products = $this->productModel->sortProducts($sortBy, $page, $products_per_page);
        
        // Get all categories for the filter sidebar
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        
        // Get price range for products
        $price_range = $this->productModel->getPriceRange();
        $min_product_price = $price_range->min_price ?? 0;
        $max_product_price = $price_range->max_price ?? 1000000;
        
        // Chuẩn bị thông tin phân trang
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $products_per_page,
            'total_products' => $total_count
        ];
        
        // If this is an AJAX request, return JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'products' => $products,
                'min_price' => $min_product_price,
                'max_price' => $max_product_price,
                'categories' => $categories,
                'pagination' => $pagination
            ]);
            exit;
        }
        
        // Otherwise, include the view
        include 'app/views/product/list.php';
    }

    private function isAdmin() {
        return SessionHelper::isAdmin();
    }

    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $products_per_page = 12; // 4 dòng x 3 cột
        
        // Lấy tổng số sản phẩm
        $total_count = $this->productModel->getTotalProducts();
        $total_pages = ceil($total_count / $products_per_page);
        
        // Đảm bảo trang hiện tại hợp lệ
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        
        // Get all products with pagination
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';
        $products = $this->productModel->sortProducts($sort, $page, $products_per_page);
        
        // Get all categories for the filter sidebar
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        
        // Get price range for products
        $price_range = $this->productModel->getPriceRange();
        $min_product_price = $price_range->min_price ?? 0;
        $max_product_price = $price_range->max_price ?? 1000000;
        
        // Chuẩn bị thông tin phân trang
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $products_per_page,
            'total_products' => $total_count
        ];
        
        // Include the view
        include 'app/views/product/list.php';
    }

    public function addToCart($id) 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
            
            // Lấy thông tin sản phẩm
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                $response = [
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm'
                ];
                
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }
                
                $_SESSION['error'] = $response['message'];
                header('Location: /Product/show/' . $id);
                exit;
            }
            
            // Kiểm tra số lượng tồn kho
            if (!$this->inventoryModel->checkStock($id, $quantity)) {
                $response = [
                    'success' => false,
                    'message' => 'Sản phẩm không đủ số lượng trong kho'
                ];
                
                if ($this->isAjaxRequest()) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    exit;
                }
                
                $_SESSION['error'] = $response['message'];
                header('Location: /Product/show/' . $id);
                exit;
            }
            
            // Thêm vào giỏ hàng
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                    'category_id' => $product->category_id
                ];
            }
            
            // Cập nhật số lượng tồn kho
            $inventory = $this->inventoryModel->getProductInventory($id);
            $this->inventoryModel->updateQuantity($id, $inventory->quantity - $quantity);
            
            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $totalQuantity = 0;
            foreach ($_SESSION['cart'] as $item) {
                $totalQuantity += $item['quantity'];
            }
            
            $response = [
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cartCount' => $totalQuantity
            ];
            
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            
            $_SESSION['success'] = $response['message'];
            header('Location: /Product/show/' . $id);
            exit;
        }
        
        header('Location: /Product/show/' . $id);
        exit;
    }

    // Hàm kiểm tra AJAX request
    private function isAjaxRequest() 
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function cart() 
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = $this->calculateCartTotal($cart);
        include 'app/views/product/Cart.php';
    }

    public function updateCart() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['quantity'])) {
                foreach ($_POST['quantity'] as $productId => $quantity) {
                    $productId = (int)$productId;
                    $quantity = (int)$quantity;

                    if (isset($_SESSION['cart'][$productId])) {
                        if ($quantity > 0) {
                            $_SESSION['cart'][$productId]['quantity'] = $quantity;
                        } else {
                            unset($_SESSION['cart'][$productId]);
                        }
                    }
                }
            } else if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
                $productId = (int)$_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                
                if (isset($_SESSION['cart'][$productId])) {
                    if ($quantity > 0) {
                        $_SESSION['cart'][$productId]['quantity'] = $quantity;
                        $subtotal = $quantity * $_SESSION['cart'][$productId]['price'];
                        $total = $this->calculateCartTotal($_SESSION['cart']);
                        
                        echo json_encode([
                            'success' => true,
                            'subtotal' => $subtotal,
                            'total' => $total,
                            'formattedSubtotal' => number_format($subtotal, 0, ',', '.') . ' ₫',
                            'formattedTotal' => number_format($total, 0, ',', '.') . ' ₫'
                        ]);
                        exit;
                    } else {
                        unset($_SESSION['cart'][$productId]);
                        $total = $this->calculateCartTotal($_SESSION['cart']);
                        echo json_encode([
                            'success' => true,
                            'removed' => true,
                            'total' => $total,
                            'formattedTotal' => number_format($total, 0, ',', '.') . ' ₫'
                        ]);
                        exit;
                    }
                }
            }
            
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
                header('Location: /Product/cart');
                exit;
            }
        }
    }

    public function removeFromCart($id) 
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /Product/cart');
    }

    private function calculateCartTotal($cart) 
    {
        $total = 0;
        foreach ($cart as $product_id => $item) {
            if (isset($item['price']) && isset($item['quantity'])) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
 
    public function show($id) 
    {
        $productModel = $this->productModel;
        $inventoryModel = $this->inventoryModel;
        
        $product = $productModel->getProductById($id);
        if (!$product) {
            header('Location: /');
            exit;
        }
        
        $inventory = $inventoryModel->getProductInventory($id);
        
        // Lấy sản phẩm liên quan từ cùng danh mục
        $query = "SELECT p.*, c.name as category_name, 
                        (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id) as rating_count,
                        (SELECT AVG(rating) FROM reviews r WHERE r.product_id = p.id) as rating
                 FROM product p 
                 LEFT JOIN category c ON p.category_id = c.id 
                 WHERE p.category_id = :category_id 
                 AND p.id != :product_id 
                 ORDER BY RAND() 
                 LIMIT 4";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $product->category_id);
        $stmt->bindParam(':product_id', $id);
        $stmt->execute();
        
        $related_products = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        // Xử lý rating cho mỗi sản phẩm liên quan
        foreach ($related_products as $related) {
            $related->rating = round($related->rating ?? 0, 1);
            $related->rating_count = (int)$related->rating_count;
        }
        
        $data = [
            'product' => $product,
            'inventory' => $inventory,
            'reviews' => $productModel->getProductReviews($id),
            'related_products' => $related_products,
            'product_images' => $this->getProductImages($id)
        ];
        
        $this->view('product/show', $data);
    }
    
    private function getProductReviews($product_id)
    {
        try {
            $query = "SELECT r.*, u.name as user_name
                     FROM reviews r 
                     JOIN users u ON r.user_id = u.id 
                     WHERE r.product_id = :product_id 
                     ORDER BY r.created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // Log lỗi và trả về mảng trống
            error_log('Lỗi SQL trong getProductReviews: ' . $e->getMessage());
            return [];
        }
    }
    
    private function getProductImages($product_id)
    {
        // Giả lập lấy ảnh bổ sung của sản phẩm
        // Trong thực tế, bạn sẽ lấy từ bảng product_images
        return [];
    }
    
    private function getRelatedProducts($product_id, $category_id, $limit = 4)
    {
        try {
            $query = "SELECT p.*, c.name as category_name, 
                            (SELECT COUNT(*) FROM reviews r WHERE r.product_id = p.id) as rating_count,
                            (SELECT AVG(rating) FROM reviews r WHERE r.product_id = p.id) as rating
                     FROM product p 
                     LEFT JOIN category c ON p.category_id = c.id 
                     WHERE p.category_id = :category_id 
                     AND p.id != :product_id 
                     AND p.status = 1
                     ORDER BY RAND() 
                     LIMIT :limit";
                     
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $related_products = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            // Xử lý rating cho mỗi sản phẩm
            foreach ($related_products as $product) {
                $product->rating = round($product->rating ?? 0, 1);
                $product->rating_count = (int)$product->rating_count;
            }
            
            return $related_products;
        } catch (PDOException $e) {
            error_log('Lỗi khi lấy sản phẩm liên quan: ' . $e->getMessage());
            return [];
        }
    }
 
    public function add() {
        if (!$this->isAdmin()) {
        echo "Bạn không có quyền truy cập chức năng này!";
        exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
        } 
 
        public function save() {
            if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $image = (isset($_FILES['image']) && $_FILES['image']['error'] == 0)
            ? $this->uploadImage($_FILES['image'])
            : "";
            $result = $this->productModel->addProduct($name, $description, $price,
            
            $category_id, $image);
            
            if (is_array($result)) {
            $errors = $result;
            $categories = (new CategoryModel($this->db))->getCategories();
            include 'app/views/product/add.php';
            } else {
            header('Location: /Product');
            }
            }
            } 
 
            public function edit($id) {
                if (!$this->isAdmin()) {
                echo "Bạn không có quyền truy cập chức năng này!";
                exit;
                }
                $product = $this->productModel->getProductById($id);
                $categories = (new CategoryModel($this->db))->getCategories();
                if ($product) {
                include 'app/views/product/edit.php';
                } else {
                echo "Không thấy sản phẩm.";
                }
                } 
 
                public function update() {
                    if (!$this->isAdmin()) {
                    echo "Bạn không có quyền truy cập chức năng này!";
                    exit;
                }
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category_id = $_POST['category_id'];
                $image = (isset($_FILES['image']) && $_FILES['image']['error'] == 0)
                ? $this->uploadImage($_FILES['image'])
                : $_POST['existing_image'];
                $edit = $this->productModel->updateProduct($id, $name, $description,
                
                $price, $category_id, $image);
                if ($edit) {
                header('Location: /Product');
                } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
                }
                }
                } 
 
                public function delete($id) {
                    if (!$this->isAdmin()) {
                    echo "Bạn không có quyền truy cập chức năng này!";
                    exit;
                    }
                    if ($this->productModel->deleteProduct($id)) {
                    header('Location: /Product');
                    } else {
                    echo "Đã xảy ra lỗi khi xóa sản phẩm.";
                    }
                       
    } 
 
    private function uploadImage($file) 
    { 
        $target_dir = "uploads/"; 
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        } 
     
        $target_file = $target_dir . basename($file["name"]); 
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 
     
        $check = getimagesize($file["tmp_name"]); 
        if ($check === false) { 
            throw new Exception("File không phải là hình ảnh."); 
        } 
     
        if ($file["size"] > 10 * 1024 * 1024) { 
            throw new Exception("Hình ảnh có kích thước quá lớn."); 
        } 
     
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") { 
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF."); 
        } 
     
        if (!move_uploaded_file($file["tmp_name"], $target_file)) { 
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh."); 
        } 
     
        return $target_file; 
    } 
 
    public function checkout() 
    {
        // Lấy giỏ hàng từ session
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        
        // Tính tổng tiền
        $total = $this->calculateCartTotal($cart);
        
        // Nếu giỏ hàng trống, chuyển hướng về trang giỏ hàng
        if (empty($cart)) {
            $_SESSION['error'] = "Giỏ hàng trống.";
            header('Location: /Product/cart');
            exit;
        }
        
        // Kiểm tra số lượng tồn kho
        $inventoryModel = new InventoryModel($this->db);
        foreach ($cart as $product_id => $item) {
            $inventory = $inventoryModel->getProductInventory($product_id);
            if (!$inventory || $inventory->quantity < $item['quantity']) {
                $_SESSION['error'] = "Sản phẩm '" . $item['name'] . "' không đủ số lượng trong kho.";
                header('Location: /Product/cart');
                exit;
            }
        }
        
        // Truyền biến vào view
        include 'app/views/product/Checkout.php';
    }
 
    public function processCheckout() 
    { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name']; 
            $phone = $_POST['phone']; 
            $address = $_POST['address']; 
            $note = isset($_POST['note']) ? $_POST['note'] : '';
            $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'cod';

            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { 
                $_SESSION['error'] = "Giỏ hàng trống.";
                header('Location: /Product/cart');
                exit;
            } 

            // Kiểm tra số lượng tồn kho trước khi xử lý đơn hàng
            $inventoryModel = new InventoryModel($this->db);
            $cart = $_SESSION['cart'];
            
            foreach ($cart as $product_id => $item) {
                $inventory = $inventoryModel->getProductInventory($product_id);
                if (!$inventory || $inventory->quantity < $item['quantity']) {
                    $_SESSION['error'] = "Sản phẩm '" . $item['name'] . "' không đủ số lượng trong kho.";
                    header('Location: /Product/cart');
                    exit;
                }
            }

            $this->db->beginTransaction(); 

            try { 
                // Tạo đơn hàng mới
                $query = "INSERT INTO orders (name, phone, address, note, payment_method) VALUES (:name, :phone, :address, :note, :payment_method)"; 
                $stmt = $this->db->prepare($query); 
                $stmt->bindParam(':name', $name); 
                $stmt->bindParam(':phone', $phone); 
                $stmt->bindParam(':address', $address); 
                $stmt->bindParam(':note', $note);
                $stmt->bindParam(':payment_method', $payment_method);
                $stmt->execute(); 
                $order_id = $this->db->lastInsertId(); 

                // Thêm chi tiết đơn hàng và cập nhật số lượng tồn kho
                foreach ($cart as $product_id => $item) { 
                    // Thêm chi tiết đơn hàng
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)"; 
                    $stmt = $this->db->prepare($query); 
                    $stmt->bindParam(':order_id', $order_id); 
                    $stmt->bindParam(':product_id', $product_id); 
                    $stmt->bindParam(':quantity', $item['quantity']); 
                    $stmt->bindParam(':price', $item['price']); 
                    $stmt->execute(); 

                    // Cập nhật số lượng tồn kho
                    $inventory = $inventoryModel->getProductInventory($product_id);
                    $newQuantity = $inventory->quantity - $item['quantity'];
                    $inventoryModel->updateQuantity($product_id, $newQuantity);
                } 

                unset($_SESSION['cart']); 
                $this->db->commit(); 
                
                $_SESSION['success'] = "Đặt hàng thành công!";
                header('Location: /Product/orderConfirmation'); 
                exit;
            } catch (Exception $e) { 
                $this->db->rollBack(); 
                $_SESSION['error'] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
                header('Location: /Product/cart');
                exit;
            } 
        } 
    } 
 
    public function orderConfirmation() 
    { 
        include 'app/views/product/orderConfirmation.php'; 
    }
    
    public function ajaxUpdateCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $productId = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            
            $result = ['success' => false];
            
            if (isset($_SESSION['cart'][$productId])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                    $subtotal = $quantity * $_SESSION['cart'][$productId]['price'];
                    $total = $this->calculateCartTotal($_SESSION['cart']);
                    
                    $result = [
                        'success' => true,
                        'subtotal' => $subtotal,
                        'total' => $total,
                        'formattedSubtotal' => number_format($subtotal, 0, ',', '.') . ' ₫',
                        'formattedTotal' => number_format($total, 0, ',', '.') . ' ₫'
                    ];
                } else {
                    unset($_SESSION['cart'][$productId]);
                    $total = $this->calculateCartTotal($_SESSION['cart']);
                    $result = [
                        'success' => true,
                        'removed' => true,
                        'total' => $total,
                        'formattedTotal' => number_format($total, 0, ',', '.') . ' ₫'
                    ];
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }

    public function addToCartAjax($id) {
        $product = $this->productModel->getProductById($id);
        $response = ['success' => false, 'message' => 'Có lỗi xảy ra'];
        
        // Lấy số lượng từ query parameter hoặc mặc định là 1
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
        if ($quantity < 1) $quantity = 1;
        
        if ($product) {
            // Kiểm tra số lượng tồn kho
            if (!$this->inventoryModel->checkStock($id, $quantity)) {
                $response = [
                    'success' => false, 
                    'message' => 'Sản phẩm không đủ số lượng trong kho'
                ];
                
                header('Content-Type: application/json');
                echo json_encode($response);
                exit;
            }
            
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                    'category_id' => $product->category_id
                ];
            }
            
            // Cập nhật số lượng tồn kho
            $inventory = $this->inventoryModel->getProductInventory($id);
            $this->inventoryModel->updateQuantity($id, $inventory->quantity - $quantity);
            
            // Tính tổng số lượng sản phẩm trong giỏ hàng
            $totalQuantity = 0;
            foreach ($_SESSION['cart'] as $item) {
                $totalQuantity += $item['quantity'];
            }
            
            $response = [
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cartCount' => $totalQuantity
            ];
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Hàm trả về số lượng sản phẩm trong mỗi danh mục
    public function getCategoryCounts() 
    {
        // Get all categories
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        
        // Add product count to each category
        foreach ($categories as $category) {
            $category->product_count = $this->productModel->getProductCount($category->id);
        }
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'categories' => $categories
        ]);
        exit;
    }

    public function buyNow($id) 
    {
        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        
        // Lấy số lượng từ query parameter
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
        if ($quantity < 1) $quantity = 1;
        
        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Thêm sản phẩm vào giỏ hàng hoặc cập nhật số lượng
        $_SESSION['cart'][$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'image' => $product->image,
            'category_id' => $product->category_id
        ];
        
        // Chuyển hướng đến trang thanh toán
        header('Location: /Product/checkout');
        exit;
    }

    // Thêm hàm mới để kiểm tra và tạo bảng nếu chưa tồn tại
    private function ensureReviewsTableExists() 
    {
        try {
            // Kiểm tra xem bảng 'reviews' đã tồn tại chưa
            $query = "SHOW TABLES LIKE 'reviews'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $tableExists = $stmt->rowCount() > 0;
            
            if (!$tableExists) {
                // Nếu bảng chưa tồn tại, tạo nó
                $createTable = "CREATE TABLE reviews (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    product_id INT(11) NOT NULL,
                    user_id INT(11) NOT NULL,
                    rating INT(1) NOT NULL,
                    content TEXT NOT NULL,
                    images TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id),
                    KEY product_id (product_id),
                    KEY user_id (user_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                
                $this->db->exec($createTable);
                return true;
            }
            
            return $tableExists;
        } catch (PDOException $e) {
            error_log('Lỗi kiểm tra/tạo bảng reviews: ' . $e->getMessage());
            return false;
        }
    }
    
    public function addReview()
    {
        // Tắt hiển thị lỗi PHP và bắt đầu output buffering
        ini_set('display_errors', 0);
        error_reporting(0);
        ob_start();
        
        // Kiểm tra nếu là AJAX request
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
        
        // Kiểm tra và tạo bảng reviews nếu chưa tồn tại
        $this->createReviewsTableIfNotExists();
        
        try {
            // Nếu là AJAX request
            if ($isAjax) {
                // Xóa bất kỳ output buffer nào
                ob_end_clean();
                header('Content-Type: application/json');
                
                // Kiểm tra đăng nhập
                if (!SessionHelper::isLoggedIn()) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Bạn cần đăng nhập để gửi đánh giá.'
                    ]);
                    exit;
                }
                
                // Kiểm tra method
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Phương thức không hợp lệ.'
                    ]);
                    exit;
                }
                
                // Lấy dữ liệu từ form
                $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
                $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
                $content = isset($_POST['content']) ? $_POST['content'] : '';
                $user_id = SessionHelper::getUserId();
                
                // Xử lý tạm thời nếu không có user_id trong session
                if (empty($user_id) && SessionHelper::isLoggedIn()) {
                    // Lấy user_id từ database dựa trên username
                    $user_id = $this->getUserIdByUsername($_SESSION['username']);
                    // Lưu user_id vào session để sử dụng sau này
                    if ($user_id) {
                        $_SESSION['user_id'] = $user_id;
                    }
                }
                
                // Validate
                $errors = [];
                if (empty($product_id)) $errors[] = "Sản phẩm không hợp lệ";
                if ($rating < 1 || $rating > 5) $errors[] = "Đánh giá phải từ 1-5 sao";
                if (empty($content)) $errors[] = "Nội dung đánh giá không được để trống";
                if (empty($user_id)) $errors[] = "Không thể xác định người dùng";
                
                if (!empty($errors)) {
                    echo json_encode([
                        'success' => false,
                        'message' => implode(', ', $errors)
                    ]);
                    exit;
                }
                
                // Kiểm tra user_id có tồn tại trong bảng users không
                $userExists = $this->checkUserExists($user_id);
                if (!$userExists) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'ID người dùng không hợp lệ.'
                    ]);
                    exit;
                }
                
                // Xử lý upload ảnh
                $uploadedImages = [];
                if (isset($_FILES['review_images']) && !empty($_FILES['review_images']['name'][0])) {
                    $upload_dir = 'uploads/reviews/';
                    
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    foreach ($_FILES['review_images']['name'] as $key => $name) {
                        if ($_FILES['review_images']['error'][$key] === 0) {
                            $tmp_name = $_FILES['review_images']['tmp_name'][$key];
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $new_name = uniqid('review_') . '.' . $ext;
                            $target = $upload_dir . $new_name;
                            
                            if (move_uploaded_file($tmp_name, $target)) {
                                $uploadedImages[] = $target;
                            }
                        }
                    }
                }
                
                // Lưu đánh giá vào database
                $images = !empty($uploadedImages) ? implode(',', $uploadedImages) : null;
                
                try {
                    $query = "INSERT INTO reviews (product_id, user_id, rating, content, images) 
                              VALUES (:product_id, :user_id, :rating, :content, :images)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->bindParam(':rating', $rating);
                    $stmt->bindParam(':content', $content);
                    $stmt->bindParam(':images', $images);
                    
                    $stmt->execute();
                    
                    // Cập nhật rating trung bình của sản phẩm
                    $this->updateProductRating($product_id);
                    
                    echo json_encode([
                        'success' => true,
                        'message' => 'Đánh giá của bạn đã được gửi thành công!'
                    ]);
                } catch (PDOException $e) {
                    // Xử lý lỗi PDO riêng biệt
                    if ($e->getCode() == 23000 && strpos($e->getMessage(), 'foreign key constraint') !== false) {
                        // Lỗi ràng buộc khóa ngoại
                        error_log('Lỗi khóa ngoại khi thêm đánh giá: ' . $e->getMessage());
                        echo json_encode([
                            'success' => false,
                            'message' => 'Không thể thêm đánh giá do lỗi ràng buộc dữ liệu. Vui lòng đăng nhập lại và thử lại.'
                        ]);
                    } else {
                        error_log('Lỗi khi thêm đánh giá: ' . $e->getMessage());
                        echo json_encode([
                            'success' => false,
                            'message' => 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại!'
                        ]);
                    }
                }
                exit;
            } else {
                // Xử lý non-AJAX request
                ob_end_clean();
                
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    header('Location: /');
                    exit;
                }
                
                if (!SessionHelper::isLoggedIn()) {
                    header('Location: /User/login');
                    exit;
                }
                
                $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
                $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
                $content = isset($_POST['content']) ? $_POST['content'] : '';
                $user_id = SessionHelper::getUserId();
                
                // Xử lý tạm thời nếu không có user_id trong session
                if (empty($user_id) && SessionHelper::isLoggedIn()) {
                    // Lấy user_id từ database dựa trên username
                    $user_id = $this->getUserIdByUsername($_SESSION['username']);
                    // Lưu user_id vào session để sử dụng sau này
                    if ($user_id) {
                        $_SESSION['user_id'] = $user_id;
                    }
                }
                
                $errors = [];
                if (empty($product_id)) $errors[] = "Sản phẩm không hợp lệ";
                if ($rating < 1 || $rating > 5) $errors[] = "Đánh giá phải từ 1-5 sao";
                if (empty($content)) $errors[] = "Nội dung đánh giá không được để trống";
                if (empty($user_id)) $errors[] = "Không thể xác định người dùng";
                
                if (!empty($errors)) {
                    $_SESSION['review_errors'] = $errors;
                    header('Location: /Product/show/' . $product_id);
                    exit;
                }
                
                // Kiểm tra user_id có tồn tại trong bảng users không
                $userExists = $this->checkUserExists($user_id);
                if (!$userExists) {
                    $_SESSION['review_errors'] = ["ID người dùng không hợp lệ."];
                    header('Location: /Product/show/' . $product_id);
                    exit;
                }
                
                // Xử lý upload ảnh
                $uploadedImages = [];
                if (isset($_FILES['review_images']) && !empty($_FILES['review_images']['name'][0])) {
                    $upload_dir = 'uploads/reviews/';
                    
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    foreach ($_FILES['review_images']['name'] as $key => $name) {
                        if ($_FILES['review_images']['error'][$key] === 0) {
                            $tmp_name = $_FILES['review_images']['tmp_name'][$key];
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $new_name = uniqid('review_') . '.' . $ext;
                            $target = $upload_dir . $new_name;
                            
                            if (move_uploaded_file($tmp_name, $target)) {
                                $uploadedImages[] = $target;
                            }
                        }
                    }
                }
                
                // Lưu đánh giá vào database
                $images = !empty($uploadedImages) ? implode(',', $uploadedImages) : null;
                
                try {
                    $query = "INSERT INTO reviews (product_id, user_id, rating, content, images) 
                              VALUES (:product_id, :user_id, :rating, :content, :images)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->bindParam(':rating', $rating);
                    $stmt->bindParam(':content', $content);
                    $stmt->bindParam(':images', $images);
                    
                    if ($stmt->execute()) {
                        // Cập nhật rating trung bình của sản phẩm
                        $this->updateProductRating($product_id);
                        
                        $_SESSION['review_result'] = [
                            'success' => true,
                            'message' => 'Đánh giá của bạn đã được gửi thành công!'
                        ];
                    } else {
                        $_SESSION['review_result'] = [
                            'success' => false,
                            'message' => 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại!'
                        ];
                    }
                } catch (PDOException $e) {
                    // Xử lý lỗi PDO riêng biệt
                    if ($e->getCode() == 23000 && strpos($e->getMessage(), 'foreign key constraint') !== false) {
                        // Lỗi ràng buộc khóa ngoại
                        error_log('Lỗi khóa ngoại khi thêm đánh giá: ' . $e->getMessage());
                        $_SESSION['review_errors'] = ["Không thể thêm đánh giá do lỗi ràng buộc dữ liệu. Vui lòng đăng nhập lại và thử lại."];
                    } else {
                        error_log('Lỗi khi thêm đánh giá: ' . $e->getMessage());
                        $_SESSION['review_errors'] = [$e->getMessage()];
                    }
                }
                
                header('Location: /Product/show/' . $product_id);
                exit;
            }
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            if ($isAjax) {
                ob_end_clean();
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
                ]);
            } else {
                $_SESSION['review_errors'] = [$e->getMessage()];
                header('Location: /Product/show/' . ($product_id ?? 0));
            }
            exit;
        }
    }
    
    // Hàm kiểm tra sự tồn tại của người dùng
    private function checkUserExists($user_id) {
        try {
            $query = "SELECT 1 FROM users WHERE id = :user_id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Lỗi kiểm tra user: ' . $e->getMessage());
            return false;
        }
    }
    
    // Hàm riêng biệt để kiểm tra và tạo bảng reviews
    private function createReviewsTableIfNotExists() 
    {
        try {
            $query = "CREATE TABLE IF NOT EXISTS reviews (
                id INT(11) NOT NULL AUTO_INCREMENT,
                product_id INT(11) NOT NULL,
                user_id INT(11) NOT NULL,
                rating INT(1) NOT NULL,
                content TEXT NOT NULL,
                images TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                KEY product_id (product_id),
                KEY user_id (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            
            $this->db->exec($query);
            return true;
        } catch (PDOException $e) {
            error_log('Lỗi tạo bảng reviews: ' . $e->getMessage());
            return false;
        }
    }
    
    private function updateProductRating($product_id)
    {
        // Lấy điểm đánh giá trung bình của sản phẩm
        $query = "SELECT AVG(rating) as avg_rating, COUNT(id) as count 
                  FROM reviews 
                  WHERE product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($result) {
            $avg_rating = round($result->avg_rating, 1);
            $count = $result->count;
            
            // Cập nhật rating trong bảng product
            $updateQuery = "UPDATE product 
                           SET rating = :rating, rating_count = :count 
                           WHERE id = :product_id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':rating', $avg_rating);
            $updateStmt->bindParam(':count', $count);
            $updateStmt->bindParam(':product_id', $product_id);
            $updateStmt->execute();
        }
    }

    // Hàm lấy user_id từ username
    private function getUserIdByUsername($username) {
        try {
            $query = "SELECT id FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result->id : 0;
        } catch (PDOException $e) {
            error_log('Lỗi khi lấy user_id từ username: ' . $e->getMessage());
            return 0;
        }
    }
}
?>
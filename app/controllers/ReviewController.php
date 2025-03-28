<?php
require_once('app/config/database.php');
require_once('app/models/ReviewModel.php');
require_once('app/helpers/SessionHelper.php');
require_once('app/controllers/Controller.php');

class ReviewController extends Controller
{
    private $reviewModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->reviewModel = new ReviewModel($this->db);
    }
    
    // Hiển thị trang tổng hợp tất cả đánh giá
    public function index()
    {
        // Lấy tham số phân trang
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $per_page = 12;
        
        // Lấy danh sách đánh giá
        $reviews = $this->reviewModel->getAllReviews($page, $per_page);
        $total_reviews = $this->reviewModel->getTotalReviews();
        
        // Lấy phân phối đánh giá theo số sao
        $rating_distribution = $this->reviewModel->getRatingDistribution();
        
        // Lấy sản phẩm có đánh giá cao nhất
        $top_rated_products = $this->reviewModel->getTopRatedProducts(5);
        
        // Tính toán thông tin phân trang
        $total_pages = ceil($total_reviews / $per_page);
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $per_page,
            'total' => $total_reviews
        ];
        
        // Render view
        require_once 'app/views/review/index.php';
    }
    
    // Hiển thị đánh giá của người dùng hiện tại
    public function user()
    {
        // Kiểm tra đăng nhập
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /account/login');
            exit;
        }
        
        // Lấy ID người dùng hiện tại
        $user_id = $_SESSION['user_id'];
        
        // Lấy tham số phân trang
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $per_page = 10;
        
        // Lấy danh sách đánh giá của người dùng
        $reviews = $this->reviewModel->getReviewsByUserId($user_id, $page, $per_page);
        $total_reviews = $this->reviewModel->getTotalReviewsByUserId($user_id);
        
        // Tính toán thông tin phân trang
        $total_pages = ceil($total_reviews / $per_page);
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $per_page,
            'total' => $total_reviews
        ];
        
        // Render view
        require_once 'app/views/review/user.php';
    }
    
    // Hiển thị đánh giá của một sản phẩm
    public function product($product_id)
    {
        // Lấy tham số phân trang
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $per_page = 10;
        
        // Lấy danh sách đánh giá của sản phẩm
        $reviews = $this->reviewModel->getReviewsByProductId($product_id, $page, $per_page);
        $total_reviews = $this->reviewModel->getTotalReviewsByProductId($product_id);
        
        // Tính toán thông tin phân trang
        $total_pages = ceil($total_reviews / $per_page);
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'per_page' => $per_page,
            'total' => $total_reviews
        ];
        
        // Lấy thông tin sản phẩm
        require_once 'app/models/ProductModel.php';
        $productModel = new ProductModel($this->db);
        $product = $productModel->getProductById($product_id);
        
        // Render view
        require_once 'app/views/review/product.php';
    }
}
?> 
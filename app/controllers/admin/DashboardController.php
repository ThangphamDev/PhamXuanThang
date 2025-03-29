<?php
require_once 'app/controllers/admin/BaseController.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/AccountModel.php';

class DashboardController extends BaseController
{
    protected $orderModel;
    protected $productModel;
    protected $accountModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->accountModel = new AccountModel($this->db);
    }
    
    // Hiển thị trang Dashboard
    public function index()
    {
        // Lấy tổng doanh thu
        $totalRevenue = $this->orderModel->getTotalRevenue();
        
        // Lấy doanh thu theo tháng trong năm hiện tại
        $currentYear = date('Y');
        $monthlyRevenue = $this->orderModel->getMonthlyRevenue($currentYear);
        
        // Lấy số lượng đơn hàng theo trạng thái
        $orderStatuses = $this->orderModel->getOrderCountsByStatus();
        
        // Lấy tổng số người dùng
        $totalUsers = $this->accountModel->countTotalUsers();
        
        // Lấy sản phẩm bán chạy nhất
        $topProducts = $this->orderModel->getTopSellingProducts(5);
        
        // Nếu không có dữ liệu sản phẩm bán chạy, tạo mảng trống
        if (empty($topProducts)) {
            $topProducts = [];
        }
        
        // Đảm bảo mỗi sản phẩm có thuộc tính quantity_sold và total_revenue
        foreach ($topProducts as $product) {
            if (!isset($product->quantity_sold)) {
                $product->quantity_sold = $product->total_quantity ?? 0;
            }
            if (!isset($product->total_revenue)) {
                $product->total_revenue = 0;
            }
        }
        
        // Lấy đơn hàng mới nhất
        $recentOrders = $this->orderModel->getAllOrders(0, 5);
        
        // Hiển thị view
        $this->view('admin/dashboard', [
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'orderStatuses' => $orderStatuses,
            'totalUsers' => $totalUsers,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
            'currentYear' => $currentYear
        ]);
    }
} 
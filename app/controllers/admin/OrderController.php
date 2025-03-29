<?php
class OrderController extends BaseController
{
    private $orderModel;
    private $userModel;
    private $productModel;
    private $itemsPerPage = 10;

    public function __construct()
    {
        if (!$this->isAdmin()) {
            header('Location: /account/login');
            exit;
        }
        
        $this->orderModel = $this->model('OrderModel');
        $this->userModel = $this->model('UserModel');
        $this->productModel = $this->model('ProductModel');
    }
    
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        $offset = ($page - 1) * $this->itemsPerPage;
        
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $status = isset($_GET['status']) ? trim($_GET['status']) : '';
        
        // Lấy tổng số đơn hàng
        $totalOrders = $this->orderModel->countOrders($search, $status);
        $totalPages = ceil($totalOrders / $this->itemsPerPage);
        
        // Lấy danh sách đơn hàng
        $orders = $this->orderModel->getAllOrders($offset, $this->itemsPerPage, $search, $status);
        
        // Đếm số đơn hàng theo trạng thái
        $counts = [
            'pending' => $this->orderModel->countOrdersByStatus('pending'),
            'processing' => $this->orderModel->countOrdersByStatus('processing'),
            'shipping' => $this->orderModel->countOrdersByStatus('shipping'),
            'completed' => $this->orderModel->countOrdersByStatus('completed'),
            'cancelled' => $this->orderModel->countOrdersByStatus('cancelled')
        ];
        
        // Thiết lập dữ liệu phân trang
        $pagination = new stdClass();
        $pagination->current_page = $page;
        $pagination->total_pages = $totalPages;
        
        // Xây dựng query string cho phân trang
        $queryArray = [];
        if (!empty($search)) $queryArray[] = "search=" . urlencode($search);
        if (!empty($status)) $queryArray[] = "status=" . urlencode($status);
        $pagination->query_string = implode('&', $queryArray);
        
        // Hiển thị view
        $this->view('admin/orders', [
            'orders' => $orders,
            'pagination' => $pagination,
            'counts' => $counts
        ]);
    }
    
    // Xem chi tiết đơn hàng
    public function view($id)
    {
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại!";
            header('Location: /admin/orders');
            exit;
        }
        
        // Lấy thông tin chi tiết đơn hàng
        $orderItems = $this->orderModel->getOrderItems($id);
        
        // Lấy thông tin người dùng
        $user = null;
        if (!empty($order->user_id)) {
            $user = $this->userModel->getUserById($order->user_id);
        }
        
        // Hiển thị view
        $this->view('admin/orderDetail', [
            'order' => $order,
            'orderItems' => $orderItems,
            'user' => $user
        ]);
    }
    
    // Cập nhật trạng thái đơn hàng
    public function updateStatus($id, $status)
    {
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại!";
            header('Location: /admin/orders');
            exit;
        }
        
        // Kiểm tra trạng thái hợp lệ
        $validStatuses = ['pending', 'processing', 'shipping', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            $_SESSION['error'] = "Trạng thái không hợp lệ!";
            header('Location: /admin/orders/view/' . $id);
            exit;
        }
        
        // Không cho phép cập nhật lại trạng thái đã hủy hoặc hoàn thành
        if ($order->status == 'cancelled' || $order->status == 'completed') {
            $_SESSION['error'] = "Không thể thay đổi trạng thái của đơn hàng đã " . ($order->status == 'cancelled' ? 'hủy' : 'hoàn thành') . "!";
            header('Location: /admin/orders/view/' . $id);
            exit;
        }
        
        // Chuẩn bị dữ liệu cập nhật
        $updateData = [
            'status' => $status
        ];
        
        // Cập nhật thời gian tương ứng với trạng thái
        switch ($status) {
            case 'processing':
                $updateData['processing_time'] = date('Y-m-d H:i:s');
                break;
            case 'shipping':
                $updateData['shipping_time'] = date('Y-m-d H:i:s');
                break;
            case 'completed':
                $updateData['completed_time'] = date('Y-m-d H:i:s');
                break;
            case 'cancelled':
                $updateData['cancelled_time'] = date('Y-m-d H:i:s');
                break;
        }
        
        // Cập nhật trạng thái đơn hàng
        $updated = $this->orderModel->updateOrder($id, $updateData);
        
        if ($updated) {
            $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
        }
        
        header('Location: /admin/orders/view/' . $id);
        exit;
    }
    
    // In đơn hàng
    public function print($id)
    {
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại!";
            header('Location: /admin/orders');
            exit;
        }
        
        // Lấy thông tin chi tiết đơn hàng
        $orderItems = $this->orderModel->getOrderItems($id);
        
        // Lấy thông tin người dùng
        $user = null;
        if (!empty($order->user_id)) {
            $user = $this->userModel->getUserById($order->user_id);
        }
        
        // Hiển thị view
        $this->view('admin/orderPrint', [
            'order' => $order,
            'orderItems' => $orderItems,
            'user' => $user
        ]);
    }
    
    // Thống kê đơn hàng
    public function statistics()
    {
        // Lấy tổng doanh thu
        $totalRevenue = $this->orderModel->getTotalRevenue();
        
        // Lấy doanh thu theo tháng trong năm hiện tại
        $currentYear = date('Y');
        $monthlyRevenue = $this->orderModel->getMonthlyRevenue($currentYear);
        
        // Lấy số lượng đơn hàng theo trạng thái
        $orderStatuses = $this->orderModel->getOrderCountsByStatus();
        
        // Lấy 10 sản phẩm bán chạy nhất
        $topProducts = $this->orderModel->getTopSellingProducts(10);
        
        // Hiển thị view
        $this->view('admin/orderStatistics', [
            'totalRevenue' => $totalRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'orderStatuses' => $orderStatuses,
            'topProducts' => $topProducts,
            'currentYear' => $currentYear
        ]);
    }
    
    // Kiểm tra quyền Admin
    private function isAdmin()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
} 
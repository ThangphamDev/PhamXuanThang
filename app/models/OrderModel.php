<?php
class OrderModel
{
    private $conn;

    public function __construct($db = null)
    {
        if ($db) {
            $this->conn = $db;
        } else {
            $database = new Database();
            $this->conn = $database->getConnection();
        }
    }

    // Lấy tất cả đơn hàng của người dùng
    public function getOrdersByUserId($user_id)
    {
        $query = "
            SELECT o.*, 
                  (SELECT COUNT(*) FROM order_details WHERE order_id = o.id) as item_count,
                  (SELECT SUM(price * quantity) FROM order_details WHERE order_id = o.id) as total_amount
            FROM orders o
            WHERE o.user_id = :user_id
            ORDER BY o.created_at DESC
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy chi tiết đơn hàng theo ID và tuỳ chọn user_id
    public function getOrderById($order_id, $user_id = null)
    {
        $sql = "SELECT * FROM orders WHERE id = :order_id";
        if ($user_id !== null) {
            $sql .= " AND user_id = :user_id";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        
        if ($user_id !== null) {
            $stmt->bindParam(':user_id', $user_id);
        }
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Lấy các sản phẩm trong đơn hàng
    public function getOrderItems($order_id)
    {
        $query = "
            SELECT od.*, p.name, p.image
            FROM order_details od
            LEFT JOIN product p ON od.product_id = p.id
            WHERE od.order_id = :order_id
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Tạo đơn hàng mới
    public function createOrder($user_id, $name, $phone, $address, $note, $payment_method, $status = 'pending')
    {
        $query = "
            INSERT INTO orders (user_id, name, phone, address, note, payment_method, status)
            VALUES (:user_id, :name, :phone, :address, :note, :payment_method, :status)
        ";
        
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $phone = htmlspecialchars(strip_tags($phone));
        $address = htmlspecialchars(strip_tags($address));
        $note = htmlspecialchars(strip_tags($note));
        $payment_method = htmlspecialchars(strip_tags($payment_method));
        
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    // Thêm sản phẩm vào đơn hàng
    public function addOrderItem($order_id, $product_id, $price, $quantity)
    {
        // Kiểm tra số lượng trong kho
        $query = "SELECT quantity FROM inventory WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $inventory = $stmt->fetch(PDO::FETCH_OBJ);
        
        if (!$inventory || $inventory->quantity < $quantity) {
            return false; // Không đủ hàng trong kho
        }
        
        $query = "
            INSERT INTO order_details (order_id, product_id, quantity, price)
            VALUES (:order_id, :product_id, :quantity, :price)
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        
        return $stmt->execute();
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($order_id, $status)
    {
        $validStatuses = ['pending', 'processing', 'shipping', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }
        
        $updateData = ['status' => $status];
        
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
        
        return $this->updateOrder($order_id, $updateData);
    }

    // Cập nhật thông tin đơn hàng
    public function updateOrder($order_id, $data)
    {
        if (empty($data)) {
            return false;
        }
        
        $updateFields = [];
        $params = [];
        
        foreach ($data as $key => $value) {
            $updateFields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        
        $query = "
            UPDATE orders
            SET " . implode(', ', $updateFields) . "
            WHERE id = :order_id
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        return $stmt->execute();
    }

    // Tính tổng tiền của đơn hàng
    public function calculateOrderTotal($order_id)
    {
        $query = "
            SELECT SUM(price * quantity) as total
            FROM order_details
            WHERE order_id = :order_id
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total ?? 0;
    }

    // Đếm số đơn hàng của người dùng
    public function countUserOrders($user_id)
    {
        $query = "SELECT COUNT(*) as count FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count ?? 0;
    }
    
    // Lấy tất cả các đơn hàng cho trang Admin
    public function getAllOrders($offset = 0, $limit = 10, $search = '', $status = '')
    {
        $sql = "
            SELECT o.*, 
                  (SELECT COUNT(*) FROM order_details WHERE order_id = o.id) as item_count,
                  (SELECT SUM(price * quantity) FROM order_details WHERE order_id = o.id) as total_amount
            FROM orders o
            WHERE 1=1
        ";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (o.id LIKE :search OR o.name LIKE :search OR o.phone LIKE :search OR o.address LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
        
        if (!empty($status)) {
            $sql .= " AND o.status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY o.created_at DESC LIMIT :offset, :limit";
        
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Đếm tổng số đơn hàng (có thể lọc)
    public function countOrders($search = '', $status = '')
    {
        $sql = "SELECT COUNT(*) as count FROM orders WHERE 1=1";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (id LIKE :search OR name LIKE :search OR phone LIKE :search OR address LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }
        
        if (!empty($status)) {
            $sql .= " AND status = :status";
            $params[':status'] = $status;
        }
        
        $stmt = $this->conn->prepare($sql);
        
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count ?? 0;
    }
    
    // Đếm số đơn hàng theo trạng thái
    public function countOrdersByStatus($status)
    {
        $query = "SELECT COUNT(*) as count FROM orders WHERE status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->count ?? 0;
    }
    
    // Lấy tổng doanh thu
    public function getTotalRevenue()
    {
        $query = "
            SELECT SUM(od.price * od.quantity) as total_revenue
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            WHERE o.status = 'completed'
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total_revenue ?? 0;
    }
    
    // Lấy doanh thu theo tháng trong năm
    public function getMonthlyRevenue($year)
    {
        $query = "
            SELECT 
                MONTH(o.created_at) as month,
                SUM(od.price * od.quantity) as revenue
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            WHERE o.status = 'completed'
            AND YEAR(o.created_at) = :year
            GROUP BY MONTH(o.created_at)
            ORDER BY MONTH(o.created_at)
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        // Khởi tạo mảng cho 12 tháng
        $monthlyData = array_fill(1, 12, 0);
        
        // Điền dữ liệu từ kết quả truy vấn
        foreach ($results as $row) {
            $monthlyData[(int)$row->month] = (float)$row->revenue;
        }
        
        return $monthlyData;
    }
    
    // Lấy số lượng đơn hàng theo trạng thái
    public function getOrderCountsByStatus()
    {
        $query = "
            SELECT 
                status,
                COUNT(*) as count
            FROM orders
            GROUP BY status
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        // Khởi tạo mảng cho các trạng thái
        $statusCounts = [
            'pending' => 0,
            'processing' => 0,
            'shipping' => 0,
            'completed' => 0,
            'cancelled' => 0
        ];
        
        // Điền dữ liệu từ kết quả truy vấn
        foreach ($results as $row) {
            if (isset($statusCounts[$row->status])) {
                $statusCounts[$row->status] = (int)$row->count;
            }
        }
        
        return $statusCounts;
    }
    
    // Lấy top sản phẩm bán chạy
    public function getTopSellingProducts($limit = 10)
    {
        $query = "
            SELECT 
                od.product_id,
                p.name,
                p.image,
                SUM(od.quantity) as total_quantity,
                SUM(od.price * od.quantity) as total_revenue
            FROM order_details od
            JOIN product p ON od.product_id = p.id
            JOIN orders o ON od.order_id = o.id
            WHERE o.status = 'completed'
            GROUP BY od.product_id, p.name, p.image
            ORDER BY total_quantity DESC
            LIMIT :limit
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Lấy danh sách đơn hàng đang chờ phê duyệt
    public function getPendingOrders($limit = 5)
    {
        $query = "
            SELECT o.*, 
                  (SELECT COUNT(*) FROM order_details WHERE order_id = o.id) as item_count,
                  (SELECT SUM(price * quantity) FROM order_details WHERE order_id = o.id) as total_amount
            FROM orders o
            WHERE o.status = 'pending'
            ORDER BY o.created_at DESC
            LIMIT :limit
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
} 
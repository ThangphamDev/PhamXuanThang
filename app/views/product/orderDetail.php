<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5 order-detail-page">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card account-sidebar">
                <div class="card-body">
                    <div class="user-profile-header text-center mb-4">
                        <div class="profile-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h4 class="mt-2"><?php echo htmlspecialchars($_SESSION['username']); ?></h4>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <span class="badge bg-success role-badge">Quản trị viên</span>
                        <?php else: ?>
                            <span class="badge bg-info role-badge">Thành viên</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="account-menu">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="/account/profile">
                                    <i class="fas fa-user-alt"></i> Thông tin tài khoản
                                </a>
                            </li>
                            <li class="list-group-item active">
                                <a href="/Product/myOrders">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/Product/wishlist">
                                    <i class="fas fa-heart"></i> Sản phẩm yêu thích
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/Product/cart">
                                    <i class="fas fa-shopping-cart"></i> Giỏ hàng của tôi
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/account/logout" class="text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="order-detail-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Chi tiết đơn hàng #<?php echo $order->id; ?></h4>
                        <p class="text-muted mb-0">Đặt ngày <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
                    </div>
                    <div>
                        <?php 
                            $status_class = '';
                            $status_text = '';
                            
                            switch ($order->status) {
                                case 'pending':
                                    $status_class = 'bg-warning';
                                    $status_text = 'Chờ xác nhận';
                                    break;
                                case 'processing':
                                    $status_class = 'bg-info';
                                    $status_text = 'Đang xử lý';
                                    break;
                                case 'shipping':
                                    $status_class = 'bg-primary';
                                    $status_text = 'Đang giao hàng';
                                    break;
                                case 'completed':
                                    $status_class = 'bg-success';
                                    $status_text = 'Hoàn thành';
                                    break;
                                case 'cancelled':
                                    $status_class = 'bg-danger';
                                    $status_text = 'Đã hủy';
                                    break;
                                default:
                                    $status_class = 'bg-secondary';
                                    $status_text = 'Không xác định';
                            }
                        ?>
                        <span class="badge <?php echo $status_class; ?> status-badge"><?php echo $status_text; ?></span>
                    </div>
                </div>
                
                <div class="mt-3 d-flex">
                    <a href="/Product/myOrders" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <?php if ($order->status == 'pending' || $order->status == 'processing'): ?>
                        <a href="/Product/cancelOrder/<?php echo $order->id; ?>" class="btn btn-outline-danger btn-sm ms-2" 
                           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                            <i class="fas fa-times"></i> Hủy đơn hàng
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin nhận hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Họ tên:</strong> <?php echo htmlspecialchars($order->name); ?></p>
                            <p class="mb-2"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order->phone); ?></p>
                            <p class="mb-2"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order->address); ?></p>
                            <?php if (!empty($order->note)): ?>
                                <p class="mb-0"><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order->note); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Thông tin thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Phương thức:</strong> <?php echo htmlspecialchars($order->payment_method); ?></p>
                            
                            <?php if ($order->payment_method == 'cod'): ?>
                                <p class="mb-2"><strong>Trạng thái:</strong> 
                                    <?php if ($order->status == 'completed'): ?>
                                        <span class="text-success">Đã thanh toán</span>
                                    <?php else: ?>
                                        <span class="text-warning">Chưa thanh toán</span>
                                    <?php endif; ?>
                                </p>
                            <?php else: ?>
                                <p class="mb-2"><strong>Trạng thái:</strong> <span class="text-success">Đã thanh toán</span></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($order->payment_id)): ?>
                                <p class="mb-0"><strong>Mã giao dịch:</strong> <?php echo htmlspecialchars($order->payment_id); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table order-items-table mb-0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Giá</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $totalAmount = 0; 
                                foreach ($orderItems as $item): 
                                    $itemTotal = $item->price * $item->quantity;
                                    $totalAmount += $itemTotal;
                                ?>
                                <tr>
                                    <td class="product-cell">
                                        <div class="d-flex">
                                            <div class="product-image">
                                                <?php if (!empty($item->image)): ?>
                                                    <img src="/<?php echo htmlspecialchars($item->image); ?>" alt="<?php echo htmlspecialchars($item->name); ?>">
                                                <?php else: ?>
                                                    <div class="no-image">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="product-info">
                                                <h6 class="product-name">
                                                    <a href="/Product/show/<?php echo $item->product_id; ?>"><?php echo htmlspecialchars($item->name); ?></a>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center"><?php echo number_format($item->price, 0, ',', '.'); ?>₫</td>
                                    <td class="text-center"><?php echo $item->quantity; ?></td>
                                    <td class="text-end"><?php echo number_format($itemTotal, 0, ',', '.'); ?>₫</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tổng tiền sản phẩm:</strong></td>
                                    <td class="text-end"><?php echo number_format($totalAmount, 0, ',', '.'); ?>₫</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                    <td class="text-end"><?php echo number_format($order->shipping_fee ?? 0, 0, ',', '.'); ?>₫</td>
                                </tr>
                                <?php if (!empty($order->discount) && $order->discount > 0): ?>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Giảm giá:</strong></td>
                                    <td class="text-end text-danger">-<?php echo number_format($order->discount, 0, ',', '.'); ?>₫</td>
                                </tr>
                                <?php endif; ?>
                                <tr class="total-row">
                                    <td colspan="3" class="text-end"><strong>Tổng thanh toán:</strong></td>
                                    <td class="text-end total-amount">
                                        <?php 
                                        $finalTotal = $totalAmount + ($order->shipping_fee ?? 0) - ($order->discount ?? 0);
                                        echo number_format($finalTotal, 0, ',', '.'); 
                                        ?>₫
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="order-timeline mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Trạng thái đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item active">
                                <div class="timeline-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Đơn hàng đã đặt</h6>
                                    <p class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
                                </div>
                            </div>
                            
                            <div class="timeline-item <?php echo in_array($order->status, ['processing', 'shipping', 'completed']) ? 'active' : ''; ?>">
                                <div class="timeline-icon">
                                    <?php if (in_array($order->status, ['processing', 'shipping', 'completed'])): ?>
                                        <i class="fas fa-check"></i>
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="timeline-content">
                                    <h6>Đang xử lý</h6>
                                    <?php if (in_array($order->status, ['processing', 'shipping', 'completed']) && !empty($order->processing_time)): ?>
                                        <p class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($order->processing_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="timeline-item <?php echo in_array($order->status, ['shipping', 'completed']) ? 'active' : ''; ?>">
                                <div class="timeline-icon">
                                    <?php if (in_array($order->status, ['shipping', 'completed'])): ?>
                                        <i class="fas fa-check"></i>
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="timeline-content">
                                    <h6>Đang giao hàng</h6>
                                    <?php if (in_array($order->status, ['shipping', 'completed']) && !empty($order->shipping_time)): ?>
                                        <p class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($order->shipping_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="timeline-item <?php echo $order->status == 'completed' ? 'active' : ''; ?>">
                                <div class="timeline-icon">
                                    <?php if ($order->status == 'completed'): ?>
                                        <i class="fas fa-check"></i>
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="timeline-content">
                                    <h6>Đã giao hàng</h6>
                                    <?php if ($order->status == 'completed' && !empty($order->completed_time)): ?>
                                        <p class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($order->completed_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if ($order->status == 'cancelled'): ?>
                            <div class="timeline-item cancelled active">
                                <div class="timeline-icon">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Đơn hàng đã hủy</h6>
                                    <?php if (!empty($order->cancelled_time)): ?>
                                        <p class="timeline-date"><?php echo date('d/m/Y H:i', strtotime($order->cancelled_time)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-detail-page {
    margin-top: 2rem;
    margin-bottom: 4rem;
}

.account-sidebar {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: none;
    overflow: hidden;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #e9ecef;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-avatar i {
    font-size: 60px;
    color: #6c757d;
}

.role-badge {
    font-size: 0.7rem;
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.account-menu .list-group-item {
    border: none;
    padding: 0.75rem 1rem;
    background: transparent;
    transition: all 0.2s ease;
}

.account-menu .list-group-item:hover {
    background-color: rgba(67, 160, 71, 0.1);
}

.account-menu .list-group-item.active {
    background-color: rgba(67, 160, 71, 0.2);
    color: var(--primary-dark);
    font-weight: 500;
}

.account-menu .list-group-item a {
    color: var(--text-dark);
    text-decoration: none;
    display: block;
}

.account-menu .list-group-item.active a {
    color: var(--primary-dark);
}

.account-menu .list-group-item a i {
    margin-right: 8px;
    width: 20px;
    text-align: center;
    color: var(--primary-color);
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 1.25rem;
}

.status-badge {
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
}

.order-items-table {
    margin-bottom: 0;
}

.order-items-table th,
.order-items-table td {
    padding: 1rem;
    vertical-align: middle;
}

.product-cell {
    min-width: 300px;
}

.product-image {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background-color: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image i {
    color: #ccc;
    font-size: 1.2rem;
}

.product-info {
    flex: 1;
}

.product-name {
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.product-name a {
    color: var(--text-dark);
    text-decoration: none;
}

.product-name a:hover {
    color: var(--primary-color);
}

.total-row {
    font-weight: 600;
}

.total-amount {
    font-size: 1.1rem;
    color: var(--primary-color);
}

/* Timeline styles */
.timeline {
    position: relative;
    padding-left: 50px;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 20px;
    height: 100%;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: -50px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e9ecef;
    color: #adb5bd;
    z-index: 1;
}

.timeline-item.active .timeline-icon {
    background-color: var(--primary-color);
    color: white;
}

.timeline-item.cancelled .timeline-icon {
    background-color: #dc3545;
    color: white;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-date {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 0;
}

@media (max-width: 992px) {
    .order-detail-page {
        margin-top: 1rem;
    }
    
    .product-cell {
        min-width: 220px;
    }
}

@media (max-width: 767px) {
    .timeline {
        padding-left: 40px;
    }
    
    .timeline-icon {
        left: -40px;
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .order-items-table {
        min-width: 600px;
    }
}
</style>

<?php include 'app/views/shares/footer.php'; ?> 
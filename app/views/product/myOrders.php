<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5 orders-page">
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Đơn hàng của tôi</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['order_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['order_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['order_message']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['order_error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['order_error']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['order_error']); ?>
                    <?php endif; ?>

                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <div class="empty-orders-icon mb-3">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h4>Bạn chưa có đơn hàng nào</h4>
                            <p class="text-muted">Hãy khám phá các sản phẩm và đặt hàng ngay!</p>
                            <a href="/Product" class="btn btn-primary mt-3">
                                <i class="fas fa-shopping-cart"></i> Mua sắm ngay
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover order-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ngày đặt</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr class="order-row">
                                            <td class="order-id">#<?php echo $order->id; ?></td>
                                            <td class="order-date">
                                                <?php echo date('d/m/Y', strtotime($order->created_at)); ?>
                                                <div class="small text-muted">
                                                    <?php echo date('H:i', strtotime($order->created_at)); ?>
                                                </div>
                                            </td>
                                            <td class="order-quantity">
                                                <?php echo $order->item_count; ?> sản phẩm
                                            </td>
                                            <td class="order-amount">
                                                <?php echo number_format($order->total_amount, 0, ',', '.'); ?>₫
                                            </td>
                                            <td class="order-status">
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
                                                <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                            </td>
                                            <td class="order-actions">
                                                <div class="action-buttons">
                                                    <a href="/Product/orderDetail/<?php echo $order->id; ?>" class="btn btn-sm btn-outline-primary view-btn" title="Xem chi tiết">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <?php if ($order->status == 'pending' || $order->status == 'processing'): ?>
                                                        <a href="/Product/cancelOrder/<?php echo $order->id; ?>" class="btn btn-sm btn-outline-danger cancel-btn" 
                                                           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');" title="Hủy đơn hàng">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.orders-page {
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

.order-table {
    margin-bottom: 0;
}

.order-table th {
    font-weight: 600;
    color: var(--text-dark);
    border-top: none;
    padding: 0.75rem 1rem;
}

.order-row {
    transition: all 0.2s ease;
}

.order-row:hover {
    background-color: rgba(67, 160, 71, 0.05);
}

.order-id {
    font-weight: 600;
    color: var(--primary-dark);
}

.order-date, .order-amount, .order-quantity {
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.view-btn, .cancel-btn {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.empty-orders-icon {
    font-size: 3rem;
    color: #d5d5d5;
}

@media (max-width: 992px) {
    .orders-page {
        margin-top: 1rem;
    }
    
    .order-table {
        min-width: 650px;
    }
}
</style>

<?php include 'app/views/shares/footer.php'; ?> 
<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Thông tin tài khoản</h3>
                    <a href="/admin/orders" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h5 class="text-muted">Tên đăng nhập</h5>
                                            <p class="lead"><?php echo htmlspecialchars($account->username); ?></p>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <h5 class="text-muted">Họ và tên</h5>
                                            <p class="lead"><?php echo htmlspecialchars($account->name); ?></p>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <h5 class="text-muted">Vai trò</h5>
                                            <p class="lead">
                                                <?php if ($account->role === 'admin'): ?>
                                                    <span class="badge badge-success">Quản trị viên</span>
                                                <?php else: ?>
                                                    <span class="badge badge-info">Thành viên</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <h5 class="text-muted">Ngày đăng ký</h5>
                                            <p class="lead">
                                                <?php echo isset($account->created_at) ? date('d/m/Y', strtotime($account->created_at)) : 'N/A'; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="avatar mb-3">
                                        <i class="fas fa-user-circle fa-6x text-secondary"></i>
                                    </div>
                                    <h4><?php echo htmlspecialchars($account->name); ?></h4>
                                    <p class="text-muted"><?php echo htmlspecialchars($account->username); ?></p>
                                    
                                    <?php if (isset($account->email)): ?>
                                        <p><i class="fas fa-envelope mr-2"></i> <?php echo htmlspecialchars($account->email); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3">Đơn hàng gần đây</h4>
                            <?php
                            // Kiểm tra và hiển thị đơn hàng của người dùng nếu có
                            if (isset($orders) && !empty($orders)):
                            ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td>#<?php echo $order->id; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($order->created_at)); ?></td>
                                                    <td><?php echo number_format($order->total_amount, 0, ',', '.'); ?>₫</td>
                                                    <td>
                                                        <?php
                                                        switch ($order->status) {
                                                            case 'pending':
                                                                echo '<span class="badge badge-warning">Chờ xác nhận</span>';
                                                                break;
                                                            case 'processing':
                                                                echo '<span class="badge badge-info">Đang xử lý</span>';
                                                                break;
                                                            case 'shipping':
                                                                echo '<span class="badge badge-primary">Đang giao</span>';
                                                                break;
                                                            case 'completed':
                                                                echo '<span class="badge badge-success">Hoàn thành</span>';
                                                                break;
                                                            case 'cancelled':
                                                                echo '<span class="badge badge-danger">Đã hủy</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="badge badge-secondary">Không xác định</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="/admin/orders/viewOrder/<?php echo $order->id; ?>" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Xem
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i> Người dùng này chưa có đơn hàng nào.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?> 
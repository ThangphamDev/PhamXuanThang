<?php include 'app/views/admin/layouts/master.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý đơn hàng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Đơn hàng</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách đơn hàng</h3>
                            <div class="card-tools">
                                <form action="/admin/orders" method="GET" class="d-flex">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="search" class="form-control float-right" placeholder="Tìm theo mã, tên, SĐT...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <select name="status" class="form-control form-control-sm ml-2" style="width: 150px;" onchange="this.form.submit()">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="pending" <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                        <option value="processing" <?php echo isset($_GET['status']) && $_GET['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                                        <option value="shipping" <?php echo isset($_GET['status']) && $_GET['status'] == 'shipping' ? 'selected' : ''; ?>>Đang giao hàng</option>
                                        <option value="completed" <?php echo isset($_GET['status']) && $_GET['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                                        <option value="cancelled" <?php echo isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Khách hàng</th>
                                        <th>Liên hệ</th>
                                        <th>Tổng tiền</th>
                                        <th>Thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($orders)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Không có đơn hàng nào</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?php echo $order->id; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($order->name); ?></strong><br>
                                                    <small class="text-muted">ID: <?php echo $order->user_id; ?></small>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($order->phone); ?><br>
                                                    <small class="text-muted"><?php echo htmlspecialchars(substr($order->address, 0, 30)) . (strlen($order->address) > 30 ? '...' : ''); ?></small>
                                                </td>
                                                <td>
                                                    <span class="text-bold"><?php echo number_format($order->total_amount, 0, ',', '.'); ?>₫</span><br>
                                                    <small class="text-muted"><?php echo $order->item_count; ?> sản phẩm</small>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $payment_label = '';
                                                        switch ($order->payment_method) {
                                                            case 'cod':
                                                                $payment_label = '<span class="badge badge-warning">COD</span>';
                                                                break;
                                                            case 'bank_transfer':
                                                                $payment_label = '<span class="badge badge-info">Chuyển khoản</span>';
                                                                break;
                                                            case 'momo':
                                                                $payment_label = '<span class="badge badge-primary">MoMo</span>';
                                                                break;
                                                            case 'vnpay':
                                                                $payment_label = '<span class="badge badge-success">VNPay</span>';
                                                                break;
                                                            default:
                                                                $payment_label = '<span class="badge badge-secondary">Khác</span>';
                                                        }
                                                        echo $payment_label;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $status_class = '';
                                                        $status_text = '';
                                                        
                                                        switch ($order->status) {
                                                            case 'pending':
                                                                $status_class = 'badge-warning';
                                                                $status_text = 'Chờ xác nhận';
                                                                break;
                                                            case 'processing':
                                                                $status_class = 'badge-info';
                                                                $status_text = 'Đang xử lý';
                                                                break;
                                                            case 'shipping':
                                                                $status_class = 'badge-primary';
                                                                $status_text = 'Đang giao hàng';
                                                                break;
                                                            case 'completed':
                                                                $status_class = 'badge-success';
                                                                $status_text = 'Hoàn thành';
                                                                break;
                                                            case 'cancelled':
                                                                $status_class = 'badge-danger';
                                                                $status_text = 'Đã hủy';
                                                                break;
                                                            default:
                                                                $status_class = 'badge-secondary';
                                                                $status_text = 'Không xác định';
                                                        }
                                                    ?>
                                                    <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                                </td>
                                                <td>
                                                    <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="/admin/orders/view/<?php echo $order->id; ?>" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <?php if ($order->status != 'cancelled' && $order->status != 'completed'): ?>
                                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                <span>Cập nhật</span>
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <?php if ($order->status == 'pending'): ?>
                                                                    <a class="dropdown-item" href="/admin/orders/updateStatus/<?php echo $order->id; ?>/processing">
                                                                        <i class="fas fa-box-open text-info"></i> Xác nhận đơn hàng
                                                                    </a>
                                                                <?php endif; ?>
                                                                
                                                                <?php if ($order->status == 'processing'): ?>
                                                                    <a class="dropdown-item" href="/admin/orders/updateStatus/<?php echo $order->id; ?>/shipping">
                                                                        <i class="fas fa-shipping-fast text-primary"></i> Bắt đầu giao hàng
                                                                    </a>
                                                                <?php endif; ?>
                                                                
                                                                <?php if ($order->status == 'shipping'): ?>
                                                                    <a class="dropdown-item" href="/admin/orders/updateStatus/<?php echo $order->id; ?>/completed">
                                                                        <i class="fas fa-check text-success"></i> Đánh dấu hoàn thành
                                                                    </a>
                                                                <?php endif; ?>
                                                                
                                                                <?php if ($order->status != 'cancelled'): ?>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="/admin/orders/updateStatus/<?php echo $order->id; ?>/cancelled" 
                                                                       onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                                                        <i class="fas fa-times text-danger"></i> Hủy đơn hàng
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <?php if (isset($pagination) && $pagination->total_pages > 1): ?>
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <?php if ($pagination->current_page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=1<?php echo !empty($pagination->query_string) ? '&' . $pagination->query_string : ''; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $pagination->current_page - 1; ?><?php echo !empty($pagination->query_string) ? '&' . $pagination->query_string : ''; ?>">&lsaquo;</a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = max(1, $pagination->current_page - 2); $i <= min($pagination->total_pages, $pagination->current_page + 2); $i++): ?>
                                        <li class="page-item <?php echo $i == $pagination->current_page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($pagination->query_string) ? '&' . $pagination->query_string : ''; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($pagination->current_page < $pagination->total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $pagination->current_page + 1; ?><?php echo !empty($pagination->query_string) ? '&' . $pagination->query_string : ''; ?>">&rsaquo;</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $pagination->total_pages; ?><?php echo !empty($pagination->query_string) ? '&' . $pagination->query_string : ''; ?>">&raquo;</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $counts['pending']; ?></h3>
                            <p>Đơn hàng chờ xác nhận</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="/admin/orders?status=pending" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?php echo $counts['processing'] + $counts['shipping']; ?></h3>
                            <p>Đơn hàng đang xử lý</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <a href="/admin/orders?status=processing" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $counts['completed']; ?></h3>
                            <p>Đơn hàng hoàn thành</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="/admin/orders?status=completed" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $counts['cancelled']; ?></h3>
                            <p>Đơn hàng đã hủy</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <a href="/admin/orders?status=cancelled" class="small-box-footer">
                            Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'app/views/admin/layouts/footer.php'; ?> 
<?php include 'app/views/admin/layouts/master.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi tiết đơn hàng #<?php echo $order->id; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/orders">Đơn hàng</a></li>
                        <li class="breadcrumb-item active">Chi tiết đơn hàng #<?php echo $order->id; ?></li>
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
                <div class="col-md-12 mb-3">
                    <div class="btn-group">
                        <a href="/admin/orders" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <?php if ($order->status != 'cancelled' && $order->status != 'completed'): ?>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i> Cập nhật trạng thái
                            </button>
                            <div class="dropdown-menu">
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
                        
                        <a href="/admin/orders/print/<?php echo $order->id; ?>" target="_blank" class="btn btn-default">
                            <i class="fas fa-print"></i> In đơn hàng
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin đơn hàng</h3>
                            <div class="card-tools">
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
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Mã đơn hàng:</strong> #<?php echo $order->id; ?></p>
                                    <p><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
                                    <p>
                                        <strong>Phương thức thanh toán:</strong>
                                        <?php 
                                            switch ($order->payment_method) {
                                                case 'cod':
                                                    echo 'Thanh toán khi nhận hàng (COD)';
                                                    break;
                                                case 'bank_transfer':
                                                    echo 'Chuyển khoản ngân hàng';
                                                    break;
                                                case 'momo':
                                                    echo 'Ví điện tử MoMo';
                                                    break;
                                                case 'vnpay':
                                                    echo 'VNPay';
                                                    break;
                                                default:
                                                    echo $order->payment_method;
                                            }
                                        ?>
                                    </p>
                                    <?php if (!empty($order->payment_id)): ?>
                                        <p><strong>Mã giao dịch:</strong> <?php echo htmlspecialchars($order->payment_id); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <strong>Trạng thái thanh toán:</strong>
                                        <?php if ($order->payment_method == 'cod' && $order->status != 'completed'): ?>
                                            <span class="badge badge-warning">Chưa thanh toán</span>
                                        <?php else: ?>
                                            <span class="badge badge-success">Đã thanh toán</span>
                                        <?php endif; ?>
                                    </p>
                                    <?php if ($order->status != 'pending' && $order->status != 'cancelled'): ?>
                                        <p><strong>Xác nhận đơn hàng:</strong> <?php echo !empty($order->processing_time) ? date('d/m/Y H:i', strtotime($order->processing_time)) : 'N/A'; ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($order->status == 'shipping' || $order->status == 'completed'): ?>
                                        <p><strong>Bắt đầu giao hàng:</strong> <?php echo !empty($order->shipping_time) ? date('d/m/Y H:i', strtotime($order->shipping_time)) : 'N/A'; ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($order->status == 'completed'): ?>
                                        <p><strong>Hoàn thành:</strong> <?php echo !empty($order->completed_time) ? date('d/m/Y H:i', strtotime($order->completed_time)) : 'N/A'; ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($order->status == 'cancelled'): ?>
                                        <p><strong>Hủy đơn hàng:</strong> <?php echo !empty($order->cancelled_time) ? date('d/m/Y H:i', strtotime($order->cancelled_time)) : 'N/A'; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sản phẩm đã đặt</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-right">Đơn giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-right">Thành tiền</th>
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
                                        <td>
                                            <div class="product-info">
                                                <a href="/Product/show/<?php echo $item->product_id; ?>" class="product-title">
                                                    <?php echo htmlspecialchars($item->name); ?>
                                                </a>
                                                <span class="product-description">
                                                    ID: <?php echo $item->product_id; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-right"><?php echo number_format($item->price, 0, ',', '.'); ?>₫</td>
                                        <td class="text-center"><?php echo $item->quantity; ?></td>
                                        <td class="text-right"><?php echo number_format($itemTotal, 0, ',', '.'); ?>₫</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Tổng tiền sản phẩm:</strong></td>
                                        <td class="text-right"><?php echo number_format($totalAmount, 0, ',', '.'); ?>₫</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Phí vận chuyển:</strong></td>
                                        <td class="text-right"><?php echo number_format($order->shipping_fee ?? 0, 0, ',', '.'); ?>₫</td>
                                    </tr>
                                    <?php if (!empty($order->discount) && $order->discount > 0): ?>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Giảm giá:</strong></td>
                                        <td class="text-right text-danger">-<?php echo number_format($order->discount, 0, ',', '.'); ?>₫</td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Tổng thanh toán:</strong></td>
                                        <td class="text-right">
                                            <h5 class="m-0 text-success">
                                                <?php 
                                                $finalTotal = $totalAmount + ($order->shipping_fee ?? 0) - ($order->discount ?? 0);
                                                echo number_format($finalTotal, 0, ',', '.'); 
                                                ?>₫
                                            </h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin khách hàng</h3>
                        </div>
                        <div class="card-body">
                            <p><strong><i class="fas fa-user mr-1"></i> Họ tên:</strong> <?php echo htmlspecialchars($order->name); ?></p>
                            <p><strong><i class="fas fa-phone mr-1"></i> Số điện thoại:</strong> <?php echo htmlspecialchars($order->phone); ?></p>
                            <p><strong><i class="fas fa-map-marker-alt mr-1"></i> Địa chỉ:</strong> <?php echo htmlspecialchars($order->address); ?></p>
                            
                            <?php if (!empty($user)): ?>
                            <hr>
                            <p><strong><i class="fas fa-user-circle mr-1"></i> Tài khoản:</strong> <?php echo htmlspecialchars($user->username); ?></p>
                            <p><strong><i class="fas fa-envelope mr-1"></i> Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                            <a href="/admin/users/edit/<?php echo $user->id; ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-user-edit"></i> Xem thông tin tài khoản
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ghi chú đơn hàng</h3>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($order->note)): ?>
                                <div class="callout callout-info">
                                    <p><?php echo nl2br(htmlspecialchars($order->note)); ?></p>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Không có ghi chú</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lịch sử đơn hàng</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="timeline timeline-inverse p-3">
                                <div class="time-label">
                                    <span class="bg-primary">
                                        <?php echo date('d/m/Y', strtotime($order->created_at)); ?>
                                    </span>
                                </div>
                                
                                <div>
                                    <i class="fas fa-shopping-cart bg-info"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> <?php echo date('H:i', strtotime($order->created_at)); ?></span>
                                        <h3 class="timeline-header">Đơn hàng đã được tạo</h3>
                                    </div>
                                </div>
                                
                                <?php if (!empty($order->processing_time)): ?>
                                <div>
                                    <i class="fas fa-box-open bg-info"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> <?php echo date('H:i', strtotime($order->processing_time)); ?></span>
                                        <h3 class="timeline-header">Đơn hàng đã được xác nhận</h3>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($order->shipping_time)): ?>
                                <div>
                                    <i class="fas fa-shipping-fast bg-primary"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> <?php echo date('H:i', strtotime($order->shipping_time)); ?></span>
                                        <h3 class="timeline-header">Đơn hàng đang được giao</h3>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($order->completed_time)): ?>
                                <div>
                                    <i class="fas fa-check-circle bg-success"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> <?php echo date('H:i', strtotime($order->completed_time)); ?></span>
                                        <h3 class="timeline-header">Đơn hàng đã hoàn thành</h3>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($order->cancelled_time)): ?>
                                <div>
                                    <i class="fas fa-times-circle bg-danger"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> <?php echo date('H:i', strtotime($order->cancelled_time)); ?></span>
                                        <h3 class="timeline-header">Đơn hàng đã bị hủy</h3>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div>
                                    <i class="far fa-clock bg-gray"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'app/views/admin/layouts/footer.php'; ?> 
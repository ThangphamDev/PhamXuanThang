<?php include 'app/views/admin/layouts/master.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Thẻ thông tin tóm tắt -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo number_format($totalRevenue, 0, ',', '.'); ?>₫</h3>
                            <p>Tổng doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="/admin/orders" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $orderStatuses->completed ?? 0; ?></h3>
                            <p>Đơn hàng hoàn thành</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="/admin/orders" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $orderStatuses->pending ?? 0; ?></h3>
                            <p>Đơn hàng chờ xử lý</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="/admin/orders" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $totalUsers; ?></h3>
                            <p>Người dùng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="/account/listUsers" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Biểu đồ doanh thu theo tháng -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Doanh thu theo tháng - <?php echo isset($currentYear) ? $currentYear : date('Y'); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="revenueChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Biểu đồ trạng thái đơn hàng -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trạng thái đơn hàng</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="orderStatusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Top sản phẩm bán chạy -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top 5 sản phẩm bán chạy</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Sản phẩm</th>
                                        <th>Đã bán</th>
                                        <th>Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($topProducts) && is_array($topProducts)): ?>
                                        <?php foreach ($topProducts as $product): ?>
                                            <tr>
                                                <td><?php echo $product->product_id; ?></td>
                                                <td><?php echo htmlspecialchars($product->name); ?></td>
                                                <td><?php echo isset($product->quantity_sold) ? $product->quantity_sold : (isset($product->total_quantity) ? $product->total_quantity : 0); ?></td>
                                                <td><?php echo number_format(isset($product->total_revenue) ? $product->total_revenue : 0, 0, ',', '.'); ?>₫</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Đơn hàng gần đây -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Đơn hàng gần đây</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($recentOrders) && is_array($recentOrders)): ?>
                                        <?php foreach ($recentOrders as $order): ?>
                                            <tr>
                                                <td><a href="/admin/orders/viewOrder/<?php echo $order->id; ?>">#<?php echo $order->id; ?></a></td>
                                                <td><?php echo htmlspecialchars($order->name); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($order->created_at)); ?></td>
                                                <td>
                                                    <?php 
                                                    $statusClass = '';
                                                    $statusLabel = '';
                                                    
                                                    switch ($order->status) {
                                                        case 'pending':
                                                            $statusClass = 'badge-warning';
                                                            $statusLabel = 'Chờ xác nhận';
                                                            break;
                                                        case 'processing':
                                                            $statusClass = 'badge-info';
                                                            $statusLabel = 'Đang xử lý';
                                                            break;
                                                        case 'shipping':
                                                            $statusClass = 'badge-primary';
                                                            $statusLabel = 'Đang giao';
                                                            break;
                                                        case 'completed':
                                                            $statusClass = 'badge-success';
                                                            $statusLabel = 'Hoàn thành';
                                                            break;
                                                        case 'cancelled':
                                                            $statusClass = 'badge-danger';
                                                            $statusLabel = 'Đã hủy';
                                                            break;
                                                        default:
                                                            $statusClass = 'badge-secondary';
                                                            $statusLabel = 'Không xác định';
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $statusClass; ?>"><?php echo $statusLabel; ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Doanh thu theo tháng
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var monthlyData = <?php 
        $revenueData = array_fill(0, 12, 0);
        $currentYearJS = isset($currentYear) ? $currentYear : date('Y');
        if (isset($monthlyRevenue) && is_array($monthlyRevenue)) {
            foreach ($monthlyRevenue as $item) {
                $month = (int)$item->month - 1;
                $revenueData[$month] = (float)$item->revenue;
            }
        }
        echo json_encode($revenueData); 
    ?>;
    
    var revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: monthlyData,
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + '₫';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw.toLocaleString('vi-VN') + '₫';
                        }
                    }
                }
            }
        }
    });
    
    // Biểu đồ trạng thái đơn hàng
    var orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    var pending = <?php echo isset($orderStatuses->pending) ? $orderStatuses->pending : 0; ?>;
    var processing = <?php echo isset($orderStatuses->processing) ? $orderStatuses->processing : 0; ?>;
    var shipping = <?php echo isset($orderStatuses->shipping) ? $orderStatuses->shipping : 0; ?>;
    var completed = <?php echo isset($orderStatuses->completed) ? $orderStatuses->completed : 0; ?>;
    var cancelled = <?php echo isset($orderStatuses->cancelled) ? $orderStatuses->cancelled : 0; ?>;
    
    var orderStatusChart = new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Chờ xác nhận', 'Đang xử lý', 'Đang giao', 'Hoàn thành', 'Đã hủy'],
            datasets: [{
                data: [pending, processing, shipping, completed, cancelled],
                backgroundColor: ['#f39c12', '#00c0ef', '#3c8dbc', '#00a65a', '#f56954'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});
</script>

<?php include 'app/views/admin/layouts/footer.php'; ?> 
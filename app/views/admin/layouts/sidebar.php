            <!-- Orders Menu -->
            <li class="nav-item">
                <a href="/admin/orders" class="nav-link <?php echo $this->isCurrentPage('/admin/orders') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>
                        Quản lý đơn hàng
                        <?php 
                        $orderModel = $this->model('OrderModel');
                        $pendingOrders = $orderModel->countOrdersByStatus('pending');
                        if ($pendingOrders > 0):
                        ?>
                        <span class="right badge badge-warning"><?php echo $pendingOrders; ?></span>
                        <?php endif; ?>
                    </p>
                </a>
            </li> 
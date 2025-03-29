            <!-- Dashboard Menu -->
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link <?php echo $helper->isCurrentPage('/admin/dashboard') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            
            <!-- Orders Menu -->
            <li class="nav-item">
                <a href="/admin/orders" class="nav-link <?php echo $helper->isCurrentPage('/admin/orders') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>
                        Quản lý đơn hàng
                        <?php 
                        $orderModel = $helper->model('OrderModel');
                        $pendingOrders = $orderModel->countOrdersByStatus('pending');
                        if ($pendingOrders > 0):
                        ?>
                        <span class="right badge badge-warning"><?php echo $pendingOrders; ?></span>
                        <?php endif; ?>
                    </p>
                </a>
            </li>
            
            <!-- Users Menu -->
            <li class="nav-item">
                <a href="/account/listUsers" class="nav-link <?php echo $helper->isCurrentPage('/account/listUsers') ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Quản lý tài khoản
                    </p>
                </a>
            </li> 
<?php include 'app/views/shares/header.php'; ?>
<style>
    :root {
        /* Color Palette */
        --primary-color: #2563eb;      /* Modern blue */
        --primary-dark: #1d4ed8;       /* Darker blue */
        --secondary-color: #4f46e5;    /* Deep indigo */
        --background-light: #f8fafc;   /* Soft blue-gray background */
        --text-primary: #1f2937;       /* Dark gray for text */
        --text-secondary: #6b7280;     /* Muted gray */
        --border-color: #e5e7eb;       /* Light gray border */
        --white: #ffffff;
        --success-color: #22c55e;      /* Green for success */
        --warning-color: #f59e0b;      /* Amber for warnings */
        --danger-color: #ef4444;       /* Red for danger/errors */
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Roboto, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: var(--background-light);
        color: var(--text-primary);
        line-height: 1.6;
    }

    .checkout-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .checkout-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .checkout-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .checkout-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .checkout-progress {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .progress-step {
        display: flex;
        align-items: center;
        margin: 0 1rem;
    }

    .step-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        margin-right: 0.5rem;
    }

    .step-text {
        font-weight: 500;
    }

    .progress-line {
        flex: 1;
        height: 2px;
        background-color: var(--border-color);
        margin: 0 0.5rem;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    .checkout-card {
        background-color: var(--white);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        padding: 2rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control:invalid {
        border-color: var(--danger-color);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .payment-method {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method:hover {
        border-color: var(--primary-color);
        background-color: rgba(37, 99, 235, 0.05);
    }

    .payment-method.selected {
        border-color: var(--primary-color);
        background-color: rgba(37, 99, 235, 0.05);
    }

    .payment-method input[type="radio"] {
        margin-right: 1rem;
    }

    .payment-method-info {
        display: flex;
        flex-direction: column;
    }

    .payment-method-name {
        font-weight: 600;
    }

    .payment-method-desc {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .order-summary {
        margin-top: 1.5rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 1rem;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .item-quantity {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .item-price {
        font-weight: 600;
        color: var(--primary-color);
        text-align: right;
    }

    .order-totals {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .total-label {
        color: var(--text-secondary);
    }

    .total-value {
        font-weight: 500;
    }

    .grand-total {
        display: flex;
        justify-content: space-between;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border-color);
        font-size: 1.25rem;
    }

    .grand-total-label {
        font-weight: 600;
    }

    .grand-total-value {
        font-weight: 700;
        color: var(--primary-color);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.25rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: var(--white);
        margin-top: 1.5rem;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .btn-secondary {
        background-color: var(--background-light);
        color: var(--text-primary);
        margin-top: 1rem;
        width: 100%;
    }

    .btn-secondary:hover {
        background-color: var(--border-color);
    }

    .secure-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .secure-checkout i {
        margin-right: 0.5rem;
        color: var(--success-color);
    }
</style>

<div class="checkout-container">
    <div class="checkout-header">
        <h1 class="checkout-title">Thanh Toán</h1>
        <p class="checkout-subtitle">Hoàn tất đơn hàng của bạn</p>
    </div>
    
    <div class="checkout-progress">
        <div class="progress-step">
            <div class="step-number">1</div>
            <div class="step-text">Giỏ hàng</div>
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-number">2</div>
            <div class="step-text">Thanh toán</div>
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-number">3</div>
            <div class="step-text">Hoàn tất</div>
        </div>
    </div>
    
    <div class="checkout-grid">
        <!-- Thông tin khách hàng -->
        <div class="checkout-card">
            <h2 class="card-title">Thông tin khách hàng</h2>
            <form method="POST" action="/Product/processCheckout" id="checkout-form" novalidate>
                <div class="form-group">
                    <label for="name">Họ tên</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="<?php echo isset($user) ? htmlspecialchars($user->name) : ''; ?>"
                           required pattern="^[A-Za-zÀ-ỹ\s]{2,50}$" 
                           title="Vui lòng nhập tên hợp lệ (2-50 ký tự)">
                </div>
                
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           value="<?php echo isset($user) ? htmlspecialchars($user->phone ?? '') : ''; ?>"
                           required pattern="^(0[3|5|7|8|9])+([0-9]{8})$" 
                           title="Vui lòng nhập số điện thoại hợp lệ">
                </div>
                
                <div class="form-group">
                    <label for="address">Địa chỉ giao hàng</label>
                    <textarea id="address" name="address" class="form-control" rows="3"
                              required minlength="5" maxlength="250" 
                              title="Vui lòng nhập địa chỉ chi tiết (5-250 ký tự)"><?php echo isset($user) ? htmlspecialchars($user->address ?? '') : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="note">Ghi chú (tùy chọn)</label>
                    <textarea id="note" name="note" class="form-control" rows="2"
                              maxlength="500"></textarea>
                </div>
                
                <h3 class="card-title">Phương thức thanh toán</h3>
                <div class="payment-methods">
                    <label class="payment-method selected">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <div class="payment-method-info">
                            <span class="payment-method-name">Thanh toán khi nhận hàng (COD)</span>
                            <span class="payment-method-desc">Thanh toán bằng tiền mặt khi nhận hàng</span>
                        </div>
                    </label>
                    
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="bank">
                        <div class="payment-method-info">
                            <span class="payment-method-name">Chuyển khoản ngân hàng</span>
                            <span class="payment-method-desc">Thực hiện thanh toán vào tài khoản ngân hàng của chúng tôi. Đơn hàng sẽ được giao sau khi tiền đã được chuyển.</span>
                        </div>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-credit-card me-2"></i>Đặt hàng
                </button>
                
                <a href="/Product/cart" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại giỏ hàng
                </a>
                
                <div class="secure-checkout">
                    <i class="fas fa-lock"></i>
                    <span>Thông tin thanh toán của bạn được bảo mật</span>
                </div>
            </form>
        </div>
        
        <!-- Thông tin đơn hàng -->
        <div class="checkout-card">
            <h2 class="card-title">Thông tin đơn hàng</h2>
            
            <div class="order-summary">
                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $item): ?>
                    <div class="order-item">
                        <img src="/<?php echo htmlspecialchars($item['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" class="item-image">
                        <div class="item-details">
                            <div class="item-name"><?php echo htmlspecialchars($item['name'] ?? ''); ?></div>
                            <div class="item-quantity">Số lượng: <?php echo $item['quantity'] ?? 1; ?></div>
                        </div>
                        <div class="item-price"><?php echo number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.'); ?>₫</div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-cart-message">
                        <p>Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.</p>
                        <a href="/Product" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($cart)): ?>
            <div class="order-totals">
                <div class="total-row">
                    <div class="total-label">Tạm tính</div>
                    <div class="total-value"><?php echo number_format($total ?? 0, 0, ',', '.'); ?>₫</div>
                </div>
                
                <div class="total-row">
                    <div class="total-label">Phí vận chuyển</div>
                    <?php 
                    // Mặc định phí vận chuyển là 30.000đ
                    $shipping = 30000;
                    
                    // Miễn phí vận chuyển nếu tổng đơn hàng > 500.000đ
                    $shippingDisplay = (isset($total) && $total > 500000) ? 0 : $shipping;
                    ?>
                    <div class="total-value"><?php echo number_format($shippingDisplay, 0, ',', '.'); ?>₫</div>
                </div>
                
                <?php if (isset($total) && $total > 500000): ?>
                <div class="total-row">
                    <div class="total-label">Giảm giá vận chuyển</div>
                    <div class="total-value" style="color: var(--success-color);">-<?php echo number_format($shipping, 0, ',', '.'); ?>₫</div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="grand-total">
                <div class="grand-total-label">Tổng thanh toán</div>
                <?php
                // Tính tổng thanh toán: nếu đơn hàng > 500.000đ thì miễn phí vận chuyển
                $finalTotal = (isset($total) ? $total : 0);
                if (!isset($total) || $total <= 500000) {
                    $finalTotal += $shipping;
                }
                ?>
                <div class="grand-total-value"><?php echo number_format($finalTotal, 0, ',', '.'); ?>₫</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // JavaScript để xử lý việc chọn phương thức thanh toán
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethods = document.querySelectorAll('.payment-method');
        
        paymentMethods.forEach(method => {
            method.addEventListener('click', function() {
                // Bỏ chọn tất cả các phương thức
                paymentMethods.forEach(m => m.classList.remove('selected'));
                // Chọn phương thức hiện tại
                this.classList.add('selected');
                // Đánh dấu radio button
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
        
        // Xác thực form trước khi gửi
        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                // Hiển thị thông báo lỗi cho người dùng
                alert('Vui lòng điền đầy đủ thông tin thanh toán.');
            }
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>
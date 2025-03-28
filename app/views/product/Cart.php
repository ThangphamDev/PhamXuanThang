<?php include 'app/views/shares/header.php'; ?>
<div class="main-container">
    <div class="product-header d-flex justify-content-between align-items-center">
        <h1 class="product-title">Giỏ hàng của bạn</h1>
        <a href="/Product/" class="btn btn-add-product">
            <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách sản phẩm
        </a>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
    </div>

    <style>
        :root {
    /* Professional Color Palette */
    --primary-color: #2563eb;      /* Modern blue */
    --primary-dark: #1d4ed8;       /* Darker blue */
    --secondary-color: #4f46e5;    /* Deep indigo */
    --background-light: #f4f7ff;   /* Soft blue-gray background */
    --text-primary: #1f2937;       /* Dark gray for text */
    --text-secondary: #6b7280;     /* Muted gray */
    --border-color: #e5e7eb;       /* Light gray border */
    --white: #ffffff;
    --danger-color: #ef4444;       /* Soft red */
    --success-color: #22c55e;      /* Green for success */
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: var(--background-light);
    font-family: 'Inter', 'Segoe UI', Roboto, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
}

.main-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 1.5rem;
    background-color: var(--white);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
}

/* Product Header */
.product-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary-color);
}

.product-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    letter-spacing: -0.025em;
}

/* Button Styles */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-add-product {
    background-color: var(--primary-color);
    color: var(--white);
}

.btn-add-product:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}

.btn-primary {
    background-color: var(--secondary-color);
    color: var(--white);
}

.btn-primary:hover {
    background-color: color-mix(in srgb, var(--secondary-color) 85%, white);
}

.btn-success {
    background-color: var(--success-color);
    color: var(--white);
}

.btn-success:hover {
    background-color: color-mix(in srgb, var(--success-color) 85%, white);
}

.btn-danger {
    background-color: var(--danger-color);
    color: var(--white);
}

.btn-danger:hover {
    background-color: color-mix(in srgb, var(--danger-color) 85%, white);
}

/* Table Styles */
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background-color: var(--white);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
}

.table thead {
    background-color: var(--background-light);
}

.table thead th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
}

.table tbody tr {
    transition: background-color 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(37, 99, 235, 0.03);
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.product-img {
    max-width: 60px;
    border-radius: 8px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-img:hover {
    transform: scale(1.1);
}

/* Form Control */
.form-control[type="number"] {
    width: 100px;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.form-control[type="number"]:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* Pricing */
.product-price {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
}

.product-price strong {
    color: var(--primary-color);
}

/* Cart Actions */
.cart-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1.5rem;
    padding: 1.5rem;
    background-color: var(--background-light);
    border-radius: 12px;
}

.cart-actions-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

/* Empty Cart Styles */
.empty-products {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    text-align: center;
    background-color: var(--white);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.empty-icon i {
    font-size: 4rem;
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

.empty-products h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-products p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-container {
        margin: 1rem;
        padding: 1rem;
    }

    .product-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .cart-actions {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
    }

    .cart-actions-left {
        width: 100%;
        flex-direction: column;
        align-items: stretch;
    }

    .btn {
        width: 100%;
    }

    .table {
        font-size: 0.875rem;
    }
}
    </style>

    <?php if (!empty($cart)): ?>
        <form method="POST" action="/Product/updateCart" id="cartForm">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $id => $item): ?>
                        <tr data-product-id="<?php echo $id; ?>">
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="/<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                         class="product-img" style="max-width: 50px;">
                                <?php else: ?>
                                    <i class="fas fa-image"></i>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td class="price" data-price="<?php echo $item['price']; ?>">
                                <?php echo number_format($item['price'], 0, ',', '.'); ?> ₫
                            </td>
                            <td>
                                <input type="number" 
                                       name="quantity[<?php echo $id; ?>]" 
                                       value="<?php echo $item['quantity']; ?>" 
                                       min="0" 
                                       class="form-control quantity-input" 
                                       data-product-id="<?php echo $id; ?>"
                                       style="width: 80px;">
                            </td>
                            <td class="subtotal">
                                <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> ₫
                            </td>
                            <td>
                                <a href="/Product/removeFromCart/<?php echo $id; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-actions">
                <div class="cart-actions-left">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync-alt me-2"></i> Cập nhật giỏ hàng
                    </button>
                    <div class="product-price">
                        Tổng cộng: <strong class="total-amount">
                            <?php echo number_format($total, 0, ',', '.'); ?> ₫
                        </strong>
                    </div>
                </div>
                <a href="/Product/checkout" class="btn btn-success">
                    <i class="fas fa-check me-2"></i> Thanh toán
                </a>
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const quantityInputs = document.querySelectorAll('.quantity-input');
                const totalElement = document.querySelector('.total-amount');
                let updateTimeout;

                function formatNumber(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' ₫';
                }

                function updateSubtotal(row) {
                    const price = parseFloat(row.querySelector('.price').dataset.price);
                    const quantity = parseInt(row.querySelector('.quantity-input').value) || 0;
                    const subtotal = price * quantity;
                    row.querySelector('.subtotal').textContent = formatNumber(subtotal);
                    return subtotal;
                }

                function updateTotal() {
                    let total = 0;
                    document.querySelectorAll('tbody tr').forEach(row => {
                        total += updateSubtotal(row);
                    });
                    totalElement.textContent = formatNumber(total);
                }

                function ajaxUpdateCart(productId, quantity) {
                    clearTimeout(updateTimeout);
                    
                    // Hiển thị biểu tượng loading hoặc thông báo đang cập nhật
                    const row = document.querySelector(`tr[data-product-id="${productId}"]`);
                    const subtotalCell = row.querySelector('.subtotal');
                    subtotalCell.innerHTML += ' <small><i class="fas fa-sync fa-spin"></i></small>';
                    
                    updateTimeout = setTimeout(function() {
                        const formData = new FormData();
                        formData.append('product_id', productId);
                        formData.append('quantity', quantity);
                        
                        fetch('/Product/ajaxUpdateCart', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.removed) {
                                    // Nếu sản phẩm bị xóa (số lượng = 0)
                                    row.remove();
                                } else {
                                    // Cập nhật subtotal cho sản phẩm
                                    subtotalCell.textContent = data.formattedSubtotal;
                                }
                                
                                // Cập nhật tổng giỏ hàng
                                totalElement.textContent = data.formattedTotal;
                                
                                // Kiểm tra xem còn sản phẩm trong giỏ hàng không
                                if (document.querySelectorAll('tbody tr').length === 0) {
                                    location.reload(); // Tải lại trang để hiển thị giỏ hàng trống
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi cập nhật giỏ hàng:', error);
                            subtotalCell.querySelector('small').remove();
                        });
                    }, 500); // Đợi 500ms trước khi gửi request để tránh gửi quá nhiều request
                }

                quantityInputs.forEach(input => {
                    // Xử lý khi giá trị input thay đổi (khi người dùng nhập hoặc sử dụng nút tăng/giảm)
                    input.addEventListener('change', function() {
                        if (this.value < 0) this.value = 0;
                        const productId = this.dataset.productId;
                        const quantity = parseInt(this.value);
                        
                        ajaxUpdateCart(productId, quantity);
                    });
                    
                    // Xử lý khi người dùng nhấn nút tăng/giảm (arrows) của input type number
                    input.addEventListener('input', function() {
                        updateSubtotal(this.closest('tr'));
                        updateTotal();
                    });
                });
                
                // Ngăn form submit thông thường, chỉ sử dụng khi nhấn nút "Cập nhật giỏ hàng"
                document.getElementById('cartForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Gửi form qua AJAX để cập nhật tất cả cùng lúc
                    const formData = new FormData(this);
                    
                    fetch('/Product/updateCart', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    });
                });
            });
        </script>
    <?php else: ?>
        <div class="empty-products">
            <div class="empty-icon">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            </div>
            <h3>Giỏ hàng trống</h3>
            <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm!</p>
            <a href="/Product/" class="btn btn-add-product mt-3">
                <i class="fas fa-shopping-basket me-2"></i> Quay lại danh sách sản phẩm
            </a>
        </div>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>
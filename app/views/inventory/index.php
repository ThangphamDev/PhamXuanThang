<?php include 'app/views/shares/header.php'; ?>

<div class="container">
    <div class="inventory-header">
        <h1>Quản lý Kho</h1>
        <div class="inventory-stats">
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $data['stats']->total_products; ?></span>
                    <span class="stat-label">Tổng sản phẩm</span>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-warehouse"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $data['stats']->total_quantity; ?></span>
                    <span class="stat-label">Tổng số lượng</span>
                </div>
            </div>
            <div class="stat-card warning">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $data['stats']->low_stock_count; ?></span>
                    <span class="stat-label">Sắp hết hàng</span>
                </div>
            </div>
            <div class="stat-card danger">
                <i class="fas fa-times-circle"></i>
                <div class="stat-info">
                    <span class="stat-value"><?php echo $data['stats']->out_of_stock_count; ?></span>
                    <span class="stat-label">Hết hàng</span>
                </div>
            </div>
        </div>
    </div>

    <div class="inventory-content">
        <div class="inventory-main">
            <div class="inventory-table-wrapper">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Số lượng</th>
                            <th>Tối thiểu</th>
                            <th>Tối đa</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['inventory'] as $item): ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="/<?php echo $item->image; ?>" alt="<?php echo $item->product_name; ?>" class="product-thumb">
                                    <span><?php echo $item->product_name; ?></span>
                                </div>
                            </td>
                            <td><?php echo $item->category_name; ?></td>
                            <td>
                                <span class="quantity <?php echo $item->quantity <= $item->min_quantity ? 'low' : ''; ?>">
                                    <?php echo $item->quantity; ?>
                                </span>
                            </td>
                            <td><?php echo $item->min_quantity; ?></td>
                            <td><?php echo $item->max_quantity; ?></td>
                            <td>
                                <?php if ($item->quantity == 0): ?>
                                    <span class="status out-of-stock">Hết hàng</span>
                                <?php elseif ($item->quantity <= $item->min_quantity): ?>
                                    <span class="status low-stock">Sắp hết hàng</span>
                                <?php else: ?>
                                    <span class="status in-stock">Còn hàng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="btn-edit" onclick="editInventory(<?php echo $item->product_id; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-update" onclick="updateStock(<?php echo $item->product_id; ?>)">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="inventory-sidebar">
            <div class="low-stock-alert">
                <h3>Sản phẩm sắp hết hàng</h3>
                <div class="alert-list">
                    <?php foreach ($data['lowStock'] as $item): ?>
                    <div class="alert-item">
                        <div class="alert-info">
                            <span class="product-name"><?php echo $item->product_name; ?></span>
                            <span class="stock-info">Còn: <?php echo $item->quantity; ?></span>
                        </div>
                        <a href="/inventory/edit/<?php echo $item->product_id; ?>" class="btn-replenish">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal chỉnh sửa số lượng -->
<div id="editInventoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Chỉnh sửa số lượng</h2>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editInventoryForm">
                <input type="hidden" id="editProductId" name="product_id">
                <div class="form-group">
                    <label for="editQuantity">Số lượng</label>
                    <input type="number" id="editQuantity" name="quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label for="editMinQuantity">Số lượng tối thiểu</label>
                    <input type="number" id="editMinQuantity" name="min_quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label for="editMaxQuantity">Số lượng tối đa</label>
                    <input type="number" id="editMaxQuantity" name="max_quantity" min="0" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Cập nhật</button>
                    <button type="button" class="btn-secondary close-modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal cập nhật số lượng -->
<div id="updateStockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Cập nhật số lượng</h2>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="updateStockForm">
                <input type="hidden" id="updateProductId" name="product_id">
                <div class="form-group">
                    <label for="updateQuantity">Số lượng mới</label>
                    <input type="number" id="updateQuantity" name="quantity" min="0" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Cập nhật</button>
                    <button type="button" class="btn-secondary close-modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.inventory-header {
    margin-bottom: 2rem;
}

.inventory-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-card i {
    font-size: 2rem;
    color: var(--primary-color);
}

.stat-card.warning i {
    color: #ffa726;
}

.stat-card.danger i {
    color: #ef5350;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-muted);
}

.inventory-content {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 2rem;
}

.inventory-table-wrapper {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.inventory-table {
    width: 100%;
    border-collapse: collapse;
}

.inventory-table th,
.inventory-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.inventory-table th {
    background: var(--light-bg);
    font-weight: 600;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.product-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.quantity {
    font-weight: 600;
}

.quantity.low {
    color: #ffa726;
}

.status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status.in-stock {
    background: #e8f5e9;
    color: #2e7d32;
}

.status.low-stock {
    background: #fff3e0;
    color: #ef6c00;
}

.status.out-of-stock {
    background: #ffebee;
    color: #c62828;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn-edit,
.btn-update {
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-edit {
    background: var(--primary-color);
    color: white;
}

.btn-update {
    background: var(--secondary-color);
    color: white;
}

.btn-edit:hover,
.btn-update:hover {
    opacity: 0.9;
}

.low-stock-alert {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 1.5rem;
}

.low-stock-alert h3 {
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.alert-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.alert-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #fff3e0;
    border-radius: 4px;
}

.alert-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.product-name {
    font-weight: 500;
    color: var(--text-dark);
}

.stock-info {
    font-size: 0.9rem;
    color: #ef6c00;
}

.btn-replenish {
    padding: 0.5rem;
    background: #ffa726;
    color: white;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.btn-replenish:hover {
    background: #f57c00;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.25rem;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-muted);
}

.modal-body {
    padding: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.form-group input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
}

.btn-primary,
.btn-secondary {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-secondary {
    background: var(--light-bg);
    color: var(--text-dark);
}

.btn-primary:hover,
.btn-secondary:hover {
    opacity: 0.9;
}
</style>

<script>
// Xử lý modal
const modals = document.querySelectorAll('.modal');
const closeButtons = document.querySelectorAll('.close-modal');

function openModal(modalId) {
    document.getElementById(modalId).classList.add('show');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
}

closeButtons.forEach(button => {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        modal.classList.remove('show');
    });
});

// Đóng modal khi click bên ngoài
modals.forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });
});

// Xử lý chỉnh sửa số lượng
function editInventory(productId) {
    const modal = document.getElementById('editInventoryModal');
    document.getElementById('editProductId').value = productId;
    
    // Lấy thông tin sản phẩm
    fetch(`/inventory/getProduct/${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editQuantity').value = data.quantity;
            document.getElementById('editMinQuantity').value = data.min_quantity;
            document.getElementById('editMaxQuantity').value = data.max_quantity;
            modal.classList.add('show');
        });
}

// Xử lý cập nhật số lượng
function updateStock(productId) {
    const modal = document.getElementById('updateStockModal');
    document.getElementById('updateProductId').value = productId;
    modal.classList.add('show');
}

// Xử lý form chỉnh sửa
document.getElementById('editInventoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('/inventory/edit', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
});

// Xử lý form cập nhật số lượng
document.getElementById('updateStockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('/inventory/updateStock', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?> 
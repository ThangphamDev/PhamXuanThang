<?php include 'app/views/shares/header.php'; ?>

<!-- CSS tùy chỉnh -->
<style>
    .product-form-container {
        max-width: 1200px;
        margin: 40px auto;
    }
    
    .product-form-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .product-form-header {
        background: linear-gradient(135deg, #43a047, #1b5e20);
        color: white;
        padding: 20px;
        font-weight: 600;
    }
    
    .product-form-body {
        padding: 30px;
    }
    
    .form-label {
        font-weight: 600;
        color: #4a4a4a;
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
        background-color: #f9f9f9;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.2);
        border-color: #43a047;
        background-color: #fff;
    }
    
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s;
        margin-top: 10px;
    }
    
    .file-input-wrapper:hover {
        border-color: #43a047;
        background-color: #f9f9f9;
    }
    
    .file-input-icon {
        font-size: 2rem;
        color: #43a047;
        margin-bottom: 10px;
    }
    
    .btn-success-gradient {
        background: linear-gradient(135deg, #43a047, #1b5e20);
        border: none;
        color: white;
        border-radius: 6px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-success-gradient:hover {
        background: linear-gradient(135deg, #388e3c, #2e7d32);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-secondary-custom {
        background-color: #f4f4f4;
        color: #4a4a4a;
        border: none;
        border-radius: 6px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-secondary-custom:hover {
        background-color: #e0e0e0;
        color: #333;
        transform: translateY(-2px);
    }
    
    .price-input-group {
        position: relative;
    }
    
    .price-input-group .form-control {
        padding-right: 50px;
    }
    
    .price-input-group .currency-symbol {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-weight: 600;
    }
</style>

<div class="product-form-container">
    <div class="product-form-card">
        <div class="product-form-header">
            <h2 class="m-0"><i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm mới</h2>
        </div>
        <div class="product-form-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <textarea id="description" name="description" class="form-control" rows="5" placeholder="Mô tả chi tiết về sản phẩm của bạn" required></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="price" class="form-label">Giá sản phẩm</label>
                            <div class="price-input-group">
                                <input type="number" id="price" name="price" class="form-control" step="0.01" placeholder="0" required>
                                <span class="currency-symbol">₫</span>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <option value="" disabled selected>Chọn danh mục sản phẩm</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                            <div class="file-input-wrapper">
                                <div class="file-input-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <p class="mb-2">Kéo và thả hoặc bấm để chọn hình ảnh</p>
                                <input type="file" id="image" name="image" class="form-control" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;">
                            </div>
                            <div class="form-text text-muted mt-2">Hỗ trợ định dạng: JPG, PNG, GIF. Tối đa 5MB</div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="/Product/" class="btn btn-secondary-custom">
                        <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                    </a>
                    <button type="submit" class="btn btn-success-gradient">
                        <i class="fas fa-plus-circle me-2"></i> Thêm sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script hiển thị tên file khi upload -->
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Không có file nào được chọn';
    const parent = this.parentElement;
    const fileNameElement = parent.querySelector('p');
    fileNameElement.textContent = fileName;
});
</script>

<?php include 'app/views/shares/footer.php'; ?>
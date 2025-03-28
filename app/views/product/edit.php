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
        background: linear-gradient(135deg, #3a7bd5, #2b5876);
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
        width: 100%;
        box-sizing: border-box; /* Đảm bảo padding không làm vượt kích thước */
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(58, 123, 213, 0.2);
        border-color: #3a7bd5;
        background-color: #fff;
    }
    
    /* Sửa kiểu cho input[type="file"] */
    input[type="file"].form-control {
        padding: 0; /* Loại bỏ padding mặc định để kiểm soát tốt hơn */
        height: 48px; /* Chiều cao cố định */
        line-height: 48px; /* Căn giữa theo chiều dọc */
        display: block;
        width: 100%;
        overflow: hidden; /* Ngăn tràn nội dung */
        box-sizing: border-box;
    }
    
    /* Tùy chỉnh nút "Choose File" trên các trình duyệt */
    input[type="file"].form-control::-webkit-file-upload-button {
        padding: 12px 16px; /* Khớp với padding của .form-control */
        margin-right: 10px; /* Khoảng cách với phần tên file */
        border: none;
        border-radius: 6px 0 0 6px; /* Bo góc bên trái */
        background-color: #fff;
        color: #4a4a4a;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        height: 100%; /* Chiều cao khớp với input */
        line-height: 1; /* Điều chỉnh căn giữa */
    }
    
    input[type="file"].form-control::-webkit-file-upload-button:hover {
        background-color: #f0f0f0;
    }
    
    /* Tương thích với Firefox */
    input[type="file"].form-control::-moz-focus-inner {
        border: 0;
        padding: 0;
    }
    
    /* Đảm bảo phần tên file hiển thị đầy đủ */
    input[type="file"].form-control::file-selector-button {
        margin-right: 10px;
        padding: 12px 16px;
        border: none;
        border-radius: 6px 0 0 6px;
        background-color: #fff;
        color: #4a4a4a;
        font-weight: 600;
        cursor: pointer;
        height: 100%;
    }
    
    input[type="file"].form-control::file-selector-button:hover {
        background-color: #f0f0f0;
    }
    
    .img-preview {
        border-radius: 8px;
        border: 2px solid #f0f0f0;
        padding: 10px;
        background-color: white;
        transition: all 0.3s;
        margin-top: 20px; /* Tăng khoảng cách để tránh chồng lấn */
    }
    
    .img-preview:hover {
        border-color: #3a7bd5;
    }
    
    .btn-primary-gradient {
        background: linear-gradient(135deg, #3a7bd5, #2b5876);
        border: none;
        color: white;
        border-radius: 6px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-primary-gradient:hover {
        background: linear-gradient(135deg, #2b5876, #3a7bd5);
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
            <h2 class="m-0"><i class="fas fa-edit me-2"></i>Sửa sản phẩm</h2>
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
            
            <form method="POST" action="/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <textarea id="description" name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="price" class="form-label">Giá sản phẩm</label>
                            <div class="price-input-group">
                                <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
                                <span class="currency-symbol">₫</span>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                            
                            <?php if ($product->image): ?>
                                <div class="text-center mt-3 img-preview">
                                    <p class="mb-2 text-muted small">Hình ảnh hiện tại</p>
                                    <img src="/<?php echo $product->image; ?>" alt="Product Image" class="img-fluid rounded" style="max-height: 180px;">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="/Product/" class="btn btn-secondary-custom">
                        <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                    </a>
                    <button type="submit" class="btn btn-primary-gradient">
                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
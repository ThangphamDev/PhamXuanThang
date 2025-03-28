<?php include 'app/views/shares/header.php'; ?>

<style>
    .category-form-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 15px;
    }
    
    .category-form-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        background: var(--white);
    }
    
    .category-form-header {
        background: var(--primary-gradient);
        color: var(--white);
        padding: 20px;
        font-weight: 600;
        border-radius: 10px 10px 0 0;
    }
    
    .category-form-body {
        padding: 30px;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }
    
    .form-control {
        padding: 12px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
        background-color: #f9f9f9;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(67, 160, 71, 0.2);
        border-color: var(--primary-color);
        background-color: var(--white);
    }
    
    .btn-primary-gradient {
        background: var(--primary-gradient);
        border: none;
        color: var(--white);
        border-radius: 6px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-primary-gradient:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-secondary-custom {
        background-color: #f4f4f4;
        color: var(--text-dark);
        border: none;
        border-radius: 6px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-secondary-custom:hover {
        background-color: var(--border-color);
        color: #333;
        transform: translateY(-2px);
    }
</style>

<div class="category-form-container">
    <div class="category-form-card">
        <div class="category-form-header">
            <h2 class="m-0"><i class="fas fa-plus-circle me-2"></i>Thêm danh mục</h2>
        </div>
        <div class="category-form-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/Category/add">
                <div class="mb-4">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea id="description" name="description" class="form-control" rows="3"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                </div>
                
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="/Category/" class="btn btn-secondary-custom">
                        <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                    </a>
                    <button type="submit" class="btn btn-primary-gradient">
                        <i class="fas fa-save me-2"></i> Thêm danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Đóng div main-container từ header.php -->
</div>

<!-- JavaScript cần thiết -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Footer với phần giới thiệu nhà phát triển -->

</body>
</html>

<style>
    :root {
        --primary-color: #43a047;
        --primary-dark: #2e7d32;
        --primary-light: #a5d6a7;
        --white: #ffffff;
        --light-bg: #f8f9fa;
        --text-dark: #333333;
        --text-muted: #6c757d;
        --border-color: #e9ecef;
    }

    /* Container footer */
    .developer-intro {
        background-color: var(--light-bg);
        padding: 40px 0;
        border-top: 1px solid var(--border-color);
    }

    .dev-flex-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    /* Avatar */
    .dev-avatar {
        flex: 0 0 auto;
    }

    .dev-avatar img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-color);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Thông tin */
    .dev-info {
        flex: 1;
        max-width: 700px;
    }

    .dev-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .dev-title i {
        margin-right: 10px;
        color: var(--primary-dark);
        font-size: 1.6rem;
    }

    .dev-description {
        font-size: 0.95rem;
        color: var(--text-dark);
        line-height: 1.5;
        margin-bottom: 15px;
    }

    /* Kỹ năng */
    .dev-skills {
        margin-bottom: 15px;
    }

    .skill-tag {
        display: inline-block;
        background-color: var(--primary-light);
        color: var(--primary-dark);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        margin: 0 5px 5px 0;
        transition: all 0.3s ease;
    }

    .skill-tag:hover {
        background-color: var(--primary-color);
        color: var(--white);
    }

    /* Mạng xã hội */
    .dev-social {
        display: flex;
        gap: 15px;
    }

    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: var(--white);
        font-size: 1.2rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background-color: var(--primary-dark);
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dev-flex-container {
            flex-direction: column;
            text-align: center;
            padding: 0 15px;
        }

        .dev-avatar img {
            width: 120px;
            height: 120px;
        }

        .dev-title {
            justify-content: center;
        }

        .dev-social {
            justify-content: center;
        }
    }
</style>
<?php include 'app/views/shares/footer.php'; ?>
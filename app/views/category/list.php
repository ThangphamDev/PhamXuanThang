<?php include 'app/views/shares/header.php'; ?>

<style>
    .category-list-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 15px;
    }
    
    .category-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .category-title {
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }
    
    .btn-add-category {
        background: var(--primary-gradient);
        border: none;
        color: var(--white);
        border-radius: 30px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(67, 160, 71, 0.3);
    }
    
    .btn-add-category:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(67, 160, 71, 0.4);
    }
    
    .category-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .category-table th, .category-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }
    
    .category-table th {
        background: var(--primary-gradient);
        color: var(--white);
        font-weight: 600;
    }
    
    .category-table tr:hover {
        background-color: var(--light-bg);
    }
    
    .btn-edit {
        color: #ff9800;
        background-color: rgba(255, 152, 0, 0.1);
        border: 1px solid #ff9800;
        padding: 6px 12px;
        border-radius: 20px;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-edit:hover {
        background-color: #ff9800;
        color: var(--white);
    }
    
    .btn-delete {
        color: #f44336;
        background-color: rgba(244, 67, 54, 0.1);
        border: 1px solid #f44336;
        padding: 6px 12px;
        border-radius: 20px;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-delete:hover {
        background-color: #f44336;
        color: var(--white);
    }
    
    .empty-categories {
        background-color: var(--light-bg);
        border-radius: 10px;
        padding: 60px 30px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .empty-icon {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 20px;
    }
</style>

<div class="category-list-container">
    <div class="category-header">
        <h1 class="category-title">Danh sách danh mục</h1>
        <a href="/Category/add" class="btn btn-add-category">
            <i class="fas fa-plus-circle me-2"></i> Thêm danh mục mới
        </a>
    </div>

    <?php if (!empty($categories)): ?>
        <table class="category-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category->id); ?></td>
                        <td><?php echo htmlspecialchars($category->name); ?></td>
                        <td><?php echo htmlspecialchars($category->description ?? ''); ?></td>
                        <td>
                            <a href="/Category/edit/<?php echo $category->id; ?>" class="btn btn-edit">
                                <i class="fas fa-edit me-1"></i> Sửa
                            </a>
                            <a href="/Category/delete/<?php echo $category->id; ?>" 
                               class="btn btn-delete" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                <i class="fas fa-trash-alt me-1"></i> Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-categories">
            <div class="empty-icon">
                <i class="fas fa-tags"></i>
            </div>
            <h3>Chưa có danh mục nào</h3>
            <p class="text-muted">Hãy thêm danh mục đầu tiên bằng cách nhấn nút "Thêm danh mục mới"</p>
            <a href="/Category/add" class="btn btn-add-category mt-3">
                <i class="fas fa-plus-circle me-2"></i> Thêm danh mục ngay
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Đóng thẻ main-container từ header.php -->
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
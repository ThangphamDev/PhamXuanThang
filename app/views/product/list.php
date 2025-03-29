<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="/public/css/list.css">
<style>
    /* CSS cho dropdown menu */
    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 200px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        margin-top: 5px;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        display: block;
        padding: 0.75rem 1rem;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: var(--light-bg);
        color: var(--primary-color);
    }

    .dropdown-item.active {
        background-color: var(--primary-color);
        color: white;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dropdown-toggle:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .dropdown-toggle i {
        font-size: 0.9rem;
    }

    /* CSS cho ô tìm kiếm */
    .search-box {
        position: relative;
        min-width: 200px;
    }

    .search-input {
        width: 100%;
        padding: 0.5rem 1rem;
        padding-right: 2.5rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 160, 71, 0.15);
        outline: none;
    }

    .search-button {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0.5rem;
        transition: color 0.3s ease;
    }

    .search-button:hover {
        color: var(--primary-color);
    }

    /* Product Grid/List View */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        transition: all 0.3s ease;
    }

    /* Ẩn nút thêm vào giỏ dạng list view trong chế độ grid */
    .btn-add-to-cart.list-view-only {
        display: none;
    }

    .product-grid.list-view {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .product-grid.list-view .product-card {
        display: grid;
        grid-template-columns: 150px 1fr auto;
        align-items: start;
        padding: 15px;
        gap: 20px;
        background: var(--white);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .product-grid.list-view .product-thumb {
        width: 150px;
        height: 150px;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
    }

    .product-grid.list-view .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-grid.list-view .product-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-right: 15px;
    }

    .product-grid.list-view .product-actions-quick {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .product-grid.list-view .hover-action {
        position: static;
        opacity: 1;
        transform: none;
        margin-top: auto;
    }

    .product-grid.list-view .product-category {
        font-size: 0.85rem;
        color: var(--primary-color);
        margin-bottom: 2px;
    }

    .product-grid.list-view .product-name {
        font-size: 1.1rem;
        margin: 0;
        line-height: 1.4;
        font-weight: 500;
    }

    .product-grid.list-view .product-name a {
        color: var(--text-dark);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .product-grid.list-view .product-name a:hover {
        color: var(--primary-color);
    }

    .product-grid.list-view .product-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .product-grid.list-view .product-price {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 4px;
    }

    .product-grid.list-view .current-price {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
    }

    .product-grid.list-view .old-price {
        font-size: 1rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }

    .product-grid.list-view .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--white);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .product-grid.list-view .action-btn:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
        transform: translateY(-1px);
    }

    .product-grid.list-view .btn-add-to-cart.list-view-only {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: var(--primary-color);
        color: var(--white);
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .product-grid.list-view .btn-add-to-cart.list-view-only:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .product-grid.list-view .btn-add-to-cart.list-view-only i {
        font-size: 1rem;
    }

    .product-grid.list-view .product-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        display: flex;
        gap: 5px;
    }

    .product-grid.list-view .badge {
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 4px;
    }

    .product-grid.list-view .badge-sale {
        background: #ff4757;
        color: white;
    }

    .product-grid.list-view .badge-new {
        background: #2ed573;
        color: white;
    }

    @media (max-width: 768px) {
        .product-grid.list-view .product-card {
            grid-template-columns: 120px 1fr;
        }

        .product-grid.list-view .product-thumb {
            width: 120px;
            height: 120px;
        }

        .product-grid.list-view .product-actions-quick {
            display: none;
        }
    }

    /* View Toggle Buttons */
    .view-toggle {
        display: flex;
        gap: 8px;
        margin-left: 15px;
    }

    .view-toggle button {
        background: none;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 6px 10px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .view-toggle button:hover {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .view-toggle button.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .view-toggle button i {
        font-size: 1rem;
    }

    /* CSS cho thanh trượt giá cải tiến */
    .price-range {
        padding: 5px 0 20px;
    }
    
    .range-slider {
        position: relative;
        width: 100%;
        height: 30px;
        margin-bottom: 15px;
    }
    
    .range-track {
        position: absolute;
        width: 100%;
        height: 4px;
        background-color: #e0e0e0;
        border-radius: 2px;
        top: 13px;
    }
    
    .range-selection {
        position: absolute;
        height: 4px;
        background-color: #4CAF50;
        border-radius: 2px;
        top: 13px;
    }
    
    .range-min, .range-max {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        height: 4px;
        background: transparent;
        position: absolute;
        top: 13px;
        pointer-events: none;
    }
    
    .range-min::-webkit-slider-thumb, .range-max::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #4CAF50;
        cursor: pointer;
        margin-top: -7px;
        pointer-events: auto;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
    }
    
    .range-min::-moz-range-thumb, .range-max::-moz-range-thumb {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #4CAF50;
        cursor: pointer;
        pointer-events: auto;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
    }
    
    .range-min:hover::-webkit-slider-thumb, .range-max:hover::-webkit-slider-thumb,
    .range-min:active::-webkit-slider-thumb, .range-max:active::-webkit-slider-thumb {
        width: 22px;
        height: 22px;
        margin-top: -9px;
        background: #3d8b40;
    }
    
    .range-min:hover::-moz-range-thumb, .range-max:hover::-moz-range-thumb,
    .range-min:active::-moz-range-thumb, .range-max:active::-moz-range-thumb {
        width: 22px;
        height: 22px;
        background: #3d8b40;
    }
    
    .range-min::-webkit-slider-runnable-track, .range-max::-webkit-slider-runnable-track,
    .range-min::-moz-range-track, .range-max::-moz-range-track {
        cursor: pointer;
        background: transparent;
        border: none;
    }
    
    .range-values {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }
    
    #price-min-value, #price-max-value {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        background: #f5f5f5;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    #price-min-value:hover, #price-max-value:hover {
        background: #e9e9e9;
    }

    /* CSS cho dropdown filter giá */
    .price-filter-dropdown {
        position: relative;
        width: 100%;
    }
    
    .price-select {
        appearance: none;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-dark);
        font-weight: 500;
    }
    
    .price-select:hover {
        border-color: var(--primary-color);
    }
    
    .price-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
    }
    
    .dropdown-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
        transition: all 0.3s ease;
    }
    
    .price-filter-dropdown:hover .dropdown-icon {
        color: var(--primary-color);
    }

    /* CSS cho dropdown filter danh mục */
    .category-filter-dropdown {
        position: relative;
        width: 100%;
    }
    
    .category-select {
        appearance: none;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-dark);
        font-weight: 500;
    }
    
    .category-select:hover {
        border-color: var(--primary-color);
    }
    
    .category-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
    }
    
    .category-filter-dropdown .dropdown-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
        transition: all 0.3s ease;
    }
    
    .category-filter-dropdown:hover .dropdown-icon {
        color: var(--primary-color);
    }

    /* CSS cho dropdown filter đánh giá */
    .rating-filter-dropdown {
        position: relative;
        width: 100%;
    }
    
    .rating-select {
        appearance: none;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-dark);
        font-weight: 500;
    }
    
    .rating-select:hover {
        border-color: var(--primary-color);
    }
    
    .rating-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
    }
    
    .rating-filter-dropdown .dropdown-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
        transition: all 0.3s ease;
    }
    
    .rating-filter-dropdown:hover .dropdown-icon {
        color: var(--primary-color);
    }
    
    /* Hiển thị sao vàng trong option */
    .rating-select option i, .rating-select option .fa-star {
        color: #FFCC00;
    }

    /* CSS cho phần bestseller */
    .bestseller-section {
        margin: 50px 0;
        padding: 30px 0;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .section-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.8rem;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .bestseller-grid {
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    }

    .badge-bestseller {
        background-color: #ff6b6b;
        color: white;
    }

    @media (max-width: 768px) {
        .bestseller-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .bestseller-section {
            margin: 30px 0;
            padding: 20px 0;
        }
    }

    @media (max-width: 576px) {
        .bestseller-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .section-title {
            font-size: 1.3rem;
        }
        
        .section-subtitle {
            font-size: 0.9rem;
        }
    }
</style>
<!-- Banner quảng cáo hiện đại -->
<div class="hero-banner">
    <div class="container">
        <div class="banner-wrapper">
            <div class="banner-content">
                <span class="promo-label">Ưu đãi tháng 3</span>
                <h1 class="banner-title">Giảm giá đến <span class="highlight">33%</span></h1>
                <p class="banner-subtitle">Nhập mã <span class="promo-code">SPRING33</span> khi thanh toán</p>
                <div class="banner-cta">
                    <a href="#product-section" class="btn-primary">Khám phá ngay</a>
                    <a href="#bestseller-section" class="btn-secondary">Xem sản phẩm bán chạy</a>
                </div>
            </div>
            <!-- Thay thế phần decoration bằng hình ảnh banner -->
            <div class="banner-image-right">
                <img src="/public/images/banner.jpg" alt="Banner khuyến mãi tháng 3" class="banner-img">
            </div>
        </div>
    </div>
</div>

<!-- Phần danh mục sản phẩm -->
<div class="container">
    <div class="section-catalog" id="product-section">
        <!-- Điều hướng và tìm kiếm -->
        <div class="catalog-header">
            <div class="breadcrumb">
                <a href="/" class="breadcrumb-item">Trang chủ</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item active">Danh sách sản phẩm</span>
            </div>
            
            <div class="catalog-tools">
                <div class="search-box">
                    <input type="text" placeholder="Tìm kiếm sản phẩm..." class="search-input">
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <div class="filter-sort">
                    <div class="dropdown">
                        <button class="dropdown-toggle">
                            <span>Phổ biến nhất</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item active" data-sort="popular">Phổ biến nhất</a>
                            <a href="#" class="dropdown-item" data-sort="price_asc">Giá: Thấp đến cao</a>
                            <a href="#" class="dropdown-item" data-sort="price_desc">Giá: Cao đến thấp</a>
                            <a href="#" class="dropdown-item" data-sort="newest">Mới nhất</a>
                        </div>
                    </div>
                    
                    <div class="view-toggle">
                        <button class="grid-view active" title="Xem dạng lưới">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="list-view" title="Xem dạng danh sách">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bộ lọc và danh sách sản phẩm -->
        <div class="catalog-content">
            <!-- Bộ lọc bên trái -->
            <div class="catalog-sidebar">
                <div class="sidebar-heading">
                    <h3>Bộ lọc</h3>
                    <button class="btn-clear-filter" onclick="clearAllFilters()">Xóa tất cả</button>
                </div>
                
                <div class="filter-group">
                    <h4 class="filter-title">Danh mục</h4>
                    <div class="category-filter-dropdown">
                        <select class="category-select" onchange="handleCategorySelectChange(this)">
                            <option value="all" <?php echo (!isset($_GET['category']) || $_GET['category'] === 'all') ? 'selected' : ''; ?>>Tất cả</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $category->id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name); ?> (<?php echo $category->product_count ?? 0; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                </div>
                
                <div class="filter-group">
                    <h4 class="filter-title">Giá</h4>
                    <div class="price-filter-dropdown">
                        <select class="price-select" onchange="handlePriceSelectChange(this)">
                            <option value="" <?php echo (!isset($_GET['min_price']) && !isset($_GET['max_price'])) ? 'selected' : ''; ?>>Tất cả</option>
                            <option value="0-500000" <?php echo (isset($_GET['min_price']) && $_GET['min_price'] == '0' && isset($_GET['max_price']) && $_GET['max_price'] == '500000') ? 'selected' : ''; ?>>Dưới 500K</option>
                            <option value="500000-1000000" <?php echo (isset($_GET['min_price']) && $_GET['min_price'] == '500000' && isset($_GET['max_price']) && $_GET['max_price'] == '1000000') ? 'selected' : ''; ?>>500K - 1Tr</option>
                            <option value="1000000-10000000" <?php echo (isset($_GET['min_price']) && $_GET['min_price'] == '1000000' && isset($_GET['max_price']) && $_GET['max_price'] == '10000000') ? 'selected' : ''; ?>>1Tr - 10Tr</option>
                            <option value="10000000-100000000" <?php echo (isset($_GET['min_price']) && $_GET['min_price'] == '10000000' && isset($_GET['max_price']) && $_GET['max_price'] == '100000000') ? 'selected' : ''; ?>>10Tr - 100Tr</option>
                            <option value="100000000-999999999" <?php echo (isset($_GET['min_price']) && $_GET['min_price'] == '100000000') ? 'selected' : ''; ?>>Trên 100Tr</option>
                        </select>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                </div>
                
                <div class="filter-group">
                    <h4 class="filter-title">Đánh giá</h4>
                    <div class="rating-filter-dropdown">
                        <select class="rating-select" onchange="handleRatingSelectChange(this)">
                            <option value="" <?php echo (!isset($_GET['rating'])) ? 'selected' : ''; ?>>Tất cả đánh giá</option>
                            <?php for($i = 5; $i >= 1; $i--): ?>
                            <option value="<?php echo $i; ?>" <?php echo (isset($_GET['rating']) && $_GET['rating'] == $i) ? 'selected' : ''; ?>>
                                <?php 
                                // Hiển thị số sao bằng nhiều icon sao
                                for($j = 1; $j <= $i; $j++): ?>
                                ★
                                <?php endfor; ?>
                                <?php 
                                // Hiển thị sao trống cho phần còn lại
                                for($j = $i+1; $j <= 5; $j++): ?>
                                ☆
                                <?php endfor; ?>
                                trở lên
                            </option>
                            <?php endfor; ?>
                        </select>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>
                </div>
                
                <?php if (SessionHelper::isAdmin()): ?>
                <a href="/Product/add" class="btn-add-product sidebar-cta">
                    <i class="fas fa-plus-circle"></i>
                    <span>Thêm sản phẩm mới</span>
                </a>
                <?php endif; ?>
            </div>
            
            <!-- Danh sách sản phẩm chính -->
            <div class="catalog-main">
                <?php if (!empty($products)): ?>
                    <div class="product-grid">
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <div class="product-badges">
                                    <span class="badge badge-sale">-33%</span>
                                    <?php if (rand(0, 1)): ?>
                                        <span class="badge badge-new">New</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-actions-quick">
                                    <button class="action-btn btn-wishlist" title="Thêm vào yêu thích">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="action-btn btn-compare" title="So sánh">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button class="action-btn btn-quickview" title="Xem nhanh">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                
                                <div class="product-thumb">
                                    <a href="/Product/show/<?php echo $product->id; ?>" class="image-wrapper">
                                        <?php if (!empty($product->image)): ?>
                                            <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                                alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                                class="product-img">
                                        <?php else: ?>
                                            <div class="no-image">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <div class="hover-action">
                                        <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn-add-to-cart">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Thêm vào giỏ</span>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="product-info">
                                    <?php if (!empty($product->category_name)): ?>
                                        <div class="product-category">
                                            <a href="/category/<?php echo strtolower($product->category_name); ?>">
                                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <h3 class="product-name">
                                        <a href="/Product/show/<?php echo $product->id; ?>">
                                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </a>
                                    </h3>
                                    
                                    <div class="product-rating">
                                        <div class="stars">
                                            <?php 
                                            // Đảm bảo rating là số hợp lệ
                                            $rating = isset($product->rating) ? floatval($product->rating) : 0;
                                            // Hiển thị 5 sao với class active cho những sao đạt rating
                                            for ($i = 1; $i <= 5; $i++): 
                                            ?>
                                                <i class="fas fa-star <?php echo ($i <= $rating) ? 'active' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="rating-count">(<?php echo $product->rating_count ?? 0; ?>)</span>
                                    </div>
                                    
                                    <div class="product-price">
                                        <span class="current-price"><?php echo number_format($product->price, 0, ',', '.'); ?>₫</span>
                                        <?php if (!empty($product->old_price) && $product->old_price > $product->price): ?>
                                            <span class="old-price"><?php echo number_format($product->old_price, 0, ',', '.'); ?>₫</span>
                                            <?php 
                                                $discount_percent = round(($product->old_price - $product->price) / $product->old_price * 100);
                                            ?>
                                            <span class="discount-badge">-<?php echo $discount_percent; ?>%</span>
                                        <?php else: ?>
                                            <?php 
                                                $original_price = round($product->price / 0.67);
                                            ?>
                                            <span class="old-price"><?php echo number_format($original_price, 0, ',', '.'); ?>₫</span>
                                            <span class="discount-badge">-33%</span>
                                        <?php endif; ?>
                                    </div>

                                    <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn-add-to-cart list-view-only">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Thêm vào giỏ</span>
                                    </a>
                                    
                                    <?php if (SessionHelper::isAdmin()): ?>
                                    <div class="product-actions">
                                        <a href="/Product/edit/<?php echo $product->id; ?>" class="btn-edit">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="/Product/delete/<?php echo $product->id; ?>" class="btn-delete" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="pagination">
                        <?php if (isset($pagination) && $pagination['total_pages'] > 0): ?>
                            <a href="?page=<?php echo max(1, $pagination['current_page'] - 1); ?>" 
                               class="page-item prev <?php echo $pagination['current_page'] <= 1 ? 'disabled' : ''; ?>"
                               data-page="<?php echo max(1, $pagination['current_page'] - 1); ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            
                            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                <?php 
                                // Hiển thị trang đầu, trang cuối và các trang xung quanh trang hiện tại
                                $show_page = $i == 1 || $i == $pagination['total_pages'] || 
                                             abs($i - $pagination['current_page']) <= 1;
                                
                                // Hiển thị dấu "..." nếu cần
                                $show_dots = ($i == $pagination['current_page'] - 2 && $i > 1) || 
                                             ($i == $pagination['current_page'] + 2 && $i < $pagination['total_pages']);
                                
                                if ($show_page): ?>
                                    <a href="?page=<?php echo $i; ?>" 
                                       class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>"
                                       data-page="<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php elseif ($show_dots): ?>
                                    <span class="page-dots">...</span>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <a href="?page=<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>" 
                               class="page-item next <?php echo $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : ''; ?>"
                               data-page="<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <a href="#" class="page-item prev disabled">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#" class="page-item active">1</a>
                            <a href="#" class="page-item next disabled">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h2 class="empty-state-title">Chưa có sản phẩm nào</h2>
                        <p class="empty-state-description">Hãy thêm sản phẩm đầu tiên của bạn để bắt đầu kinh doanh</p>
                        <a href="/Product/add" class="btn-add-product empty-state-cta">
                            <i class="fas fa-plus-circle"></i>
                            <span>Thêm sản phẩm ngay</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Phần sản phẩm bán chạy -->
    <div class="bestseller-section" id="bestseller-section">
        <div class="section-header">
            <h2 class="section-title">Sản phẩm bán chạy</h2>
            <p class="section-subtitle">Những sản phẩm được khách hàng yêu thích nhất</p>
        </div>
        
        <div class="product-grid bestseller-grid">
            <?php 
            // Hiển thị 4 sản phẩm bán chạy đầu tiên (nếu có)
            $bestsellers = array_slice($products, 0, 4);
            foreach ($bestsellers as $product): 
            ?>
                <div class="product-card">
                    <div class="product-badges">
                        <span class="badge badge-sale">-33%</span>
                        <span class="badge badge-bestseller">Hot</span>
                    </div>
                    
                    <div class="product-thumb">
                        <a href="/Product/show/<?php echo $product->id; ?>" class="image-wrapper">
                            <?php if (!empty($product->image)): ?>
                                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                    alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                    class="product-img">
                            <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                        
                        <div class="hover-action">
                            <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn-add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Thêm vào giỏ</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="product-info">
                        <?php if (!empty($product->category_name)): ?>
                            <div class="product-category">
                                <a href="/category/<?php echo strtolower($product->category_name); ?>">
                                    <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="product-name">
                            <a href="/Product/show/<?php echo $product->id; ?>">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h3>
                        
                        <div class="product-rating">
                            <div class="stars">
                                <?php 
                                // Đảm bảo rating là số hợp lệ
                                $rating = isset($product->rating) ? floatval($product->rating) : 0;
                                // Hiển thị 5 sao với class active cho những sao đạt rating
                                for ($i = 1; $i <= 5; $i++): 
                                ?>
                                    <i class="fas fa-star <?php echo ($i <= $rating) ? 'active' : ''; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-count">(<?php echo $product->rating_count ?? 0; ?>)</span>
                        </div>
                        
                        <div class="product-price">
                            <span class="current-price"><?php echo number_format($product->price, 0, ',', '.'); ?>₫</span>
                            <?php if (!empty($product->old_price) && $product->old_price > $product->price): ?>
                                <span class="old-price"><?php echo number_format($product->old_price, 0, ',', '.'); ?>₫</span>
                                <?php 
                                    $discount_percent = round(($product->old_price - $product->price) / $product->old_price * 100);
                                ?>
                                <span class="discount-badge">-<?php echo $discount_percent; ?>%</span>
                            <?php else: ?>
                                <?php 
                                    $original_price = round($product->price / 0.67);
                                ?>
                                <span class="old-price"><?php echo number_format($original_price, 0, ',', '.'); ?>₫</span>
                                <span class="discount-badge">-33%</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/list.js"></script>
<script>
let timeout;
const productGrid = document.querySelector('.product-grid');

// Thêm biến để lưu timeout
let searchTimeout;

// Thêm hàm xử lý tìm kiếm
function handleSearch() {
    const searchInput = document.querySelector('.catalog-tools .search-input');
    const searchButton = document.querySelector('.catalog-tools .search-button');
    if (!searchInput) return;

    // Xử lý khi nhấn nút tìm kiếm
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            const keyword = searchInput.value.trim();
            if (keyword.length >= 2) {
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('keyword', keyword);
                urlParams.set('page', 1); // Reset về trang 1 khi tìm kiếm
                
                fetch(`/Product/search?${urlParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateProductGrid(data.products);
                    updatePagination(data.pagination);
                    scrollToBreadcrumb();
                })
                .catch(error => console.error('Error searching products:', error));
            }
        });
    }

    // Xử lý khi gõ
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const keyword = this.value.trim();
        
        // Đợi 300ms sau khi người dùng ngừng gõ
        searchTimeout = setTimeout(() => {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', 1); // Reset về trang 1 khi tìm kiếm
            
            if (keyword.length >= 2) {
                urlParams.set('keyword', keyword);
                fetch(`/Product/search?${urlParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateProductGrid(data.products);
                    updatePagination(data.pagination);
                    scrollToBreadcrumb();
                })
                .catch(error => console.error('Error searching products:', error));
            } else {
                // Nếu từ khóa quá ngắn, hiển thị tất cả sản phẩm
                urlParams.delete('keyword');
                fetch(`/Product/search?${urlParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateProductGrid(data.products);
                    updatePagination(data.pagination);
                    scrollToBreadcrumb();
                })
                .catch(error => console.error('Error fetching products:', error));
            }
        }, 300);
    });
}

// Thêm hàm xử lý sắp xếp
function handleSort() {
    const dropdownToggle = document.querySelector('.catalog-tools .dropdown-toggle');
    const dropdownMenu = document.querySelector('.catalog-tools .dropdown-menu');
    const dropdownItems = document.querySelectorAll('.catalog-tools .dropdown-menu .dropdown-item');
    
    if (!dropdownToggle || !dropdownMenu || !dropdownItems.length) return;

    // Toggle dropdown menu khi click vào nút sắp xếp
    dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });

    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });

    // Xử lý khi chọn option
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            dropdownItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            const dropdownToggleText = dropdownToggle.querySelector('span');
            if (dropdownToggleText) {
                dropdownToggleText.textContent = this.textContent;
            }
            
            const sortValue = this.getAttribute('data-sort');
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort', sortValue);
            urlParams.set('page', 1); // Reset về trang 1 khi sắp xếp
            
            fetch(`/Product/sort?${urlParams.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateProductGrid(data.products);
                updatePagination(data.pagination);
                dropdownMenu.classList.remove('show');
                scrollToBreadcrumb();
            })
            .catch(error => console.error('Error sorting products:', error));
        });
    });
}

function updateProductGrid(products) {
    if (!productGrid) return;
    productGrid.innerHTML = '';
    
    if (products.length === 0) {
        productGrid.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 class="empty-state-title">Không tìm thấy sản phẩm nào</h2>
                <p class="empty-state-description">Vui lòng thử lại với điều kiện tìm kiếm khác</p>
            </div>
        `;
        return;
    }
    
    products.forEach(product => {
        const productCard = `
            <div class="product-card">
                <div class="product-badges">
                    <span class="badge badge-sale">-33%</span>
                    ${Math.random() > 0.5 ? '<span class="badge badge-new">New</span>' : ''}
                </div>
                
                <div class="product-actions-quick">
                    <button class="action-btn btn-wishlist" title="Thêm vào yêu thích">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="action-btn btn-compare" title="So sánh">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    <button class="action-btn btn-quickview" title="Xem nhanh">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                
                <div class="product-thumb">
                    <a href="/Product/show/${product.id}" class="image-wrapper">
                        ${product.image ? 
                            `<img src="/${product.image}" alt="${product.name}" class="product-img">` :
                            `<div class="no-image"><i class="fas fa-image"></i></div>`
                        }
                    </a>
                    
                    <div class="hover-action">
                        <a href="/Product/addToCart/${product.id}" class="btn-add-to-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Thêm vào giỏ</span>
                        </a>
                    </div>
                </div>
                
                <div class="product-info">
                    ${product.category_name ? 
                        `<div class="product-category">
                            <a href="/category/${product.category_name.toLowerCase()}">${product.category_name}</a>
                        </div>` : ''
                    }
                    
                    <h3 class="product-name">
                        <a href="/Product/show/${product.id}">${product.name}</a>
                    </h3>
                    
                    <div class="product-rating">
                        <div class="stars">
                            ${Array(5).fill().map((_, i) => 
                                `<i class="fas fa-star ${i < parseFloat(product.rating || 0) ? 'active' : ''}"></i>`
                            ).join('')}
                        </div>
                        <span class="rating-count">(${product.rating_count || 0})</span>
                    </div>
                    
                    <div class="product-price">
                        <span class="current-price">${new Intl.NumberFormat('vi-VN').format(product.price)}₫</span>
                        ${product.old_price && product.old_price > product.price ? 
                            `<span class="old-price">${new Intl.NumberFormat('vi-VN').format(product.old_price)}₫</span>
                             <span class="discount-badge">-${Math.round((product.old_price - product.price) / product.old_price * 100)}%</span>` :
                            `<span class="old-price">${new Intl.NumberFormat('vi-VN').format(Math.round(product.price / 0.67))}₫</span>
                             <span class="discount-badge">-33%</span>`
                        }
                    </div>
                    
                    <a href="/Product/addToCart/${product.id}" class="btn-add-to-cart list-view-only">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Thêm vào giỏ</span>
                    </a>
                    
                    <?php if (SessionHelper::isAdmin()): ?>
                    <div class="product-actions">
                        <a href="/Product/edit/${product.id}" class="btn-edit">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="/Product/delete/${product.id}" class="btn-delete" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        `;
        productGrid.insertAdjacentHTML('beforeend', productCard);
    });
}

function updatePagination(pagination) {
    const paginationContainer = document.querySelector('.pagination');
    if (!paginationContainer || !pagination) return;
    
    let paginationHTML = '';
    
    // Nút Previous
    paginationHTML += `
        <a href="#" class="page-item prev ${pagination.current_page <= 1 ? 'disabled' : ''}" 
           data-page="${Math.max(1, pagination.current_page - 1)}">
            <i class="fas fa-chevron-left"></i>
        </a>
    `;
    
    // Số trang
    for (let i = 1; i <= pagination.total_pages; i++) {
        // Hiển thị trang đầu, trang cuối và các trang xung quanh trang hiện tại
        const showPage = i === 1 || i === pagination.total_pages || 
                         Math.abs(i - pagination.current_page) <= 1;
        
        // Hiển thị dấu "..." nếu cần
        const showDots = (i === pagination.current_page - 2 && i > 1) || 
                         (i === pagination.current_page + 2 && i < pagination.total_pages);
        
        if (showPage) {
            paginationHTML += `
                <a href="#" class="page-item ${i === pagination.current_page ? 'active' : ''}" 
                   data-page="${i}">${i}</a>
            `;
        } else if (showDots) {
            paginationHTML += '<span class="page-dots">...</span>';
        }
    }
    
    // Nút Next
    paginationHTML += `
        <a href="#" class="page-item next ${pagination.current_page >= pagination.total_pages ? 'disabled' : ''}" 
           data-page="${Math.min(pagination.total_pages, pagination.current_page + 1)}">
            <i class="fas fa-chevron-right"></i>
        </a>
    `;
    
    paginationContainer.innerHTML = paginationHTML;
    
    // Thêm event listeners cho các nút phân trang
    document.querySelectorAll('.pagination .page-item:not(.disabled)').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            if (this.classList.contains('disabled')) return;
            
            const page = parseInt(this.getAttribute('data-page'));
            const urlParams = new URLSearchParams(window.location.search);
            
            // Giữ lại tất cả tham số hiện tại và chỉ cập nhật trang
            urlParams.set('page', page);
            
            // Cập nhật URL không reload trang
            window.history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
            
            // Lấy các tham số lọc hiện tại
            const currentFilters = {
                category: urlParams.get('category'),
                min_price: urlParams.get('min_price'),
                max_price: urlParams.get('max_price'),
                rating: urlParams.get('rating'),
                keyword: urlParams.get('keyword'),
                sort: urlParams.get('sort')
            };
            
            // Xác định API endpoint dựa vào lọc hiện tại
            let endpoint = '/Product/filter';
            if (currentFilters.keyword) {
                endpoint = '/Product/search';
            } else if (currentFilters.sort && !currentFilters.category && !currentFilters.min_price && !currentFilters.max_price && !currentFilters.rating) {
                endpoint = '/Product/sort';
            }
            
            // Gọi API với tất cả tham số hiện tại
            fetch(`${endpoint}?${urlParams.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateProductGrid(data.products);
                updatePagination(data.pagination);
                
                // Cập nhật số lượng sản phẩm trong các danh mục
                if (data.categories) {
                    data.categories.forEach(category => {
                        const countElement = document.querySelector(`input[value="${category.id}"]`)
                            ?.closest('.filter-option')
                            ?.querySelector('.option-count');
                        if (countElement) {
                            countElement.textContent = `(${category.product_count})`;
                        }
                    });
                }
                
                // Cuộn đến phần breadcrumb
                scrollToBreadcrumb();
            })
            .catch(error => console.error('Error fetching products:', error));
        });
    });
}

async function applyFilters() {
    const urlParams = new URLSearchParams(window.location.search);
    const category = document.querySelector('.category-select').value;
    const rating = document.querySelector('.rating-select').value;
    
    // Lấy giá trị min_price và max_price từ URL nếu đã có
    const minPrice = urlParams.get('min_price');
    const maxPrice = urlParams.get('max_price');
    
    // Giữ lại tham số sort nếu có
    const sort = urlParams.get('sort');
    
    // Xóa tất cả tham số hiện tại
    for (const key of [...urlParams.keys()]) {
        urlParams.delete(key);
    }
    
    // Thêm lại các tham số lọc
    if (category && category !== 'all') {
        urlParams.set('category', category);
    }
    
    if (rating) urlParams.set('rating', rating);
    if (minPrice) urlParams.set('min_price', minPrice);
    if (maxPrice) urlParams.set('max_price', maxPrice);
    if (sort) urlParams.set('sort', sort);
    
    // Reset về trang 1 khi lọc
    urlParams.set('page', 1);
    
    // Cập nhật URL không reload trang
    window.history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);

    try {
        const endpoint = '/Product/filter';
        
        const response = await fetch(`${endpoint}?${urlParams.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        updateProductGrid(data.products);
        updatePagination(data.pagination);
        
        // Cập nhật số lượng sản phẩm cho mỗi danh mục
        if (data.categories) {
            // Cập nhật tùy chọn trong dropdown danh mục
            const categorySelect = document.querySelector('.category-select');
            if (categorySelect) {
                const options = categorySelect.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value !== 'all') {
                        const categoryData = data.categories.find(cat => cat.id == option.value);
                        if (categoryData) {
                            option.textContent = `${categoryData.name} (${categoryData.product_count})`;
                        }
                    }
                });
            }
        }
        
        // Cuộn đến phần breadcrumb
        scrollToBreadcrumb();
    } catch (error) {
        console.error('Error applying filters:', error);
    }
}

function handleCategorySelectChange(select) {
    const selectedValue = select.value;
    const urlParams = new URLSearchParams(window.location.search);
    
    if (selectedValue && selectedValue !== 'all') {
        urlParams.set('category', selectedValue);
    } else {
        urlParams.delete('category');
    }
    
    urlParams.set('page', 1);
    window.history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
    
    applyFilters();
}

function handleRatingSelectChange(select) {
    const selectedValue = select.value;
    const urlParams = new URLSearchParams(window.location.search);
    
    if (selectedValue) {
        urlParams.set('rating', selectedValue);
    } else {
        urlParams.delete('rating');
    }
    
    urlParams.set('page', 1);
    window.history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
    
    applyFilters();
}

function handlePriceSelectChange(select) {
    const selectedValue = select.value;
    const urlParams = new URLSearchParams(window.location.search);
    
    if (selectedValue) {
        const [minPrice, maxPrice] = selectedValue.split('-');
        urlParams.set('min_price', minPrice);
        urlParams.set('max_price', maxPrice);
    } else {
        urlParams.delete('min_price');
        urlParams.delete('max_price');
    }
    
    urlParams.set('page', 1);
    window.history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
    
    applyFilters();
}

function clearAllFilters() {
    // Reset dropdown danh mục về "Tất cả"
    document.querySelector('.category-select').value = 'all';
    
    // Reset dropdown giá về "Tất cả"
    document.querySelector('.price-select').value = '';
    
    // Reset dropdown đánh giá về "Tất cả"
    document.querySelector('.rating-select').value = '';
    
    // Áp dụng bộ lọc với giá trị mặc định
    applyFilters();
}

// Xử lý chuyển đổi hiển thị lưới/danh sách
function handleViewToggle() {
    const gridViewBtn = document.querySelector('.view-toggle .grid-view');
    const listViewBtn = document.querySelector('.view-toggle .list-view');
    
    if (!gridViewBtn || !listViewBtn || !productGrid) return;

    // Lấy view đã lưu từ localStorage hoặc mặc định là grid
    const savedView = localStorage.getItem('productView') || 'grid';
    if (savedView === 'list') {
        productGrid.classList.add('list-view');
        gridViewBtn.classList.remove('active');
        listViewBtn.classList.add('active');
    }

    // Xử lý click vào nút grid view
    gridViewBtn.addEventListener('click', function() {
        productGrid.classList.remove('list-view');
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
        localStorage.setItem('productView', 'grid');
    });

    // Xử lý click vào nút list view
    listViewBtn.addEventListener('click', function() {
        productGrid.classList.add('list-view');
        gridViewBtn.classList.remove('active');
        listViewBtn.classList.add('active');
        localStorage.setItem('productView', 'list');
    });
}

// Thêm hàm cập nhật số lượng giỏ hàng
function updateCartCount(count) {
    // Cập nhật tất cả các phần tử hiển thị số lượng giỏ hàng
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(element => {
        if (element) {
            element.textContent = count;
            // Hiển thị badge nếu có sản phẩm trong giỏ hàng
            if (count > 0) {
                element.style.display = 'inline-block';
            } else {
                element.style.display = 'none';
            }
        }
    });
}

// Cập nhật hàm handleAddToCart
function handleAddToCart() {
    document.addEventListener('click', function(e) {
        const addToCartBtn = e.target.closest('.btn-add-to-cart');
        if (!addToCartBtn) return;
        
        e.preventDefault();
        const productId = addToCartBtn.getAttribute('href').split('/').pop();
        
        // Thêm hiệu ứng loading
        addToCartBtn.classList.add('loading');
        const originalText = addToCartBtn.innerHTML;
        addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
        
        fetch(`/Product/addToCartAjax/${productId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cập nhật số lượng trong giỏ hàng
                updateCartCount(data.cartCount);
                
                // Hiển thị thông báo thành công
                showNotification('success', data.message);
            } else {
                throw new Error(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', error.message);
        })
        .finally(() => {
            // Khôi phục nút sau khi hoàn thành
            setTimeout(() => {
                addToCartBtn.classList.remove('loading');
                addToCartBtn.innerHTML = originalText;
            }, 500);
        });
    });
}

// Thêm hàm hiển thị thông báo
function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Thêm class để hiển thị notification với animation
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Xóa notification sau 3 giây
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Khởi tạo khi trang đã tải xong
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các chức năng
    handleSearch();
    handleSort();
    handleViewToggle();
    handleAddToCart();
    
    // Khởi tạo phân trang nếu cần
    const paginationData = <?php echo isset($pagination) ? json_encode($pagination) : 'null'; ?>;
    if (paginationData) {
        updatePagination(paginationData);
    }
    
    // Đảm bảo số lượng sản phẩm trong danh mục được hiển thị đúng khi tải trang
    if (document.querySelector('.category-select').value === 'all') {
        // Nếu đang ở chế độ "Tất cả", cần lấy số lượng sản phẩm cho mỗi danh mục
        updateCategoryCounts();
    }
    
    // Thêm CSS cho notification
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: -300px;
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(-320px);
        }
        
        .notification.success {
            border-left: 4px solid #43a047;
        }
        
        .notification.error {
            border-left: 4px solid #e53935;
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .notification i {
            font-size: 1.2rem;
        }
        
        .notification.success i {
            color: #43a047;
        }
        
        .notification.error i {
            color: #e53935;
        }
    `;
    document.head.appendChild(style);

    // Thêm CSS cho loading state
    const loadingStyle = document.createElement('style');
    loadingStyle.textContent = `
        .btn-add-to-cart.loading {
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn-add-to-cart.loading .fa-spinner {
            margin-right: 5px;
        }
    `;
    document.head.appendChild(loadingStyle);

    // Thêm CSS cho cart count
    const cartCountStyle = document.createElement('style');
    cartCountStyle.textContent = `
        .cart-count {
            display: inline-block;
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ff4757;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            min-width: 18px;
            text-align: center;
        }
        
        .cart-count:empty {
            display: none;
        }
    `;
    document.head.appendChild(cartCountStyle);

    // Xử lý cuộn mượt đến phần sản phẩm khi nhấp vào "Khám phá ngay"
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (!targetElement) return;
            
            // Cuộn đến vị trí mục tiêu với hiệu ứng mượt
            window.scrollTo({
                top: targetElement.offsetTop - 80, // Trừ đi chiều cao của header
                behavior: 'smooth'
            });
        });
    });
});

// Hàm cập nhật số lượng sản phẩm cho mỗi danh mục
async function updateCategoryCounts() {
    try {
        const response = await fetch('/Product/getCategoryCounts', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        const data = await response.json();
        
        if (data.categories) {
            // Cập nhật tùy chọn trong dropdown danh mục
            const categorySelect = document.querySelector('.category-select');
            if (categorySelect) {
                const options = categorySelect.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value !== 'all') {
                        const categoryData = data.categories.find(cat => cat.id == option.value);
                        if (categoryData) {
                            option.textContent = `${categoryData.name} (${categoryData.product_count})`;
                        }
                    }
                });
            }
        }
    } catch (error) {
        console.error('Error fetching category counts:', error);
    }
}

// Hàm cuộn trang đến phần breadcrumb
function scrollToBreadcrumb() {
    const breadcrumb = document.querySelector('.breadcrumb');
    if (breadcrumb) {
        window.scrollTo({
            top: breadcrumb.offsetTop - 20,
            behavior: 'smooth'
        });
    }
}
</script>
<?php include 'app/views/shares/footer.php'; ?>
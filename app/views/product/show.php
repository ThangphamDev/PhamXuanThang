<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="/public/css/show.css">

<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="/" class="breadcrumb-item">Trang chủ</a>
        <span class="breadcrumb-separator">/</span>
        <a href="/Product/list" class="breadcrumb-item">Sản phẩm</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-item active"><?php echo htmlspecialchars($product->name); ?></span>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="product-detail">
        <div class="product-gallery">
            <div class="main-image">
                <?php if (!empty($product->image)): ?>
                    <img src="/<?php echo htmlspecialchars($product->image); ?>" 
                         alt="<?php echo htmlspecialchars($product->name); ?>" 
                         id="main-product-image">
                <?php else: ?>
                    <div class="no-image">
                        <i class="fas fa-image"></i>
                        <span>Không có ảnh</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($product_images)): ?>
            <div class="thumbnail-list">
                <?php if (!empty($product->image)): ?>
                <div class="thumbnail active" data-src="/<?php echo htmlspecialchars($product->image); ?>">
                    <img src="/<?php echo htmlspecialchars($product->image); ?>" 
                         alt="<?php echo htmlspecialchars($product->name); ?>">
                </div>
                <?php endif; ?>
                
                <?php foreach($product_images as $img): ?>
                <div class="thumbnail" data-src="/<?php echo htmlspecialchars($img->image_path); ?>">
                    <img src="/<?php echo htmlspecialchars($img->image_path); ?>" 
                         alt="<?php echo htmlspecialchars($product->name); ?> - Ảnh <?php echo $img->id; ?>">
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="product-info">
            <div class="product-header">
                <h1 class="product-title"><?php echo htmlspecialchars($product->name); ?></h1>
                
                <div class="product-meta">
                    <?php if (isset($product->rating) && $product->rating > 0): ?>
                    <div class="product-rating">
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i <= $product->rating ? 'active' : ''; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="rating-count"><?php echo $product->rating; ?>/5 (<?php echo $product->rating_count ?? 0; ?> đánh giá)</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($product->category_name)): ?>
                    <div class="product-category">
                        Danh mục: <a href="/category/<?php echo htmlspecialchars(strtolower($product->category_name)); ?>">
                            <?php echo htmlspecialchars($product->category_name); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="product-sku">
                        Mã sản phẩm: <?php echo htmlspecialchars($product->sku ?? 'SP'.$product->id); ?>
                    </div>
                </div>
            </div>
            
            <div class="product-price-block">
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
                            $original_price = round($product->price / 0.67); // Tính giá gốc trước khi giảm 33%
                        ?>
                        <span class="old-price"><?php echo number_format($original_price, 0, ',', '.'); ?>₫</span>
                        <span class="discount-badge">-33%</span>
                    <?php endif; ?>
                </div>
                
                <div class="product-stock">
                    <?php if (isset($inventory)): ?>
                        <?php if ($inventory->quantity == 0): ?>
                            <span class="stock-status out-of-stock">
                                <i class="fas fa-times-circle"></i>
                                Hết hàng
                            </span>
                        <?php elseif ($inventory->quantity <= $inventory->min_quantity): ?>
                            <span class="stock-status low-stock">
                                <i class="fas fa-exclamation-triangle"></i>
                                Sắp hết hàng (Còn <?php echo $inventory->quantity; ?> sản phẩm)
                            </span>
                        <?php else: ?>
                            <span class="stock-status in-stock">
                                <i class="fas fa-check-circle"></i>
                                Còn hàng (<?php echo $inventory->quantity; ?> sản phẩm)
                            </span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (!empty($product->short_description)): ?>
            <div class="product-short-desc">
                <?php echo $product->short_description; ?>
            </div>
            <?php endif; ?>
            
            <div class="product-actions">
                <?php if (isset($inventory) && $inventory->quantity > 0): ?>
                    <form id="add-to-cart-form" class="add-to-cart-form">
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="<?php echo $inventory->quantity; ?>" class="quantity-input">
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                        <button type="button" id="add-to-cart" data-product-id="<?php echo $product->id; ?>" class="btn-add-to-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                <?php else: ?>
                    <button class="btn-out-of-stock" disabled>
                        <i class="fas fa-ban"></i>
                        Hết hàng
                    </button>
                <?php endif; ?>
                
                <button class="btn-buy-now" data-product-id="<?php echo $product->id; ?>">
                    <i class="fas fa-bolt"></i>
                    Mua ngay
                </button>
            </div>
            
            <div class="product-additional-actions">
                <button class="btn-wishlist">
                    <i class="far fa-heart"></i>
                    Thêm vào yêu thích
                </button>
                
                <button class="btn-compare">
                    <i class="fas fa-exchange-alt"></i>
                    So sánh
                </button>
            </div>
            
            <div class="product-policies">
                <div class="policy">
                    <i class="fas fa-truck"></i>
                    <div>
                        <h4>Giao hàng miễn phí</h4>
                        <p>Cho đơn hàng từ 500.000₫</p>
                    </div>
                </div>
                
                <div class="policy">
                    <i class="fas fa-sync-alt"></i>
                    <div>
                        <h4>Đổi trả dễ dàng</h4>
                        <p>Trong vòng 7 ngày</p>
                    </div>
                </div>
                
                <div class="policy">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <h4>Bảo hành chính hãng</h4>
                        <p>12 tháng bảo hành</p>
                    </div>
                </div>
            </div>
            
            <?php if (SessionHelper::isAdmin()): ?>
            <div class="admin-actions">
                <a href="/Product/edit/<?php echo $product->id; ?>" class="btn-edit">
                    <i class="fas fa-edit"></i> Chỉnh sửa sản phẩm
                </a>
                
                <a href="/Product/delete/<?php echo $product->id; ?>" class="btn-delete" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                    <i class="fas fa-trash"></i> Xóa sản phẩm
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Tabs thông tin chi tiết -->
    <div class="product-tabs">
        <div class="tabs-header">
            <button class="tab-button active" data-tab="description">Mô tả sản phẩm</button>
            <button class="tab-button" data-tab="specifications">Thông số kỹ thuật</button>
            <button class="tab-button" data-tab="reviews">Đánh giá (<?php echo $product->rating_count ?? 0; ?>)</button>
        </div>
        
        <div class="tabs-content">
            <div class="tab-pane active" id="description">
                <div class="product-description">
                    <?php if (!empty($product->description)): ?>
                        <?php echo $product->description; ?>
                    <?php else: ?>
                        <p>Chưa có mô tả chi tiết cho sản phẩm này.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="tab-pane" id="specifications">
                <?php if (!empty($product->specifications)): ?>
                    <div class="specifications-table">
                        <table>
                            <?php foreach(json_decode($product->specifications, true) as $spec => $value): ?>
                            <tr>
                                <th><?php echo htmlspecialchars($spec); ?></th>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Chưa có thông số kỹ thuật cho sản phẩm này.</p>
                <?php endif; ?>
            </div>
            
            <div class="tab-pane" id="reviews">
                <div class="reviews-container">
                    <?php if (!empty($reviews)): ?>
                        <div class="review-summary">
                            <div class="rating-average">
                                <span class="average-number"><?php echo $product->rating; ?></span>
                                <div class="average-stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo $i <= $product->rating ? 'active' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="total-ratings"><?php echo $product->rating_count; ?> đánh giá</span>
                            </div>
                            
                            <div class="rating-bars">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <?php 
                                        $count = 0;
                                        foreach ($reviews as $review) {
                                            if ($review->rating == $i) $count++;
                                        }
                                        $percent = $product->rating_count > 0 ? ($count / $product->rating_count * 100) : 0;
                                    ?>
                                    <div class="rating-bar-row">
                                        <div class="rating-label"><?php echo $i; ?> <i class="fas fa-star"></i></div>
                                        <div class="rating-bar">
                                            <div class="rating-fill" style="width: <?php echo $percent; ?>%;"></div>
                                        </div>
                                        <div class="rating-count"><?php echo $count; ?></div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="reviews-list">
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">
                                                <div class="avatar-placeholder">
                                                    <?php echo strtoupper(substr($review->user_name, 0, 1)); ?>
                                                </div>
                                            </div>
                                            <div class="reviewer-meta">
                                                <h4 class="reviewer-name"><?php echo htmlspecialchars($review->user_name); ?></h4>
                                                <div class="review-date">
                                                    <?php echo date('d/m/Y', strtotime($review->created_at)); ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="review-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo $i <= $review->rating ? 'active' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="review-content">
                                        <?php echo htmlspecialchars($review->content); ?>
                                    </div>
                                    
                                    <?php if (!empty($review->images)): ?>
                                        <div class="review-images">
                                            <?php foreach(explode(',', $review->images) as $image): ?>
                                                <div class="review-image">
                                                    <img src="/<?php echo htmlspecialchars(trim($image)); ?>" 
                                                         alt="Ảnh đánh giá">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-reviews">
                            <i class="far fa-comment-dots"></i>
                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <div class="review-form-container">
                            <h3>Viết đánh giá của bạn</h3>
                            <form action="/Product/addReview" method="post" class="review-form" enctype="multipart/form-data">
                                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                
                                <div class="form-group rating-selector">
                                    <label>Đánh giá của bạn:</label>
                                    <div class="rating-stars">
                                        <?php for ($i = 5; $i >= 1; $i--): ?>
                                            <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo $i == 5 ? 'checked' : ''; ?>>
                                            <label for="star<?php echo $i; ?>">
                                                <i class="fas fa-star"></i>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="review-content">Nội dung đánh giá:</label>
                                    <textarea id="review-content" name="content" rows="4" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hình ảnh (tùy chọn):</label>
                                    <div class="review-image-upload">
                                        <input type="file" id="review-images" name="review_images[]" multiple accept="image/*">
                                        <label for="review-images" class="upload-button">
                                            <i class="fas fa-camera"></i>
                                            <span>Thêm ảnh</span>
                                        </label>
                                        <div class="image-preview-container"></div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn-submit-review">
                                    <i class="fas fa-paper-plane"></i>
                                    Gửi đánh giá
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="login-to-review">
                            <p>Vui lòng <a href="/User/login">đăng nhập</a> để viết đánh giá.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sản phẩm liên quan -->
    <div class="related-products">
        <h2 class="section-title">Sản phẩm liên quan</h2>
        <div class="products-grid">
            <?php if (!empty($related_products)): ?>
                <?php foreach ($related_products as $related): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <a href="/Product/show/<?php echo $related->id; ?>">
                                <img src="/<?php echo htmlspecialchars($related->image); ?>" 
                                     alt="<?php echo htmlspecialchars($related->name); ?>">
                            </a>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">
                                <a href="/Product/show/<?php echo $related->id; ?>">
                                    <?php echo htmlspecialchars($related->name); ?>
                                </a>
                            </h3>
                            <div class="product-price">
                                <?php echo number_format($related->price, 0, ',', '.'); ?>₫
                            </div>
                            <div class="product-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star<?php echo $i <= $related->rating ? ' active' : ''; ?>"></i>
                                <?php endfor; ?>
                                <span class="rating-count">(<?php echo $related->rating_count; ?>)</span>
                            </div>
                            <div class="product-actions">
                                <button class="btn-add-to-cart" onclick="addToCart(<?php echo $related->id; ?>)">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <a href="/Product/show/<?php echo $related->id; ?>" class="btn-view-detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-products">Không có sản phẩm liên quan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.product-stock {
    margin: 1rem 0;
}

.stock-status {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
}

.stock-status i {
    font-size: 1.1rem;
}

.stock-status.in-stock {
    background: #e8f5e9;
    color: #2e7d32;
}

.stock-status.low-stock {
    background: #fff3e0;
    color: #ef6c00;
}

.stock-status.out-of-stock {
    background: #ffebee;
    color: #c62828;
}

.product-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.5rem 0;
}

.quantity-selector {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    overflow: hidden;
    width: fit-content;
}

.quantity-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: #f5f5f5;
    color: var(--text-dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    background: var(--primary-color);
    color: white;
}

.quantity-input {
    width: 50px;
    height: 32px;
    border: none;
    border-left: 1px solid var(--border-color);
    border-right: 1px solid var(--border-color);
    text-align: center;
    font-size: 0.9rem;
    color: var(--text-dark);
    -moz-appearance: textfield;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.add-to-cart-form {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.btn-add-to-cart {
    flex: 1;
    height: 42px;
    padding: 0 1.5rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-add-to-cart:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-buy-now {
    height: 42px;
    padding: 0 2rem;
    background: #ff4757;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-buy-now:hover {
    background: #ff3344;
    transform: translateY(-1px);
}

.btn-buy-now i {
    font-size: 1rem;
}

@media (max-width: 768px) {
    .product-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .add-to-cart-form {
        width: 100%;
    }

    .btn-buy-now {
        width: 100%;
    }
}

/* Style cho sao đánh giá */
.stars .fa-star {
    color: #ddd;
    font-size: 1rem;
}

.stars .fa-star.active {
    color: #ffc107;
}

.rating-average .stars {
    display: flex;
    gap: 0.25rem;
    margin: 0.5rem 0;
}

.rating-average .fa-star {
    font-size: 1.2rem;
}

.review-rating .fa-star {
    color: #ddd;
    font-size: 1rem;
}

.review-rating .fa-star.active {
    color: #ffc107;
}

.rating-selector .rating-stars {
    display: flex;
    flex-direction: row-reverse;
    gap: 0.25rem;
}

.rating-selector .rating-stars input {
    display: none;
}

.rating-selector .rating-stars label {
    cursor: pointer;
    color: #ddd;
    font-size: 1.5rem;
}

.rating-selector .rating-stars label:hover,
.rating-selector .rating-stars label:hover ~ label,
.rating-selector .rating-stars input:checked ~ label {
    color: #ffc107;
}

.rating-bars .rating-bar-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.rating-bars .rating-label {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    min-width: 3rem;
}

.rating-bars .rating-label .fa-star {
    color: #ffc107;
    font-size: 0.9rem;
}

.rating-bars .rating-bar {
    flex: 1;
    height: 8px;
    background: #eee;
    border-radius: 4px;
    overflow: hidden;
}

.rating-bars .rating-fill {
    height: 100%;
    background: #ffc107;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.rating-bars .rating-count {
    min-width: 2rem;
    text-align: right;
    color: #666;
}

.review-summary {
    display: flex;
    gap: 2rem;
    padding: 1.5rem;
    background: #f9f9f9;
    border-radius: 8px;
    margin-bottom: 2rem;
}

.rating-average {
    text-align: center;
}

.rating-average .average-number {
    font-size: 3rem;
    font-weight: bold;
    color: var(--text-dark);
    line-height: 1;
}

.rating-average .total-ratings {
    color: #666;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

@media (max-width: 768px) {
    .review-summary {
        flex-direction: column;
        gap: 1rem;
    }
}

.related-products {
    margin-top: 3rem;
    padding: 2rem 0;
    background: #f8f9fa;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    text-align: center;
    color: var(--text-dark);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    padding: 0 1rem;
}

.product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    position: relative;
    padding-top: 100%;
    overflow: hidden;
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-info {
    padding: 1rem;
}

.product-name {
    font-size: 1rem;
    margin: 0 0 0.5rem;
    line-height: 1.4;
}

.product-name a {
    color: var(--text-dark);
    text-decoration: none;
}

.product-name a:hover {
    color: var(--primary-color);
}

.product-price {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.product-rating {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.product-rating .fa-star {
    color: #ddd;
    font-size: 0.9rem;
}

.product-rating .fa-star.active {
    color: #ffc107;
}

.rating-count {
    margin-left: 0.5rem;
    font-size: 0.9rem;
    color: #666;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.btn-add-to-cart,
.btn-view-detail {
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-add-to-cart {
    background: var(--primary-color);
    color: white;
}

.btn-view-detail {
    background: #e9ecef;
    color: var(--text-dark);
}

.btn-add-to-cart:hover {
    background: var(--primary-dark);
}

.btn-view-detail:hover {
    background: #dee2e6;
}

.no-products {
    grid-column: 1 / -1;
    text-align: center;
    color: #666;
    padding: 2rem;
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}
</style>

<script>
// Đảm bảo mã JavaScript chỉ chạy một lần
(function() {
    // Biến cờ để kiểm tra xem mã đã được thực thi chưa
    let hasInitialized = false;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Nếu đã khởi tạo rồi thì dừng
        if (hasInitialized) return;
        hasInitialized = true;
        
        // Xử lý chuyển đổi ảnh
        const mainImage = document.getElementById('main-product-image');
        const thumbnails = document.querySelectorAll('.thumbnail');
        
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const imgSrc = this.getAttribute('data-src');
                mainImage.src = imgSrc;
                
                // Đặt lại trạng thái active
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Xử lý chuyển tab
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Đặt lại trạng thái active cho button
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Đặt lại trạng thái active cho tab content
                tabPanes.forEach(pane => pane.classList.remove('active'));
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Xử lý tăng/giảm số lượng
        const quantityInput = document.getElementById('quantity-input');
        const minusBtn = document.querySelector('.quantity-btn.minus');
        const plusBtn = document.querySelector('.quantity-btn.plus');
        
        if (minusBtn && plusBtn && quantityInput) {
            // Xóa tất cả event listeners hiện có trước khi thêm mới
            const minusBtnClone = minusBtn.cloneNode(true);
            const plusBtnClone = plusBtn.cloneNode(true);
            
            minusBtn.parentNode.replaceChild(minusBtnClone, minusBtn);
            plusBtn.parentNode.replaceChild(plusBtnClone, plusBtn);
            
            // Gán lại biến cho các phần tử mới
            const newMinusBtn = document.querySelector('.quantity-btn.minus');
            const newPlusBtn = document.querySelector('.quantity-btn.plus');
            
            // Thêm sự kiện cho nút giảm
            newMinusBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });
            
            // Thêm sự kiện cho nút tăng
            newPlusBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                const maxValue = parseInt(quantityInput.getAttribute('max'));
                if (currentValue < maxValue) {
                    quantityInput.value = currentValue + 1;
                }
            });
            
            // Thêm sự kiện kiểm tra khi người dùng nhập trực tiếp
            quantityInput.addEventListener('input', function() {
                let currentValue = parseInt(this.value);
                const maxValue = parseInt(this.getAttribute('max'));
                
                // Nếu không phải là số hoặc nhỏ hơn 1
                if (isNaN(currentValue) || currentValue < 1) {
                    this.value = 1;
                }
                // Nếu lớn hơn số lượng tối đa trong kho
                else if (currentValue > maxValue) {
                    this.value = maxValue;
                    // Hiển thị thông báo cho người dùng
                    showNotification('error', `Số lượng tối đa có thể mua là ${maxValue}`);
                }
            });
            
            // Thêm sự kiện xử lý phím mũi tên
            quantityInput.addEventListener('keydown', function(e) {
                const currentValue = parseInt(this.value);
                const maxValue = parseInt(this.getAttribute('max'));
                
                // Phím mũi tên lên
                if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (currentValue < maxValue) {
                        this.value = currentValue + 1;
                    } else {
                        showNotification('error', `Số lượng tối đa có thể mua là ${maxValue}`);
                    }
                }
                // Phím mũi tên xuống
                else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (currentValue > 1) {
                        this.value = currentValue - 1;
                    }
                }
            });
            
            // Thêm sự kiện kiểm tra khi focus out
            quantityInput.addEventListener('blur', function() {
                let currentValue = parseInt(this.value);
                const maxValue = parseInt(this.getAttribute('max'));
                
                // Nếu trống hoặc không phải là số
                if (this.value === '' || isNaN(currentValue)) {
                    this.value = 1;
                }
                // Nếu vượt quá số lượng tối đa
                else if (currentValue > maxValue) {
                    this.value = maxValue;
                }
            });
        }
        
        // Xử lý thêm vào giỏ hàng
        const addToCartBtn = document.getElementById('add-to-cart');
        if (addToCartBtn) {
            // Xóa sự kiện cũ bằng cách clone
            const addToCartBtnClone = addToCartBtn.cloneNode(true);
            addToCartBtn.parentNode.replaceChild(addToCartBtnClone, addToCartBtn);
            
            // Gán lại biến cho phần tử mới
            const newAddToCartBtn = document.getElementById('add-to-cart');
            
            newAddToCartBtn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(quantityInput.value);
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                
                // Validate số lượng
                if (quantity < 1) {
                    showNotification('error', 'Số lượng không hợp lệ');
                    return;
                }
                
                // Kiểm tra nếu vượt quá số lượng kho
                if (quantity > maxQuantity) {
                    quantityInput.value = maxQuantity;
                    showNotification('error', `Số lượng tối đa có thể mua là ${maxQuantity}`);
                    return;
                }
                
                // Thêm hiệu ứng loading
                newAddToCartBtn.classList.add('loading');
                const originalText = newAddToCartBtn.innerHTML;
                newAddToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
                
                // Tạo form data để gửi POST request
                const formData = new FormData();
                formData.append('quantity', quantity);
                
                fetch(`/Product/addToCart/${productId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Kiểm tra Content-Type
                    const contentType = response.headers.get('Content-Type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    }
                    return { success: true, message: 'Đã thêm sản phẩm vào giỏ hàng' };
                })
                .then(data => {
                    if (data.success) {
                        // Hiển thị thông báo thành công
                        showNotification('success', data.message || 'Đã thêm sản phẩm vào giỏ hàng');
                        
                        // Tải lại số lượng giỏ hàng (nếu có API riêng)
                        if (data.cartCount) {
                            updateCartCount(data.cartCount);
                        }
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
                        newAddToCartBtn.classList.remove('loading');
                        newAddToCartBtn.innerHTML = originalText;
                    }, 500);
                });
            });
        }
        
        // Xử lý ảnh trong form đánh giá
        const imageInput = document.getElementById('review-images');
        const previewContainer = document.querySelector('.image-preview-container');
        
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                
                if (this.files.length > 5) {
                    showNotification('error', 'Chỉ được chọn tối đa 5 ảnh');
                    this.value = '';
                    return;
                }
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    if (!file.type.startsWith('image/')) continue;
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'preview-item';
                        
                        const preview = document.createElement('img');
                        preview.src = e.target.result;
                        preview.className = 'preview-image';
                        
                        const removeBtn = document.createElement('span');
                        removeBtn.className = 'remove-preview';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.addEventListener('click', function() {
                            previewWrapper.remove();
                            // Reset input để người dùng có thể chọn lại ảnh đã xóa
                            // Lưu ý: Điều này sẽ xóa tất cả các ảnh đã chọn
                            imageInput.value = '';
                        });
                        
                        previewWrapper.appendChild(preview);
                        previewWrapper.appendChild(removeBtn);
                        previewContainer.appendChild(previewWrapper);
                    }
                    
                    reader.readAsDataURL(file);
                }
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
        
        // Thêm hàm hiển thị thông báo
        function showNotification(type, message) {
            // Sanitize the type
            if (type !== 'success' && type !== 'error') {
                type = 'error'; // Default to error for unknown types
            }
            
            // Ensure message is a string
            if (typeof message !== 'string') {
                if (message && typeof message === 'object') {
                    try {
                        message = JSON.stringify(message);
                    } catch (e) {
                        message = 'Đã xảy ra lỗi không xác định';
                    }
                } else {
                    message = 'Đã xảy ra lỗi không xác định';
                }
            }
            
            // Create and add notification to DOM
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
        
        // Xử lý nút Mua ngay
        const buyNowBtn = document.querySelector('.btn-buy-now');
        if (buyNowBtn) {
            // Xóa sự kiện cũ bằng cách clone
            const buyNowBtnClone = buyNowBtn.cloneNode(true);
            buyNowBtn.parentNode.replaceChild(buyNowBtnClone, buyNowBtn);
            
            // Gán lại biến cho phần tử mới
            const newBuyNowBtn = document.querySelector('.btn-buy-now');
            
            newBuyNowBtn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(quantityInput.value);
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                
                // Validate số lượng
                if (quantity < 1) {
                    showNotification('error', 'Số lượng không hợp lệ');
                    return;
                }
                
                // Kiểm tra nếu vượt quá số lượng kho
                if (quantity > maxQuantity) {
                    quantityInput.value = maxQuantity;
                    showNotification('error', `Số lượng tối đa có thể mua là ${maxQuantity}`);
                    return;
                }
                
                // Thêm vào giỏ hàng và chuyển hướng đến trang thanh toán
                window.location.href = `/Product/buyNow/${productId}?quantity=${quantity}`;
            });
        }
        
        // Xử lý gửi đánh giá AJAX
        const reviewForm = document.querySelector('.review-form');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Hiển thị trạng thái loading
                const submitBtn = this.querySelector('.btn-submit-review');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
                submitBtn.disabled = true;
                
                const formData = new FormData(this);
                
                fetch('/Product/addReview', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Kiểm tra Content-Type
                    const contentType = response.headers.get('Content-Type');
                    logDebugInfo('Response Headers', {
                        contentType,
                        status: response.status,
                        statusText: response.statusText
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Lỗi kết nối đến server (${response.status})`);
                    }
                    
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            logDebugInfo('Non-JSON Response', text.substring(0, 1000));
                            throw new Error('Server không trả về JSON. Vui lòng liên hệ quản trị viên.');
                        });
                    }
                    
                    return response.json();
                })
                .then(data => {
                    logDebugInfo('Response Data', data);
                    
                    if (data.success) {
                        // Hiển thị thông báo thành công
                        showNotification('success', data.message);
                        
                        // Reset form
                        reviewForm.reset();
                        
                        // Xóa preview ảnh nếu có
                        const previewContainer = document.querySelector('.image-preview-container');
                        if (previewContainer) {
                            previewContainer.innerHTML = '';
                        }
                        
                        // Làm mới trang để hiển thị đánh giá mới
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Có lỗi xảy ra khi gửi đánh giá');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', error.message || 'Có lỗi xảy ra, vui lòng thử lại sau.');
                    
                    // Log lỗi để debug
                    logDebugInfo('Error Details', {
                        name: error.name,
                        message: error.message,
                        stack: error.stack
                    });
                })
                .finally(() => {
                    // Khôi phục nút sau khi hoàn thành
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }
        
        // Debug helper - Giúp theo dõi lỗi trong console
        function logDebugInfo(title, data) {
            console.group('DEBUG: ' + title);
            console.log(data);
            console.groupEnd();
        }
    });
})();

function addToCart(productId) {
    fetch(`/Product/addToCartAjax/${productId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật số lượng giỏ hàng trên header
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
            
            // Hiển thị thông báo thành công
            alert('Đã thêm sản phẩm vào giỏ hàng');
        } else {
            alert(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
    });
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
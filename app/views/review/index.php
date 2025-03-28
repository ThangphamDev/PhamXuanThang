<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0"><i class="fas fa-star text-warning me-2"></i>Đánh giá từ khách hàng</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Đánh giá từ khách hàng</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Tổng quan về đánh giá -->
    <div class="row mb-4">
        <!-- Thống kê đánh giá -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Thống kê đánh giá</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <?php
                            // Tính toán điểm đánh giá trung bình
                            $total_count = 0;
                            $total_rating = 0;
                            $rating_counts = [0, 0, 0, 0, 0, 0]; // index 0 không dùng, 1-5 sao
                            
                            foreach ($rating_distribution as $rating) {
                                $total_count += $rating->count;
                                $total_rating += $rating->rating * $rating->count;
                                $rating_counts[$rating->rating] = $rating->count;
                            }
                            
                            $average_rating = $total_count > 0 ? $total_rating / $total_count : 0;
                            ?>
                            <div class="text-center mb-4">
                                <div class="display-4 fw-bold text-warning"><?php echo number_format($average_rating, 1); ?></div>
                                <div class="rating-stars mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= floor($average_rating)): ?>
                                            <i class="fas fa-star text-warning"></i>
                                        <?php elseif ($i - 0.5 <= $average_rating): ?>
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        <?php else: ?>
                                            <i class="far fa-star text-warning"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="text-muted">Dựa trên <?php echo $total_count; ?> đánh giá</div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="rating-stats">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <?php 
                                    $percentage = $total_count > 0 ? ($rating_counts[$i] / $total_count) * 100 : 0;
                                    ?>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rating-label me-2" style="width: 60px;">
                                            <div class="d-flex align-items-center">
                                                <span class="me-1"><?php echo $i; ?></span>
                                                <i class="fas fa-star text-warning small"></i>
                                            </div>
                                        </div>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: <?php echo $percentage; ?>%"></div>
                                        </div>
                                        <div class="rating-count small" style="width: 50px;">
                                            <?php echo $rating_counts[$i]; ?> đánh giá
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sản phẩm được đánh giá cao nhất -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Sản phẩm được đánh giá cao</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($top_rated_products)): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($top_rated_products as $product): ?>
                                <li class="list-group-item px-3 py-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light rounded" style="width: 60px; height: 60px; overflow: hidden;">
                                                <?php if (!empty($product->image)): ?>
                                                    <img src="/<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">
                                                <a href="/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                                                    <?php echo htmlspecialchars($product->name); ?>
                                                </a>
                                            </h6>
                                            <div class="rating-stars small mb-1">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= floor($product->rating)): ?>
                                                        <i class="fas fa-star text-warning"></i>
                                                    <?php elseif ($i - 0.5 <= $product->rating): ?>
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star text-warning"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                <span class="ms-1 text-muted small">(<?php echo $product->rating_count; ?>)</span>
                                            </div>
                                            <?php if (!empty($product->latest_review)): ?>
                                                <div class="text-muted small text-truncate" style="max-width: 200px;">
                                                    "<?php echo htmlspecialchars($product->latest_review); ?>"
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Chưa có sản phẩm nào được đánh giá.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách các đánh giá -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Tất cả đánh giá từ khách hàng</h5>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($reviews)): ?>
                <div class="review-list">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item p-4 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <span class="text-white fw-bold"><?php echo strtoupper(substr($review->user_fullname ?? $review->username, 0, 1)); ?></span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="mb-0"><?php echo htmlspecialchars($review->user_fullname ?? $review->username); ?></h5>
                                            <div class="rating-date text-muted small">
                                                <i class="far fa-calendar-alt me-1"></i><?php echo date('d/m/Y', strtotime($review->created_at)); ?>
                                            </div>
                                        </div>
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo ($i <= $review->rating) ? 'text-warning' : 'text-muted'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="product-info d-flex align-items-center mb-3 p-2 bg-light rounded">
                                        <div class="flex-shrink-0">
                                            <div class="bg-white rounded" style="width: 40px; height: 40px; overflow: hidden;">
                                                <?php if (!empty($review->product_image)): ?>
                                                    <img src="/<?php echo htmlspecialchars($review->product_image); ?>" alt="<?php echo htmlspecialchars($review->product_name); ?>" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="ms-2">
                                            <a href="/Product/show/<?php echo $review->product_id; ?>" class="text-decoration-none text-dark fw-medium">
                                                <?php echo htmlspecialchars($review->product_name); ?>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="review-content">
                                        <p class="mb-0"><?php echo htmlspecialchars($review->content); ?></p>
                                    </div>
                                    
                                    <?php if (!empty($review->images)): ?>
                                        <div class="review-images mt-3">
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php 
                                                $images = explode(',', $review->images);
                                                foreach ($images as $image): 
                                                ?>
                                                    <div class="review-image-item" style="width: 80px; height: 80px; overflow: hidden;">
                                                        <img src="/<?php echo htmlspecialchars(trim($image)); ?>" alt="Review image" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($pagination['total_pages'] > 1): ?>
                <div class="d-flex justify-content-center py-4">
                    <nav aria-label="Phân trang">
                        <ul class="pagination">
                            <?php if ($pagination['current_page'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="/Review?page=<?php echo $pagination['current_page'] - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php
                            $start_page = max(1, $pagination['current_page'] - 2);
                            $end_page = min($pagination['total_pages'], $pagination['current_page'] + 2);

                            if ($start_page > 1) {
                                echo '<li class="page-item"><a class="page-link" href="/Review?page=1">1</a></li>';
                                if ($start_page > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            for ($i = $start_page; $i <= $end_page; $i++) {
                                $active = $pagination['current_page'] == $i ? 'active' : '';
                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="/Review?page=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($end_page < $pagination['total_pages']) {
                                if ($end_page < $pagination['total_pages'] - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="/Review?page=' . $pagination['total_pages'] . '">' . $pagination['total_pages'] . '</a></li>';
                            }
                            ?>

                            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="/Review?page=<?php echo $pagination['current_page'] + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="text-center py-5">
                    <img src="/public/images/no-data.svg" alt="Không có dữ liệu" class="img-fluid mb-3" style="max-width: 200px;">
                    <h5>Chưa có đánh giá nào</h5>
                    <p class="text-muted">Hiện chưa có đánh giá nào từ khách hàng.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .rating-stars {
        display: inline-flex;
        align-items: center;
    }
    
    .rating-stars .fa-star,
    .rating-stars .fa-star-half-alt,
    .rating-stars .far.fa-star {
        font-size: 0.85rem;
        margin-right: 2px;
    }
    
    .rating-stats .progress {
        height: 8px;
        border-radius: 4px;
    }
    
    .review-item:hover {
        background-color: rgba(0, 0, 0, 0.01);
    }
    
    .review-item:last-child {
        border-bottom: none !important;
    }
    
    .avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
    }
    
    @media (max-width: 767.98px) {
        .rating-count {
            display: none;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?> 
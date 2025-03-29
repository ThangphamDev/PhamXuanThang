<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5 profile-page">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card account-sidebar">
                <div class="card-body">
                    <div class="user-profile-header text-center mb-4">
                        <div class="profile-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h4 class="mt-2"><?php echo htmlspecialchars($account->name); ?></h4>
                        <p class="text-muted small"><?php echo htmlspecialchars($account->username); ?></p>
                        <?php if ($account->role === 'admin'): ?>
                            <span class="badge bg-success role-badge">Quản trị viên</span>
                        <?php else: ?>
                            <span class="badge bg-info role-badge">Thành viên</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="account-menu">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item active">
                                <a href="/account/profile">
                                    <i class="fas fa-user-alt"></i> Thông tin tài khoản
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/Product/myOrders">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/Product/wishlist">
                                    <i class="fas fa-heart"></i> Sản phẩm yêu thích
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/Product/cart">
                                    <i class="fas fa-shopping-cart"></i> Giỏ hàng của tôi
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="/account/logout" class="text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($errors['update'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $errors['update']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/account/updateProfile" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($account->username); ?>" disabled>
                            <div class="form-text">Tên đăng nhập không thể thay đổi.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control <?php echo isset($errors['fullname']) ? 'is-invalid' : ''; ?>" id="fullname" name="fullname" value="<?php echo htmlspecialchars($account->name); ?>">
                            <?php if (isset($errors['fullname'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['fullname']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Vai trò</label>
                            <input type="text" class="form-control" id="role" value="<?php echo $account->role === 'admin' ? 'Quản trị viên' : 'Thành viên'; ?>" disabled>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="mb-3">Thay đổi mật khẩu</h5>
                        <p class="text-muted mb-3">Để trống nếu bạn không muốn thay đổi mật khẩu.</p>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control <?php echo isset($errors['current_password']) ? 'is-invalid' : ''; ?>" id="current_password" name="current_password">
                            <?php if (isset($errors['current_password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['current_password']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control <?php echo isset($errors['new_password']) ? 'is-invalid' : ''; ?>" id="new_password" name="new_password">
                            <?php if (isset($errors['new_password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['new_password']; ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password">
                            <?php if (isset($errors['confirm_password'])): ?>
                                <div class="invalid-feedback">
                                    <?php echo $errors['confirm_password']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Hoạt động gần đây</h5>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        <div class="activity-item">
                            <i class="fas fa-sign-in-alt activity-icon"></i>
                            <div class="activity-content">
                                <p class="mb-0">Đăng nhập thành công</p>
                                <span class="text-muted small">Hôm nay, <?php echo date('H:i'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-page {
    margin-top: 2rem;
    margin-bottom: 4rem;
}

.account-sidebar {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: none;
    overflow: hidden;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #e9ecef;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-avatar i {
    font-size: 60px;
    color: #6c757d;
}

.role-badge {
    font-size: 0.7rem;
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.account-menu .list-group-item {
    border: none;
    padding: 0.75rem 1rem;
    background: transparent;
    transition: all 0.2s ease;
}

.account-menu .list-group-item:hover {
    background-color: rgba(67, 160, 71, 0.1);
}

.account-menu .list-group-item.active {
    background-color: rgba(67, 160, 71, 0.2);
    color: var(--primary-dark);
    font-weight: 500;
}

.account-menu .list-group-item a {
    color: var(--text-dark);
    text-decoration: none;
    display: block;
}

.account-menu .list-group-item.active a {
    color: var(--primary-dark);
}

.account-menu .list-group-item a i {
    margin-right: 8px;
    width: 20px;
    text-align: center;
    color: var(--primary-color);
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 1.25rem;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: rgba(67, 160, 71, 0.1);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.activity-content {
    flex: 1;
}

@media (max-width: 992px) {
    .profile-page {
        margin-top: 1rem;
    }
}
</style>

<?php include 'app/views/shares/footer.php'; ?> 
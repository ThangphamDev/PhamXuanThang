<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Chỉnh sửa tài khoản</h3>
                    <a href="<?php echo SessionHelper::isAdmin() ? '/admin/orders' : '/account/profile'; ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($errors['update'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $errors['update']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/account/edit/<?php echo $account->id; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($account->username); ?>" disabled>
                                <div class="form-text">Tên đăng nhập không thể thay đổi.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control <?php echo isset($errors['fullname']) ? 'is-invalid' : ''; ?>" id="fullname" name="fullname" value="<?php echo htmlspecialchars($account->name); ?>">
                                <?php if (isset($errors['fullname'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['fullname']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (SessionHelper::isAdmin()): ?>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Vai trò</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="user" <?php echo $account->role === 'user' ? 'selected' : ''; ?>>Thành viên</option>
                                    <option value="admin" <?php echo $account->role === 'admin' ? 'selected' : ''; ?>>Quản trị viên</option>
                                </select>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="mb-3">Thay đổi mật khẩu</h5>
                        <p class="text-muted mb-3">Để trống nếu bạn không muốn thay đổi mật khẩu.</p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control <?php echo isset($errors['new_password']) ? 'is-invalid' : ''; ?>" id="new_password" name="new_password">
                                <?php if (isset($errors['new_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['new_password']; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password">
                                <?php if (isset($errors['confirm_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['confirm_password']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?php echo SessionHelper::isAdmin() ? '/admin/orders' : '/account/profile'; ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?> 
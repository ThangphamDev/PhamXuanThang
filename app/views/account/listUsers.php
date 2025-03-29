<?php
require_once 'app/config/database.php';

// Tạo biến $viewHelper thay vì $this
$viewHelper = new class {
    public function isCurrentPage($page) {
        $url = $_GET['url'] ?? '';
        return strpos($url, trim($page, '/')) === 0;
    }
    
    public function model($modelName) {
        require_once 'app/models/' . $modelName . '.php';
        $db = (new Database())->getConnection();
        return new $modelName($db);
    }
};

// Sử dụng layout admin
include 'app/views/admin/layouts/master.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý tài khoản</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quản lý tài khoản</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách tài khoản</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Họ và tên</th>
                                    <th>Vai trò</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($users) && !empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td><?php echo htmlspecialchars($user->username); ?></td>
                                            <td><?php echo htmlspecialchars($user->name); ?></td>
                                            <td>
                                                <?php if ($user->role === 'admin'): ?>
                                                    <span class="badge badge-success">Quản trị viên</span>
                                                <?php else: ?>
                                                    <span class="badge badge-info">Thành viên</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="/account/edit/<?php echo $user->id; ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <?php if (isset($_SESSION['user_id']) && ($user->role !== 'admin' || $_SESSION['user_id'] != $user->id)): ?>
                                                <a href="/account/updateRole/<?php echo $user->id; ?>/<?php echo $user->role === 'admin' ? 'user' : 'admin'; ?>" class="btn btn-warning btn-sm">
                                                    <?php if ($user->role === 'admin'): ?>
                                                        <i class="fas fa-user"></i> Hạ quyền
                                                    <?php else: ?>
                                                        <i class="fas fa-user-shield"></i> Nâng quyền
                                                    <?php endif; ?>
                                                </a>
                                                <?php if ($user->role !== 'admin'): ?>
                                                <a href="#" onclick="confirmDelete(<?php echo $user->id; ?>)" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Không có tài khoản nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="/account/listUsers/1">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="/account/listUsers/<?php echo $page - 1; ?>">&lsaquo;</a></li>
                        <?php endif; ?>
                        
                        <?php
                        // Hiển thị tối đa 5 trang phân trang
                        $start = max(1, $page - 2);
                        $end = min($totalPages, $start + 4);
                        if ($end - $start < 4) {
                            $start = max(1, $end - 4);
                        }
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="/account/listUsers/<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item"><a class="page-link" href="/account/listUsers/<?php echo $page + 1; ?>">&rsaquo;</a></li>
                            <li class="page-item"><a class="page-link" href="/account/listUsers/<?php echo $totalPages; ?>">&raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa tài khoản này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Xóa</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId) {
    document.getElementById('confirmDeleteButton').href = '/account/delete/' + userId;
    $('#deleteModal').modal('show');
}
</script>

<?php include 'app/views/admin/layouts/footer.php'; ?> 
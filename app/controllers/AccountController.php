<?php
require_once 'app/config/database.php';
require_once 'app/models/AccountModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/controllers/Controller.php';

class AccountController extends Controller {
    private $accountModel;
    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập fullname!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa đúng!";
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);

                if ($result) {
                    header('Location: /account/login');
                    exit();
                } else {
                    $errors['save'] = "Đã xảy ra lỗi khi đăng ký!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    public function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['user_id']);
        header('Location: /Product/');
        exit();
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/login.php';
                return;
            }

            $account = $this->accountModel->getAccountByUsername($username);

            if ($account) {
                $pwd_hashed = $account->password;
                if (password_verify($password, $pwd_hashed)) {
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role;
                    $_SESSION['user_id'] = $account->id;
                    header('Location: /Product/');
                    exit();
                } else {
                    $errors['login'] = "Mật khẩu không đúng!";
                    include_once 'app/views/account/login.php';
                }
            } else {
                $errors['login'] = "Không tìm thấy tài khoản!";
                include_once 'app/views/account/login.php';
            }
        } else {
            include_once 'app/views/account/login.php';
        }
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /account/login');
            exit();
        }
        
        $user_id = $_SESSION['user_id'];
        $account = $this->accountModel->getAccountById($user_id);
        
        if (!$account) {
            header('Location: /Product/');
            exit();
        }
        
        // If the user is an admin, load pending orders for quick approval
        $pendingOrders = null;
        if ($account->role === 'admin') {
            require_once('app/models/OrderModel.php');
            $orderModel = new OrderModel($this->db);
            // Get the 5 most recent pending orders
            $pendingOrders = $orderModel->getPendingOrders(5);
        }
        
        include_once 'app/views/account/profile.php';
    }
    
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /account/login');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $fullName = $_POST['fullname'] ?? '';
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập họ và tên!";
            }
            
            $account = $this->accountModel->getAccountById($user_id);
            
            // Nếu người dùng muốn thay đổi mật khẩu
            if (!empty($newPassword)) {
                if (empty($currentPassword)) {
                    $errors['current_password'] = "Vui lòng nhập mật khẩu hiện tại!";
                } else if (!password_verify($currentPassword, $account->password)) {
                    $errors['current_password'] = "Mật khẩu hiện tại không đúng!";
                }
                
                if (strlen($newPassword) < 6) {
                    $errors['new_password'] = "Mật khẩu mới phải có ít nhất 6 ký tự!";
                }
                
                if ($newPassword != $confirmPassword) {
                    $errors['confirm_password'] = "Mật khẩu xác nhận không khớp với mật khẩu mới!";
                }
            }
            
            if (count($errors) > 0) {
                include_once 'app/views/account/profile.php';
                return;
            }
            
            // Cập nhật thông tin cá nhân
            $updateData = ['fullname' => $fullName];
            
            // Nếu có mật khẩu mới, cập nhật mật khẩu
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                $updateData['password'] = $hashedPassword;
            }
            
            $result = $this->accountModel->updateAccount($user_id, $updateData);
            
            if ($result) {
                $success = "Cập nhật thông tin thành công!";
                $account = $this->accountModel->getAccountById($user_id); // Tải lại thông tin tài khoản
                include_once 'app/views/account/profile.php';
            } else {
                $errors['update'] = "Đã xảy ra lỗi khi cập nhật thông tin!";
                include_once 'app/views/account/profile.php';
            }
        } else {
            header('Location: /account/profile');
            exit();
        }
    }

    public function edit($id = null) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            $_SESSION['error'] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /account/profile');
            exit();
        }
        
        // Nếu không có ID, sử dụng ID người dùng hiện tại
        if ($id === null) {
            $id = $_SESSION['user_id'];
        }
        
        // Lấy thông tin tài khoản
        $account = $this->accountModel->getAccountById($id);
        
        if (!$account) {
            $_SESSION['error'] = "Không tìm thấy tài khoản!";
            header('Location: /account/profile');
            exit();
        }
        
        // Lấy đơn hàng của người dùng này
        require_once('app/models/OrderModel.php');
        $orderModel = new OrderModel($this->db);
        $orders = $orderModel->getOrdersByUserId($id);
        
        // Hiển thị view chỉ để xem thông tin
        include_once 'app/views/account/viewUser.php';
    }
    
    // Hiển thị danh sách tất cả người dùng
    public function listUsers($page = 1) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            $_SESSION['error'] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /account/profile');
            exit();
        }
        
        $limit = 10; // Số người dùng trên một trang
        $offset = ($page - 1) * $limit;
        
        // Lấy danh sách người dùng
        $users = $this->accountModel->getAllUsers($limit, $offset);
        $totalUsers = $this->accountModel->countTotalUsers();
        
        // Tính toán phân trang
        $totalPages = ceil($totalUsers / $limit);
        
        // Hiển thị view danh sách người dùng với dữ liệu đã được truyền vào
        include_once 'app/views/account/listUsers.php';
    }
    
    // Cập nhật vai trò của người dùng
    public function updateRole($id, $newRole) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            $_SESSION['error'] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /account/profile');
            exit();
        }
        
        // Kiểm tra xem người dùng có tồn tại không
        $account = $this->accountModel->getAccountById($id);
        
        if (!$account) {
            $_SESSION['error'] = "Không tìm thấy tài khoản!";
            header('Location: /account/listUsers');
            exit();
        }
        
        // Không cho phép hạ quyền chính mình
        if ($id == $_SESSION['user_id'] && $newRole != 'admin' && $account->role == 'admin') {
            $_SESSION['error'] = "Bạn không thể hạ quyền của chính mình!";
            header('Location: /account/listUsers');
            exit();
        }
        
        // Kiểm tra vai trò hợp lệ
        if ($newRole != 'admin' && $newRole != 'user') {
            $_SESSION['error'] = "Vai trò không hợp lệ!";
            header('Location: /account/listUsers');
            exit();
        }
        
        // Thực hiện cập nhật vai trò
        $updateData = ['role' => $newRole];
        $result = $this->accountModel->updateAccount($id, $updateData);
        
        if ($result) {
            $_SESSION['success'] = "Cập nhật vai trò thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật vai trò!";
        }
        
        header('Location: /account/listUsers');
        exit();
    }
    
    // Xóa tài khoản người dùng
    public function delete($id) {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            $_SESSION['error'] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /account/profile');
            exit();
        }
        
        // Kiểm tra xem người dùng có tồn tại không
        $account = $this->accountModel->getAccountById($id);
        
        if (!$account) {
            $_SESSION['error'] = "Không tìm thấy tài khoản!";
            header('Location: /account/listUsers');
            exit();
        }
        
        // Không cho phép xóa tài khoản admin
        if ($account->role == 'admin') {
            $_SESSION['error'] = "Không thể xóa tài khoản quản trị viên!";
            header('Location: /account/listUsers');
            exit();
        }
        
        // Thực hiện xóa tài khoản
        $result = $this->accountModel->deleteAccount($id);
        
        if ($result) {
            $_SESSION['success'] = "Xóa tài khoản thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa tài khoản!";
        }
        
        header('Location: /account/listUsers');
        exit();
    }
}
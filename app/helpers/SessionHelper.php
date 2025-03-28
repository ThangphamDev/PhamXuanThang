<?php
/**
 * SessionHelper - Hỗ trợ quản lý phiên làm việc người dùng
 */
class SessionHelper 
{
    /**
     * Khởi tạo phiên nếu chưa được khởi tạo
     */
    public static function init() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Kiểm tra xem người dùng đã đăng nhập chưa
     * @return bool True nếu đã đăng nhập, ngược lại là false
     */
    public static function isLoggedIn() 
    {
        return isset($_SESSION['username']) && !empty($_SESSION['username']);
    }

    /**
     * Kiểm tra xem người dùng có phải là admin hay không
     * @return bool True nếu là admin, ngược lại là false
     */
    public static function isAdmin() 
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Lấy username của người dùng hiện tại
     * @return string|null Username hoặc null nếu chưa đăng nhập
     */
    public static function getUsername() 
    {
        return $_SESSION['username'] ?? null;
    }

    /**
     * Lấy ID của người dùng hiện tại
     * @return int|null ID người dùng hoặc null nếu chưa đăng nhập
     */
    public static function getUserId() 
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Lấy vai trò của người dùng hiện tại
     * @return string|null Vai trò người dùng hoặc null nếu chưa đăng nhập
     */
    public static function getRole() 
    {
        return $_SESSION['role'] ?? null;
    }

    /**
     * Thiết lập thông báo flash
     * @param string $type Loại thông báo (success, error, warning, info)
     * @param string $message Nội dung thông báo
     */
    public static function setFlash($type, $message) 
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Lấy thông báo flash và xóa khỏi session
     * @return array|null Mảng chứa thông tin flash hoặc null nếu không có
     */
    public static function getFlash() 
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Đăng xuất người dùng
     */
    public static function logout() 
    {
        // Xóa dữ liệu người dùng khỏi session
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);
        
        // Xóa session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Hủy session
        session_destroy();
    }
}

// Khởi tạo session
SessionHelper::init();
?>
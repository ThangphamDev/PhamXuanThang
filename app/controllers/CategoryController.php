<?php
// Require necessary files
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/controllers/Controller.php';

class CategoryController extends Controller {
    private $categoryModel;
    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    private function isAdmin() {
        return SessionHelper::isAdmin();
    }

    // Hiển thị danh sách danh mục (action: index)
    public function index() {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/Category/list.php';
    }

    // Thêm danh mục mới (action: add)
    public function add() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $errors = [];

            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống!";
            }

            if (empty($errors)) {
                if ($this->categoryModel->add($name, $description)) {
                    header("Location: /Category");
                    exit;
                } else {
                    $errors[] = "Có lỗi xảy ra khi thêm danh mục!";
                }
            }

            include 'app/views/Category/add.php';
        } else {
            include 'app/views/Category/add.php';
        }
    }

    // Sửa danh mục (action: edit)
    public function edit($id) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $category = $this->categoryModel->getById($id);
        if (!$category) {
            header("Location: /Category");
            exit;
        }
        include 'app/views/Category/edit.php';
    }

    // Cập nhật danh mục (action: update)
    public function update() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $errors = [];

            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống!";
            }

            if (empty($errors)) {
                if ($this->categoryModel->update($id, $name, $description)) {
                    header("Location: /Category");
                    exit;
                } else {
                    $errors[] = "Có lỗi xảy ra khi cập nhật danh mục!";
                }
            }

            $category = (object) ['id' => $id, 'name' => $name, 'description' => $description];
            include 'app/views/Category/edit.php';
        }
    }

    // Xóa danh mục (action: delete)
    public function delete($id) {
        $this->categoryModel->delete($id);
        header("Location: /Category");
        exit;
    }
}
?>
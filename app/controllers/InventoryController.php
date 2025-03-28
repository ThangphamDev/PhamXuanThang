<?php
require_once('app/config/database.php');
require_once('app/models/InventoryModel.php');
require_once('app/models/ProductModel.php');
require_once('app/helpers/SessionHelper.php');
require_once('app/controllers/Controller.php');

class InventoryController extends Controller {
    private $inventoryModel;
    private $productModel;

    public function __construct() {
        if (!SessionHelper::isAdmin()) {
            header('Location: /');
            exit;
        }

        parent::__construct();
        $this->inventoryModel = new InventoryModel($this->db);
        $this->productModel = new ProductModel($this->db);
    }

    public function index() {
        $data = [
            'inventory' => $this->inventoryModel->getInventoryByCategory(),
            'stats' => $this->inventoryModel->getInventoryStats(),
            'lowStock' => $this->inventoryModel->getLowStockProducts()
        ];

        $this->view('inventory/index', $data);
    }

    public function edit($productId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'product_id' => $productId,
                'quantity' => $_POST['quantity'],
                'min_quantity' => $_POST['min_quantity'],
                'max_quantity' => $_POST['max_quantity']
            ];

            if ($this->inventoryModel->updateQuantity($productId, $data['quantity'])) {
                header('Location: /inventory');
                exit;
            }
        }

        $data = [
            'product' => $this->productModel->getProductById($productId),
            'inventory' => $this->inventoryModel->getProductInventory($productId)
        ];

        $this->view('inventory/edit', $data);
    }

    public function checkStock() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $result = [
                'success' => $this->inventoryModel->checkStock($productId, $quantity),
                'message' => $this->inventoryModel->checkStock($productId, $quantity) 
                    ? 'Sản phẩm còn đủ số lượng trong kho' 
                    : 'Sản phẩm không đủ số lượng trong kho'
            ];

            echo json_encode($result);
        }
    }

    public function updateStock() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $result = [
                'success' => $this->inventoryModel->updateQuantity($productId, $quantity),
                'message' => $this->inventoryModel->updateQuantity($productId, $quantity) 
                    ? 'Cập nhật số lượng thành công' 
                    : 'Có lỗi xảy ra khi cập nhật số lượng'
            ];

            echo json_encode($result);
        }
    }
} 
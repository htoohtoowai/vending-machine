<?php
namespace Web\Controllers;

use Web\Models\Transaction;
use Web\Models\Product;
use Web\Models\User;
use Web\Traits\AdminCheckTrait;


class TransactionsController {
    use AdminCheckTrait;

    private $model;
    private $productModel;
    private $userModel;

    public function __construct() {
        $this->model = new Transaction();
        $this->productModel = new Product();
        $this->userModel = new User();
    }

    public function index() {
        $this->checkAdmin();
        try {
            $limit = 5; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
    
            $transactions = $this->model->all($limit, $offset);
            $totalTransactions = $this->model->count();
            $totalPages = ceil($totalTransactions / $limit);
            require __DIR__ . '/../views/transaction/list.php';
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function create() {
        $this->checkAdmin();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userId = $_POST['user_id'];
                $productId = $_POST['product_id'];
                $quantity = $_POST['quantity'];

                // Validation
                if (!is_numeric($userId) || !is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
                    throw new \InvalidArgumentException("Invalid input data.");
                }

                $product = $this->productModel->get($productId);
                if (!$product || $product['quantity_available'] < $quantity) {
                    throw new \InvalidArgumentException("Insufficient stock or invalid product.");
                }

                $totalPrice = $product['price'] * $quantity;
                $this->model->create($userId, $productId, $quantity, $totalPrice);

                // Store the success message in the session
                session_start();
                $_SESSION['success_message'] = "Transaction created successfully!";
                
                header('Location: /transactions');
                exit();
            } else {
                $users = $this->userModel->all();
                $products = $this->productModel->all();
                require __DIR__ . '/../views/transaction/add.php';
            }
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function edit($id) {
        $this->checkAdmin();
        try {
            $transaction = $this->model->get($id);
            $users = $this->userModel->all();
            $products = $this->productModel->all();
            require __DIR__ . '/../views/transaction/edit.php';
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function update($id) {
        $this->checkAdmin();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userId = $_POST['user_id'];
                $productId = $_POST['product_id'];
                $quantity = $_POST['quantity'];

                // Validation
                if (!is_numeric($userId) || !is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
                    throw new \InvalidArgumentException("Invalid input data.");
                }

                $product = $this->productModel->get($productId);
                if (!$product || $product['quantity_available'] < $quantity) {
                    throw new \InvalidArgumentException("Insufficient stock or invalid product.");
                }

                $totalPrice = $product['price'] * $quantity;
                $this->model->update($id, $userId, $productId, $quantity, $totalPrice);

                // Store the success message in the session
                session_start();
                $_SESSION['success_message'] = "Transaction updated successfully!";
                
                header('Location: /transactions');
                exit();
            }
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function delete($id) {
        $this->checkAdmin();
        try {
            if (!is_numeric($id) || intval($id) <= 0) {
                throw new \InvalidArgumentException("Invalid ID provided");
            }

            $this->model->delete($id);

            session_start();
            $_SESSION['success_message'] = "Transaction deleted successfully!";
            
            header('Location: /transactions');
            exit();
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }
}

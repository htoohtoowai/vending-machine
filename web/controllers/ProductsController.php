<?php
namespace Web\Controllers;

use Web\Models\Product;
use Web\Models\Transaction;
use Web\Traits\AdminCheckTrait;

class ProductsController {
    use AdminCheckTrait;

    private $model;
    private $modelTransaction;


    public function __construct() {
        $this->model = new Product();
        $this->modelTransaction = new Transaction();
        
    }

    public function index() {
        $this->checkAdmin();
        try {
            $limit = 5; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
    
            $productModel = new Product();
            $products = $productModel->all($limit, $offset);
            $totalProducts = $productModel->count();
            $totalPages = ceil($totalProducts / $limit);
                require __DIR__ . '/../views/product/list.php';
        }  catch (\InvalidArgumentException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
        
    }

    public function create() {
        $this->checkAdmin();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
    
                if (empty($name)) {
                    throw new \InvalidArgumentException("Product name is required.");
                }
                if (!is_numeric($price) || $price <= 0) {
                    throw new \InvalidArgumentException("Price must be a positive number.");
                }
                if (!is_numeric($quantity) || $quantity < 0) {
                    throw new \InvalidArgumentException("Quantity must be a non-negative number.");
                }
    
                $this->model->create($name, $price, $quantity);
    
                session_start();
                $_SESSION['success_message'] = "Product created successfully!";
                
                header('Location: /products');
                exit();
            }else{
                require __DIR__ . '/../views/product/add.php';
            }
        }  catch (\InvalidArgumentException $e) {
             
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function edit($id) {
        $this->checkAdmin();
        $product = $this->model->get($id);
        require __DIR__ . '/../views/product/edit.php';
    }

    public function update($id) {
        $this->checkAdmin();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
    
                if (empty($name)) {
                    throw new \InvalidArgumentException("Product name is required.");
                }
                if (!is_numeric($price) || $price <= 0) {
                    throw new \InvalidArgumentException("Price must be a positive number.");
                }
                if (!is_numeric($quantity) || $quantity < 0) {
                    throw new \InvalidArgumentException("Quantity must be a non-negative number.");
                }
    
                $this->model->update($id, $name, $price, $quantity);
                session_start();
                $_SESSION['success_message'] = "Product updated successfully!";
                
                header('Location: /products');
                exit();
            }
        }  catch (\InvalidArgumentException $e) {
             
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }
    
    

    
    public function delete($id)
    {
        $this->checkAdmin();
        try {
            if (!is_numeric($id) || intval($id) <= 0) {
                throw new \InvalidArgumentException("Invalid ID provided");
            }

            $this->model->delete($id);

            session_start();
            $_SESSION['success_message'] = "Product deleted successfully!";
            
            header('Location: /products');
            exit();
        } catch (\InvalidArgumentException $e) {
             
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }
   
    
    
}

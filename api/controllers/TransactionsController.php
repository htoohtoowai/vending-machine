<?php
namespace Api\Controllers;

use Api\Models\Transaction;
use Api\Models\User;
use Api\Models\Product;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TransactionsController {
    private $model;
    private $userModel;
    private $productModel;
    private $key;

    public function __construct() {
        $this->model = new Transaction();
        $this->userModel = new User();
        $this->productModel = new Product();
        $this->key = $this->getJwtKey();
    }

    public function createTransaction() {
        $token = $this->getBearerToken();
        if (!$token) {
            $this->sendResponse(401, 'Token is missing.');
            return;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            if ($decoded->role !== 'user') {
                $this->sendResponse(403, 'Forbidden: Only users can create transactions.');
                return;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $userId = $decoded->sub;
            $productId = $data['product_id'];
            $quantity = $data['quantity'];

            // Check if user and product exist
            if (!$this->userModel->get($userId) || !$this->productModel->get($productId)) {
                $this->sendResponse(400, 'Invalid user or product.');
                return;
            }

            // Create transaction
            $totalPrice = $this->model->calculatePrice($productId, $quantity);
            $this->model->create($userId, $productId, $quantity, $totalPrice);

            $this->sendResponse(201, 'Transaction created successfully.');
        } catch (\Exception $e) {
            $this->sendResponse(500, 'Error: ' . htmlspecialchars($e->getMessage()));
        }
    }

    private function getBearerToken() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $matches = [];
            preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches);
            return $matches[1] ?? null;
        }
        return null;
    }

    private function getJwtKey() {
        $config = include __DIR__ . '/../config/jwt.php';
        return $config['key'];
    }

    private function sendResponse($statusCode, $data) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
?>

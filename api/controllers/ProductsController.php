<?php
namespace Api\Controllers;

use Api\Models\Product;

class ProductsController {
    private $model;

    public function __construct() {
        $this->model = new Product();
    }

    public function getProducts() {
        try {
            $products = $this->model->all();
            $this->sendResponse(200, $products);
        } catch (\Exception $e) {
            $this->sendResponse(500, "Error: " . htmlspecialchars($e->getMessage()));
        }
    }

    public function getProduct($id) {
        try {
            $product = $this->model->get($id);
            if ($product) {
                $this->sendResponse(200, $product);
            } else {
                $this->sendResponse(404, "Product not found.");
            }
        } catch (\Exception $e) {
            $this->sendResponse(500, "Error: " . htmlspecialchars($e->getMessage()));
        }
    }

    private function sendResponse($statusCode, $data) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
?>

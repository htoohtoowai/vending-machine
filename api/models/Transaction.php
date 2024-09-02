<?php
namespace Api\Models;

use Api\Config\Database;

class Transaction {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($userId, $productId, $quantity, $totalPrice) {
        $stmt = $this->conn->prepare("INSERT INTO transactions (user_id, product_id, quantity, total_price) VALUES (:user_id, :product_id, :quantity, :total_price)");
        $params = [
            ':user_id' => $userId,
            ':product_id' => $productId,
            ':quantity' => $quantity,
            ':total_price' => $totalPrice
        ];
        $stmt->execute($params);
        return $this->conn->lastInsertId();
    }

    public function calculatePrice($productId, $quantity) {
        $stmt = $this->conn->prepare("SELECT price FROM products WHERE id = :product_id");
        $stmt->execute([':product_id' => $productId]);
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($product) {
            $pricePerUnit = $product['price'];
            return $pricePerUnit * $quantity;
        } else {
            throw new \Exception("Product not found.");
        }
    }
}
?>

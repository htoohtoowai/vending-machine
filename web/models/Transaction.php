<?php
namespace Web\Models;

use Web\Config\Database;
use Web\Traits\AdminCheckTrait;


class Transaction {
    use AdminCheckTrait;

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();    
    }

    public function all($limit = 0, $offset = 0) {
        $sql = "SELECT transactions.*, users.username, products.name AS product_name
                FROM transactions
                JOIN users ON transactions.user_id = users.id
                JOIN products ON transactions.product_id = products.id";
        if ($limit > 0) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        $stmt = $this->conn->prepare($sql);

        if ($limit > 0) {
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function count() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM transactions");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function create($userId, $productId, $quantity, $totalPrice) {
        $stmt = $this->conn->prepare("INSERT INTO transactions (user_id, product_id, quantity, total_price) VALUES (:user_id, :product_id, :quantity, :total_price)");
        $stmt->execute([':user_id' => $userId, ':product_id' => $productId, ':quantity' => $quantity, ':total_price' => $totalPrice]);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $userId, $productId, $quantity, $totalPrice) {
        $stmt = $this->conn->prepare("UPDATE transactions SET user_id = :user_id, product_id = :product_id, quantity = :quantity, total_price = :total_price WHERE id = :id");
        $stmt->execute([':user_id' => $userId, ':product_id' => $productId, ':quantity' => $quantity, ':total_price' => $totalPrice, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM transactions WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    
}
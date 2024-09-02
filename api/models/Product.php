<?php
namespace Api\Models;

use Api\Config\Database;

class Product {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function all() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($product) {
        $stmt = $this->conn->prepare("UPDATE products SET quantity_available = :quantity_available WHERE id = :id");
        $stmt->execute([
            ':quantity_available' => $product['quantity_available'],
            ':id' => $product['id']
        ]);
    }
}
?>

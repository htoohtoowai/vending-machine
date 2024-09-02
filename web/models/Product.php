<?php
namespace Web\Models;

use Web\Config\Database;

class Product {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();    
    }

    public function all($limit = 0, $offset = 0) {
        $sql = "SELECT * FROM products";
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
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM products");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function create($name, $price, $quantity) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, price, quantity_available) VALUES (:name, :price, :quantity)");
        $stmt->execute([':name' => $name, ':price' => $price, ':quantity' => $quantity]);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $price, $quantity) {
        $stmt = $this->conn->prepare("UPDATE products SET name = :name, price = :price, quantity_available = :quantity WHERE id = :id");
        $stmt->execute([':name' => $name, ':price' => $price, ':quantity' => $quantity, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

   
}
?>


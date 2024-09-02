<?php
namespace Web\Models;

use Web\Config\Database;
use Web\Traits\AdminCheckTrait;

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();    
    }

    public function all($limit = 0, $offset = 0) {
        $sql = "SELECT * FROM users";
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
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM users");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
    }

    public function create($username, $password, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->execute([':username' => $username, ':password' => $password, ':role' => $role]);
    }

    public function get($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $password, $role) {
        $sql = "UPDATE users SET username = :username, role = :role";
        $params = [':username' => $username, ':role' => $role, ':id' => $id];

        if (!empty($password)) {
            $sql .= ", password = :password";
            $params[':password'] = $password;
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
    
    public function register($username, $password, $role) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->execute([':username' => $username, ':password' => $passwordHash, ':role' => $role]);
    }

    
}
?>

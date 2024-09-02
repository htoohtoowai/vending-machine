<?php
namespace Web\Models;

use Web\Config\Database;

class Admin {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Verify admin credentials
    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username AND role = 'admin'");
        $stmt->execute([':username' => $username]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }

        return false;
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return $this->isAuthenticated() && $_SESSION['role'] === 'admin';
    }
}
?>

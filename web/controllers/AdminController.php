<?php
namespace Web\Controllers;

use Web\Models\Admin;
use Web\Traits\AdminCheckTrait;

class AdminController {
    use AdminCheckTrait;

    private $model;

    public function __construct() {
        $this->model = new Admin();
    }

    public function dashboard() {
        $this->checkAdmin();
        try {
            require 'views/admin/dashboard.php';

        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }

    }

    public function login() {
        
        if (isset($_SESSION['admin_id'])) {
            header('Location: /admin/dashboard');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $admin = $this->model->authenticate($username, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['role'] = 'admin';

                
                header('Location: /admin/dashboard');
                exit();
            } else {
                $_SESSION['error_message'] = 'Invalid username or password.';
                header('Location: /admin/login');
                exit();
            }
        } else {
            require 'views/admin/login.php'; 
        }
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        session_destroy();
        header('Location: /admin/login');
        exit();
    }
}
?>

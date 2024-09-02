<?php
namespace Web\Controllers;

use Web\Models\User;
use Web\Traits\AdminCheckTrait;


class UsersController {
    use AdminCheckTrait;

    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function index() {
        $this->checkAdmin();
        try {
            $limit = 5; 
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
    
            $users = $this->model->all($limit, $offset);
            $totalUsers = $this->model->count();
            $totalPages = ceil($totalUsers / $limit);
            require 'views/user/list.php';
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function create() {
        $this->checkAdmin();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];

                // Validation
                if (empty($username)) {
                    throw new \InvalidArgumentException("Username is required.");
                }
                if (empty($password)) {
                    throw new \InvalidArgumentException("Password is required.");
                }
                if (empty($role)) {
                    throw new \InvalidArgumentException("Role is required.");
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->model->create($username, $hashedPassword, $role);

                // Store the success message in the session
                session_start();
                $_SESSION['success_message'] = "User created successfully!";
                
                header('Location: /users');
                exit();
            } else {
                require 'views/user/add.php';
            }
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function edit($id) {
        $this->checkAdmin();
        try {
            $user = $this->model->get($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];

                // Validation
                if (empty($username)) {
                    throw new \InvalidArgumentException("Username is required.");
                }
                if (empty($role)) {
                    throw new \InvalidArgumentException("Role is required.");
                }

                $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];
                $this->model->update($id, $username, $hashedPassword, $role);

                // Store the success message in the session
                session_start();
                $_SESSION['success_message'] = "User updated successfully!";
                
                header('Location: /users');
                exit();
            }

            require 'views/user/edit.php';
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }

    public function delete($id) {
        $this->checkAdmin();
        try {
            // Validate the ID
            if (!is_numeric($id) || intval($id) <= 0) {
                throw new \InvalidArgumentException("Invalid ID provided");
            }

            // Call the model's delete method
            $this->model->delete($id);

            // Start the session and set a success message
            session_start();
            $_SESSION['success_message'] = "User deleted successfully!";
            
            // Redirect to the users list
            header('Location: /users');
            exit();
        } catch (\Exception $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            exit();
        }
    }
}
?>

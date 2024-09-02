<?php
namespace Api\Controllers;

use Api\Models\User;
use Firebase\JWT\JWT;

class AuthController {
    private $userModel;
    private $key;

    public function __construct() {
        $this->userModel = new User();
        $this->key = $this->getJwtKey();
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $user = $this->userModel->findByUsername($data['username']);
            if ($user && $user['role']=== 'user' && password_verify($data['password'], $user['password'] )) {
                $token = $this->generateJwt($user['id'], $user['role']);
                $this->sendResponse(200, ['token' => $token]);
            } else {
                $this->sendResponse(401, "Invalid credentials.");
            }

        } catch (\Exception $e) {
            $this->sendResponse(500, "Error: " . htmlspecialchars($e->getMessage()));
        }
    }

    public function logout() {
        $this->sendResponse(200, ['message' => 'Logged out successfully. Please delete the token on the client side.']);
    }

    private function generateJwt($userId, $role) {
        $payload = [
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $userId,
            'role' => $role
        ];

        $algorithm = 'HS256';
        return JWT::encode($payload, $this->key, $algorithm);
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

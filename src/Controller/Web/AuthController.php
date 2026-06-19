<?php
namespace App\Controller\Web;

use App\Service\AuthService;

class AuthController {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function showLogin(): void {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($this->authService->login($email, $password)) {
                header('Location: index.php');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect !";
            }
        }

        require_once __DIR__ . '/../../../templates/login.php';
    }

    public function logout(): void {
        $this->authService->logout();
        header('Location: index.php?url=login');
        exit;
    }
}
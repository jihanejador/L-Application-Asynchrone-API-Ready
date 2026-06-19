<?php
namespace App\Service;

use App\Config\Database;

class AuthService {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $email, string $password): ?object {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1");
        $stmt->execute([$email, $password]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = [
                'id' => $user->id,
                'nom' => $user->nom,
                'role' => strtolower($user->role)
            ];
            return (object)$_SESSION['user'];
        }
        return null;
    }

    public function logout(): void {
        $_SESSION = array();
        session_destroy();
    }

    public function isAuthenticated(): bool {
        return isset($_SESSION['user']);
    }

    public function getCurrentUser(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public function hasRole(array $allowedRoles): bool {
        $user = $this->getCurrentUser();
        if (!$user) return false;
        return in_array($user['role'], array_map('strtolower', $allowedRoles));
    }
}
<?php
namespace App\Service;

class AuthService{
    public function __construct(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
    public function isAuthenticated(): bool{
        return isset($_SESSION['user']);
    }
    public function getUserRole(): ?string{
        return $_SESSION['user']['role'] ?? null;
    }

    public function checkRoleOrAbort(string $requiredRole): void {
        if (!$this->isAuthenticated() || $this->getUserRole() !== $requiredRole) {
            header('HTTP/1.1 403 Forbidden');
            header('Content-Type: application/json');
            echo json_encode(['error' => "Accès interdit. Rôle requis : $requiredRole"]);
            exit;
        }
    }
    public function checkRoleOrRedirect(string $requiredRole): void {
        if (!$this->isAuthenticated() || $this->getUserRole() !== $requiredRole) {
            header('HTTP/1.1 403 Forbidden');
            echo "<h1>403 - Accès Interdit</h1><p>Seul le rôle <b>$requiredRole</b> peut voir cette page.</p>";
            exit;
        }
    }
}
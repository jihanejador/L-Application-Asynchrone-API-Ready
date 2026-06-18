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
}
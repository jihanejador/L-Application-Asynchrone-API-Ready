<?php
namespace App\Controller\Web;

use App\Service\AuthService;
use App\Config\Database;

class AdminController{
    private AuthService $authService;

    public function __construct(){
        $this->authService = new AuthService();
    }
}
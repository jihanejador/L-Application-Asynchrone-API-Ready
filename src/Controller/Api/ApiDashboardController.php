<?php
namespace App\Controller\Api;

use App\Service\AuthService;
use App\Config\Database;
use PDO;

class ApiDashboardController{
    private AuthService $authService;
    private PDO $db;
}
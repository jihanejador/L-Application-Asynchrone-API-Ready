<?php
namespace App\Service;

class AuthService{
    public function __construct(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }
}
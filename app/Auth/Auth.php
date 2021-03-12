<?php

namespace App\Auth;

use App\Models\Usuarios;

class Auth {
    public function user() {
        if (isset($_SESSION['user'])) {
            return Usuarios::find($_SESSION['user']);
        }
    }
    
    public function check() {
        return isset($_SESSION['user']);
    }
    
    public function attempt($email, $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        $user = Usuarios::where('email', $email)->first();
        
        if (!$user) {
            return false;
        }
        
        if (password_verify($password, $user->senha)) {
            $_SESSION['user'] = $user->id;
            return true;
        }
        
        return false;
    }
    
    public function loggout() {
        unset($_SESSION['user']);
        if (isset($_SSESION['HomeMesAtual'])) {
            unset($_SESSION['HomeMesAtual']);
        }
        if (isset($_SSESION['HomeIdAtual'])) {
            unset($_SESSION['HomeIdAtual']);
        }
        if (isset($_SSESION['HomeOrdem'])) {
            unset($_SESSION['HomeOrdem']);
        }
        if (isset($_SSESION['HomeSignos'])) {
            unset($_SESSION['HomeSignos']);
        }
    }
}
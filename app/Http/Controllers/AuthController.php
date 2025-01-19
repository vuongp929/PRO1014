<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    
    // Đăng nhập
    public function showFormLogin(){
        return view('auth.login');
    }
    
    public function login(){

    }
    // Đăng ký
    public function showFormRegister(){
        return view('auth.register');
    }
    public function register(){
        
    }
    // Đăng xuất
    public function logout(){
        
    }
}

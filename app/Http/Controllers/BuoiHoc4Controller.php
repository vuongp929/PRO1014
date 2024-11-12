<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuoiHoc4Controller extends Controller
{
    public function xinChao($name, $class) {
        echo "Xin chào các bạn";

        echo "Họ tên là: $name - Lớp: $class";

        $title  = 'Chào mừng quý khách';
        $des    = 'Chúc quý khách vạn sự bình an!';

        // Hiển thị view trong controller
        return view('buoi4', compact('title', 'des'));
    }

    // Tạo 1 route trỏ đến một hàm tính tổng
    // Truyền 2 số lên url
    // Trong hàm tính tổng thực hiện tính giá trị 
    // và hiển thị giá trị ra file view buoi4.php
     
}

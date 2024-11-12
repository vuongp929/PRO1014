<?php

use App\Http\Controllers\Admins\AdminSanPhamController;
use App\Http\Controllers\Admins\AdminsSinhVienController;
use App\Http\Controllers\Admins\AdminsNhanVienController;
use App\Http\Controllers\BuoiHoc4Controller;
use App\Http\Controllers\BuoiHoc5Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// - Routing trong Laravel là chức năng khai báo các đường dẫn
// để đưa người dùng đến các chức năng có trong hệ thống
// - Mỗi một route chỉ sử dụng để trỏ đến 1 chức năng cụ thể

// - Loại 1: Route nạp trực tiếp view
Route::view('/buoi4_1', 'buoi4', [
    'title' => 'Chào mừng quý khách',
    'des' => 'Chúc quý khách vạn sự bình an!'
]);

// - Loại 2: Sử dụng view thông qua controller (Thường dùng)
Route::get('/buoi4_2/{name}/{class}',   [BuoiHoc4Controller::class, 'xinChao']);
Route::get('/buoi5',                    [BuoiHoc5Controller::class, 'buoiHoc5']);

Route::resource('sanphams',             AdminSanPhamController::class);
Route::resource('sinhviens',            AdminsSinhVienController::class);
Route::resource('nhanviens',            AdminsNhanVienController::class);



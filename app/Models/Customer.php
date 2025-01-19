<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Định nghĩa bảng mà model này tương ứng
    protected $table = 'customers';

    // Các thuộc tính có thể gán (fillable)
    protected $fillable = ['name', 'email', 'is_admin', 'phone', 'address'];

    // Mối quan hệ với bảng orders (Một customer có nhiều đơn hàng)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

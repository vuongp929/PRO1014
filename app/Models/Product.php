<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Định nghĩa bảng mà model này tương ứng
    protected $table = 'products';

    // Các thuộc tính có thể gán (fillable)
    protected $fillable = ['name', 'price', 'description', 'stock', 'image'];

    /**
     * Mối quan hệ với Category (Nhiều product thuộc về nhiều category thông qua bảng trung gian product_category).
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id')
                    ->withTimestamps(); // Thêm thông tin thời gian nếu cần
    }

    /**
     * Mối quan hệ với ProductVariant (Một product có nhiều variant).
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Mối quan hệ với Order thông qua bảng trung gian order_product.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity', 'price') // Nếu bảng trung gian có thêm cột
                    ->withTimestamps(); // Nếu cần lấy thông tin thời gian thêm vào
    }
}

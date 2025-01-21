<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Định nghĩa bảng mà model này tương ứng
    protected $table = 'categories';

    // Các thuộc tính có thể gán (fillable)
    protected $fillable = ['name', 'slug'];

    /**
     * Mối quan hệ với Product (Nhiều category chứa nhiều product thông qua bảng product_category).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_id', 'product_id')
                    ->withTimestamps(); // Thêm thông tin thời gian nếu cần
    }
}

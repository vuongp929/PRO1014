<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'price',
        'stock',
    ];

    // Quan hệ với sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với chi tiết đơn hàng
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

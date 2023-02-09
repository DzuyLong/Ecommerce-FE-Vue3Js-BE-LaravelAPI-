<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = ['customer_id','total','status','created_at','updated_at'];
     /* Một Cart sẽ thuộc về một customer */
     public function customer() {
        return $this->belongsTo(Customer::class , 'customer_id', 'id');
    }
    /* giỏ hàng sẽ có nhiều sản phẩm với relationship many-to-many với products
    qua một bảng trung gian là cart_items
    */
    public function products() {
        return $this->belongsToMany(Product::class, 'cart_items', 'cart_id', 'product_id' , 'id', 'id')->withTimestamps()->withPivot('quantity');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Customer extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'customer';
    protected $table = 'customers';
    protected $fillable = ['username','password','first_name','last_name','telephone','created_at','updated_at'];
    protected $hidden = [
      'password',
  ];
      /* Một Customer sẽ có một CartShopping */
    public function cart() {
        return $this->hasOne(Cart::class , 'customer_id', 'id');
    }
    /* Một Customer sẽ có nhiều địa chỉ nhận hàng */
    public function customerAddresses() {
      return $this->hasMany(CustomerAddress::class , 'customer_id', 'id');
  }
}

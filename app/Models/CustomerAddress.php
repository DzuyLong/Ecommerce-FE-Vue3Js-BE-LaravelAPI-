<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $table = 'customer_addresses';
    protected $fillable = ['customer_id','fullname','province_code','district_code','ward_code','details_address','telephone','created_at','updated_at'];

     /* Một Address sẽ chỉ thuộc về một customer */
     public function customer() {
        return $this->belongsTo(Customer::class , 'customer_id', 'id');
    }

}



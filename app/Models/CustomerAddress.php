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
    // một tỉnh/thành phố thuộc 1 customer_address sẽ chỉ thuộc về một tỉnh/thành phố province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
    // một Quận/Huyện thuộc 1 customer_address sẽ chỉ thuộc về một Quận/Huyện
    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
    // một xã/phường  thuộc 1 customer_address sẽ chỉ thuộc về một xã/phường
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }

}



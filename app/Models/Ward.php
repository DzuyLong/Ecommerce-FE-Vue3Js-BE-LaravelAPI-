<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
class Ward extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = "wards";
    protected $fillable = ['code', 'name', 'name_en','full_name','full_name_en', 'code_name','district_code'];
    protected $primaryKey = 'code';
    // tạo các mối quan hệ cho Wards
    // Một xã/Phường (ward) có thể có trong nhiều địa chỉ của khách hàng (customer_address) tương ứng.
    public function customerAddresses() {
        return $this->hasMany(CustomerAddress::class, 'ward_code', 'code');
    }
  
    public function district()
    {
        // Xã/Phường đơn thì chỉ thuộc về một quận/ Huyện
        return $this->belongsTo(District::class, 'district_code','code');
    }
}

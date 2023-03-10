<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
class Province extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = "provinces";
    protected $fillable = ['code', 'name', 'name_en','full_name','full_name_en', 'code_name'];
    protected $primaryKey = 'code';
    // tạo các mối quan hệ cho Province
        // Một tỉnh/thành phố (province) có thể có nhiều địa chỉ của khách hàng (customer_address) tương ứng.
    public function customerAddresses() {
        return $this->hasMany(CustomerAddress::class, 'province_code', 'code');
    }

    public function districts() {
        // một tỉnh hoặc thành phố sẽ có nhiều Quận Huyện
        return $this->hasMany(District::class, 'province_code','code');
    }

}

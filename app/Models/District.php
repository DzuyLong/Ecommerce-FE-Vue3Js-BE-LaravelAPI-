<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Province;
use App\Models\Ward;
class District extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = "districts";
    protected $fillable = ['code', 'name', 'name_en','full_name','full_name_en', 'code_name','province_code'];
    protected $primaryKey = 'code';
    // tạo các mối quan hệ cho Districts

    public function province() {
        // Như vậy một quận/huyện sẽ chỉ thuộc về một Tỉnh/Thành Phố
        return $this->belongsTo(Province::class, 'province_code','code');
    }
    public function wards() {
        // tương tự như provinces một quận/huyện sẽ có nhiều phường/xã
        return $this->hasMany(Ward::class, 'district_code','code');
    }
}

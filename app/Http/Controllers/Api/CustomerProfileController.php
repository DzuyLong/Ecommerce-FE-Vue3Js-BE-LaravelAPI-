<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestFormAddAddress;
class CustomerProfileController extends Controller
{
    public function fetchProvinces() {
        $province = Province::all();
        return response([
            'data' => $province,
        ]);
    }
    public function fetchDistricts($idProvince) {
            $value = (int) $idProvince;
           $province = Province::find($value);
           $getDistrict = $province->districts;
           return response([
            'data' => $getDistrict,
        ]);
    }
    public function fetchWards($idDistrict) {
        $value = (int) $idDistrict;
        $district = District::find($value);
        $getWards = $district->wards;
        return response([
            'data' => $getWards,
        ]);
    }
    public function addAddress(RequestFormAddAddress $requestAddAddress) {
        $data = $requestAddAddress->validated();
        $customer = Auth::user()->id;
        $customerAddress = new CustomerAddress();
        $customerAddress->customer_id = $customer;
        $customerAddress->fullname = $data['fullName'];
        $customerAddress->telephone = $data['phoneNumber'];
        $customerAddress->details_address = $data['addressDetail'];
        $customerAddress->province_code = $data['province']; 
        $customerAddress->district_code = $data['district']; 
        $customerAddress->ward_code = $data['ward'];
        $customerAddress->save();

        return response([
            'message' => 'Thêm địa chỉ mới thành công!',    
        ]);
    }

    public function getAddress() {
        $customer = Auth::user();
    }
}

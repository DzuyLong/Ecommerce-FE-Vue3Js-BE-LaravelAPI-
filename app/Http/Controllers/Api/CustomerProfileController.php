<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthCustomer;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Customer;
use App\Models\District;
use App\Models\Ward;
use App\Models\Order;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestFormAddAddress;
use Carbon\Carbon;
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
        $getAddress = CustomerAddress::with('province','district','ward')->where('customer_id', $customer->id)->get();
        return response()->json([
            'getAddress' => $getAddress,
        ]);
        
    }
    public function deleteAddress($AddressId) {
        
        $Address = CustomerAddress::find($AddressId)->delete();
        return response()->json([
            'addressId' => $Address,
        ]);
    }
    public function updateProfile(Request $request) {
        $data = $request->all();
        $customer = Auth::user();
        $profileCustomer = Customer::find($customer->id);
        $profileCustomer->ngaysinh = Carbon::parse($data['ngaysinh'])->format('Y-m-d');
        $profileCustomer->gioitinh = $data['gioitinh']; 
        $profileCustomer->email = $data['email'];
        $profileCustomer->first_name = $data['first_name'];
        $profileCustomer->last_name = $data['last_name'];
        $profileCustomer->save();
        return response()->json([
            'data' =>  $data,
            'message' => 'Cập nhật hồ sơ thành công!',
        ]);
    }
    public function checkout(Request $request) {
        $Address = $request->checkedAddresses;
        $carts = $request->checkedCarts; 
        $id_address = $request->getIdAddress;
        $id_cart = $request->getIdCarts;
        $total = $request->total;
        $customer = Auth::user();
        $orders = new Order();
        $orders->customer_id = $customer->id;
        $orders->customer_address = $Address[$id_address]['province']['name'];
        $orders->customer_phone = $Address[$id_address]['telephone'];
        $orders->customer_name = $Address[$id_address]['fullname'];
        $orders->purchanse_total = $total;
        $orders->save();
        return response()->json([
           'id_address' => $id_address,
           'address' => $Address[$id_address]['province']['name'],
           'total' => $total,
        ]);
    }
}

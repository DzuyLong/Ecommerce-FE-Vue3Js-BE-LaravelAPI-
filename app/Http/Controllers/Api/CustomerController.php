<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCustomerRequest;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class CustomerController extends Controller
{
   public function registerCustomer(Request $request) 
   {
    $data = $request->validate([
        'username' => 'required|string|unique:customers,username',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'telephone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'password' => [
            'required',
            'confirmed',
            Password::min(8)->mixedCase()->numbers()->symbols()
        ],
    ]);
    
     /** @var \App\Models\Customer $customer */
     $customer = Customer::create([
        'username' => $data['username'],
        'password' => Hash::make($data['password']),
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'telephone' => $data['telephone'],
     ]);
     $token = $customer->createToken('customerToken')->plainTextToken;
    
     return response([
        'customer' => $customer,
        'token' => $token,
        'statustext' => 'Đăng Ký thành công! Vui lòng vào trang để đăng nhập.'
     ]);
   }

   public function loginCustomer(LoginCustomerRequest $request) 
   {
    $request->validated($request->all());

    if (!Auth::guard('customer')->attempt($request->only(['username','password']))) {
        return response([
            'message' => 'Username or password is incorrect'
        ], 422);
    }


         /** @var \App\Models\Customer $customer */
         $customer = Auth::guard('customer')->user();
         $token = $customer->createToken('customerToken')->plainTextToken;
         return response([
            'customer' => new CustomerResource($customer),
            'token' => $token,
        ]);
    
   
   }

   public function logoutCustomer()
    {
        /** @var \App\Models\Customer $customer */
        $customer = Auth::user();
        // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        $customer->currentAccessToken()->delete();

        return response('', 204);
    }

   public function getCustomer() {
    $customer = Auth::user();
    return new CustomerResource($customer);

}

}
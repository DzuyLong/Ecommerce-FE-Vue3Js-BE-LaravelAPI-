<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order_detail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
class RelationshipController extends Controller
{
    public function product (){
        // $product = Product::find(1);
        $product_inventory = Product::find(4);
        
        Session::put('product',$product_inventory);
        
    }
    public function order (Request $request){
     $customer = Customer::find(103);
     $address = $customer->customerAddresses;
     dd($address);
        
    }
}

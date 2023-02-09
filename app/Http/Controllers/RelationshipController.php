<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductCategory;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order_detail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class RelationshipController extends Controller
{
    public function product (){
        // $product = Product::find(1);
        $product_inventory = Product::find(4);
        
        Session::put('product',$product_inventory);
        
    }
    public function order (Request $request){
        // $query = Cart::find(1);
        // foreach ($query->products as $queryy){
        //     echo $queryy->pivot->quantity . "<br>";
        // }
        // dd($query->cart);
        //  $query = Cart::find(1);
        //  $query->products()->sync([
        //     8 => ['quantity' => 12],
        //  ]);
        //  return redirect('/relationship/order');
       
        dd($request->user());
        
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\URL;
class CartController extends Controller
{
    public function addCart(Product $product) {
        // Lấy thông tin khách hàng đăng nhập
        $customer = Auth::user();
        // Lấy giỏ hàng của khách hàng
        $cart = $customer->cart;
        // Nếu chưa có giỏ hàng thì tạo mới
        if(!$cart) {
            $cart = new Cart();
        // Liên kết giỏ hàng với khách hàng
            $cart->customer()->associate($customer);
            $cart->save();
        }

        /* tìm một sản phẩm và một giỏ hàng cụ thể, sau đó sử dụng phương thức contains 
        để kiểm tra xem sản phẩm có nằm trong giỏ hàng chưa. Nếu sản phẩm đã có trong giỏ hàng, 
        sử dụng phương thức where để tìm pivot table liên kết giữa sản phẩm và giỏ hàng, s
        au đó tăng giá trị trường quantity lên 1 và lưu lại.*/

       /* Phương thức contains trong đoạn mã $cart->products->contains($product) 
        là một phương thức có sẵn trong lớp collection của Laravel. 
        Nó kiểm tra xem một đối tượng cụ thể có nằm trong tập hợp hay không.
        Nếu đối tượng đó có trong tập hợp, phương thức sẽ trả về giá trị true,
        ngược lại nếu đối tượng đó không có trong tập hợp thì phương thức sẽ trả về giá trị false.*/
        if (!$cart->products->contains($product->id)) {   
            $cart->products()->syncWithoutDetaching([
                $product->id => ['quantity' => 1],
            ]);
        }else{
            $pivot = $cart->products()->where('product_id', $product->id)->first()->pivot;
            $pivot->quantity += 1;
            $pivot->save();
        }

        
        return response()->json($cart->load('products'));
       
    }
    public function Cart() {
        $customer = Auth::user();
        $cart = $customer->cart;
        
        return response()->json($cart->products);
    }
    
}
/* with: Phương thức with được sử dụng để tải dữ liệu từ các 
        bảng liên kết vào khi truy vấn dữ liệu chính. Ví dụ, nếu 
        bạn muốn truy vấn dữ liệu từ bảng Cart và tải cả dữ liệu 
        từ bảng Product liên kết với Cart, bạn có thể sử dụng phương 
        hức with như sau: $carts = Cart::with('products')->get();.

        load: Phương thức load được sử dụng để tải dữ liệu từ các bảng 
        liên kết vào một đối tượng đã được truy vấn từ trước. Ví dụ, 
        nếu bạn đã truy vấn dữ liệu từ bảng Cart, và muốn tải dữ liệu 
        từ bảng Product liên kết với Cart, bạn có thể sử dụng phương thức 
        load như sau: $cart = Cart::find(1); $cart->load('products');.
        */

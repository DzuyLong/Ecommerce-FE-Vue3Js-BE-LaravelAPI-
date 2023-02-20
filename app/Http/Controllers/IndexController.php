<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\resourcesite\ProductResourceSite;
use App\Http\Resources\ProductCategoryListResource;
use App\Http\Resources\ProductInventoryResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductInventory;
class IndexController extends Controller
{
    public function slides() {
        $query = Product::where('published', 1)->where('hot_swiper', 1)->orderBy('created_at','DESC')->get();
        return ProductResourceSite::collection($query);
    }
    public function index(){
        $query = Product::where('published', 1)->orderBy('created_at','DESC')->get();
        return ProductResourceSite::collection($query);
    }
    public function listCate() {
        $query = ProductCategory::all();
        return ProductCategoryListResource::collection($query);
        
    }
    public function Category($slug){
        $query = ProductCategory::where('slug',$slug)->first();
        $query = $query->products;
        return ProductResourceSite::collection($query);
    } 
    public function ProductDetail($slug) {
        $query = Product::where('slug', $slug)->first();
        $quantity = $query->productInventory;
        $relatedProduct = Product::where('category_id', $query->category_id)->where('id','!=', $query->id)->get();
       return response([
        'relatedProduct' =>  ProductResourceSite::collection($relatedProduct),
        'data' => new ProductResourceSite($query),
        'quantity' => new ProductInventoryResource($quantity),
       ]);
    }
    
}

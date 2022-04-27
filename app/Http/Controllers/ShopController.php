<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ShopController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->limit (4)->get();
        return view('shop')->withProduct($products);
    }
    public function getProductDetail(){
        $products = Product::orderBy('created_at', 'desc')->limit (1)->get();
        return view('product_detail')->withProduct($products);
    }
}

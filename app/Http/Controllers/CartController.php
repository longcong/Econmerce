<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function addProduct(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status'=>"Login to Continue"]);
        }

        $product_id = $request->get('product_id');
        $prod_check = Product::where('id',$product_id)->first();

        if (!$prod_check) {
            return response()->json(['status'=>"Product not found"]);
        }

        $product = Product::where('id',$product_id)->first();
        $stockQuantity = $product->quantity;

        if($carttm = Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->first()){
            $quantitycartitems = $carttm->prod_qty;
            if($quantitycartitems >= $stockQuantity){
                return response()->json(['status'=>"Over quantity in stock"]);
            }
        }

        if(Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->exists())
        {

            if($prod_check = Product::where('id',$product_id)->first())
            {
                if(Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->exists())
                {
                    $cartItem = Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->first();
                    $cartItem->prod_qty = $cartItem->prod_qty + 1;
                    $cartItem->save();
                    return response()->json(['status'=>$prod_check->name."Quantity Update"]);

                }
                else
                {
                    $cartItem = new Cart();
                    $cartItem->prod_id = $product_id;
                    $cartItem->prod_qty = 1;
                    $cartItem->user_id = Auth::id();
                    $cartItem->save();
                    return response()->json(['status'=>$prod_check->name."Added to Cart"]);
                }       

            }
        }
        else
        {
            $cartItem = new Cart();
            $cartItem->prod_id = $product_id;
            $cartItem->prod_qty = 1;
            $cartItem->user_id = Auth::id();
            $cartItem->save();
            return response()->json(['status'=>$prod_check->name."Added to Cart"]);
        }
        
        




        // $product_id = $request->input('product_id');
        // if(Auth::check())
        // {
        //     $prod_check = Product::where('id',$product_id)->first();
            
        //     if($prod_check)
        //     {
        //         if(Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->exists())
        //         {
        //             return response()->json(['status'=>$prod_check->name."Already Added to Cart"]);
        //         }
        //         else
        //         {
        //             $cartItem = new Cart();
        //             $cartItem->prod_id = $product_id;
        //             $cartItem->prod_qty = 1;
        //             $cartItem->user_id = Auth::id();
        //             $cartItem->save();
        //             return response()->json(['status'=>$prod_check->name."Added to Cart"]);
        //         }       

        //     } else {
        //         dd('sdfsd');
        //     }
        // }
        // else
        // {
        //     return response()->json(['status'=>"Login to Continue"]);
        // }
    }

    public function viewcart(Request $request)
    {
        $cartitems = Cart::where('user_id',Auth::id())->get();
        return view('cart', compact('cartitems'));
    }

    public function updateCart(Request $request){

        if(!Auth::check())
        {
            return response()->json(['status'=>"Need login"]);
            
        }
        $product_id = $request->input('product_id');
        $cartItemQty = $request->input('prod_qty');

        $product = Product::where('id',$product_id)->first();
        $stockQuantity = $product->quantity;
        if($stockQuantity < $cartItemQty )
        {
            return response()->json(['status'=>"Not enough quantity in stock"]);
        }
        if(!Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->first())
        {
            return response()->json(['status'=>"Not found product"]);
        }
        
        $cart = Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->first();
        $cart->prod_qty = $cartItemQty ;
        
        
        $cart->update();
        return response()->json(['status'=>"Quatity update"]);

        // $total = 0;
        // $total += ($cart->products->price - $cart->products->discount_value) * $cart->prod_qty;
        // dd($total);

        // foreach($cart as $item){

        // }
        

    }

    public function deleteProduct(Request $request){
        if(Auth::check())
        {
            $product_id = $request->input('product_id');
            if(Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->exists())
            {
                $cartItem = Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->first();
                $cartItem -> delete();
                return response()->json(['status'=> "Product Deleted Successfully"]);
            }
        }
        else{
            return response()->json(['status'=>"Login to Continue"]);
        }
    }
    
    public function applyCoupon(Request $request)
    {   
        $CartCount = Cart::where('user_id',Auth::id())->get();
        $Count = $CartCount->count();
        if($Count == 0){
            $request->session()->flash('errors', 'Chưa có sản phẩm nhập mã giảm giá anl à!');
            return redirect()->back();
        }
        else{
            Session::forget('couponAmount');
            Session::forget('code');
            Session::forget('totalFinal');
            if($request->isMethod('post')){
                $data = $request->all();
                $couponCount = Coupon::where('code',$data['code'])->count();
                if($couponCount == 0){
                    $request->session()->flash('errors', 'Coupon code does not exists!');
                    return redirect()->back();
                }
                
                else{
                    $couponDetail = Coupon::where('code',$data['code'])->first();
                    if(!$couponDetail->is_active == 1){
                        $request->session()->flash('errors', 'Coupon code is not active!');
                        return redirect()->back();
                    }
                    $expiry_date = $couponDetail->expiry_date;
                    $current_date = date('Y-m-d');
                    if($current_date > $expiry_date){
                        $request->session()->flash('errors', 'Coupon code is not Expired!');
                        return redirect()->back();
                    }
                    $start_date = $couponDetail->start_date;
                    if($current_date < $start_date){
                        $request->session()->flash('errors', 'Coupon code is not Expired!');
                        return redirect()->back();
                    }
                    //$aaa = $request->input('cart_id');
                    $type = $couponDetail->type;
                    $type_condition_1 = 'Category_base';
                    //$type_condition_2 = 'Product_base';
                    if($type != $type_condition_1){
                        $request->session()->flash('errors', 'Coupon code are not Apply to these products!');
                        return redirect()->back();
                    }
                    // sét số lượng mã giảm giá
                    
                    // $cartquant = new Cart();
                    // $cartquant->quantity_cou = 1;

                    // if($type == $type_condition_1){    
                    //     dd('oke');    
                    // }elseif($type == $type_condition_2){
                    //     dd('done');
                    // }else{
                    //     dd('xxx');
                    // }
                    
                        // set mã giảm giá theo số lượng.

                        // $userCart = Cart::where('user_id',Auth::id())->get();
                        // $CountCart = $userCart->count();
                        // if($CountCart < 3){
                        //     $request->session()->flash('errors', 'Coupon code does not apply to the above product total. You need to add the product number if you want to use it!');
                        //     return redirect()->back();
                        // }
                    $userCart = Cart::where('user_id',Auth::id())->get();
                    $total= 0;
                    foreach($userCart as $item){
                        $total += ($item->products->price - $item->products->discount_value) * $item->prod_qty;   
                    }
                
                    if($couponDetail->discount_type == 'Amount'){
                        $couponAmount = $couponDetail->discount_coup;
                    }
                    else{
                        $couponAmount = $total * ($couponDetail->discount_coup/100);
                    }

                    $totalFinal = $total - $couponAmount;
                    Session::put('couponAmount',$couponAmount);
                    Session::put('code',$data['code']);
                    Session::put('totalFinal',$totalFinal);
                    
                    

                    $request->session()->flash('success', 'Coupon code is Successfully Applied. You are Availing Discount!');
                    return redirect()->back();
                }
            }
        }
    }
        
}
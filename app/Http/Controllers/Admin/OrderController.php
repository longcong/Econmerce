<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductInterface;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request, ProductInterface $productService)
    {
        $orders = $productService->getOrder();
        return view('admin.orders.index', compact('orders'));
    }
    public function view(Request $request, $id, ProductInterface $productService)
    {
        $orders = Order::where('id', $id)->first();
        $users = User::where('id',Auth::id())->first();
        return view('admin.orders.view', compact('orders','users'));
    }
    public function updateorder(Request $request)
    {
        $orders = Order::find($request->order_id);
        $orders->status = $request->status;
        $orders->save();
    }
    public function orderhistory()
    {
        $orders = Order::where('status','1')->get();
        return view('admin.orders.history', compact('orders'));
    }
}

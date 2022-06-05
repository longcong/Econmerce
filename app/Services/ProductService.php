<?php

namespace App\Services;

use App\Category;
use App\Product;
use App\Interfaces\ProductInterface;
use App\Order;
use App\Tag;

Class ProductService implements ProductInterface{

    public function getPopulars(int $limit = 4){
        return Product::where('is_popular', 1)->orderBy('id','desc')->paginate($limit);
    }
    public function getProducts(int $limit = 12){
        return Product::orderBy('id', 'desc')->limit($limit)->get();
    }
    public function getCategories(){
        return Category::all();
    }
    public function getTag(){
        return Tag::all();
    }
    public function getOrder(){
        return Order::where('status','0')->get();
    }
}



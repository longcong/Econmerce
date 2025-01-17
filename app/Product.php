<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $table = 'products';
    protected $fillable =[
        
    ];
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    } 
    public function wishlist(){
        return $this->belongsToMany('App\Wishlist');
    }
    public function brand(){
        return $this->belongsTo('App\Brands');
    }
    public function fabric(){
        return $this->belongsTo('App\Fabric');
    } 
    

}

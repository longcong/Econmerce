<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Product;

class OrderItem extends Model
{
  protected $table= 'order_detail';
  protected $fillable =[
    'order_id',
    'product_id',
    'price',
    'quantity',
    'status',
  ];
  public function products(): BelongsTo
  {
    return $this->belongsTo(Product::class, 'product_id','id');
  }
}

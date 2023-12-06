<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $products = null;
    public $totalPrice = 0;
    public $totalQuantity = 0;
    public function __construct($cart){
        if ($cart){
            $this -> products = $cart ->products;
            $this -> totalPrice = $cart ->totalPrice;
            $this -> totalQuantity = $cart ->totalQuantity;
        }
    }
    public function addCart($product,$id){
        $products = [];
        $newProduct = ['quanty' =>0,'price'=> $product->price, 'proInfor' =>$product];
        if ($this -> products){
           if (array_key_exists($id, $products)){
               $newProduct = $products[$id];
           }
        }

        $newProduct['quanty']++;
        $newProduct['price'] = $newProduct['quanty']* $product->price;
         $this->products[$id] = $newProduct;
         $this->totalPrice += $product->price;
         $this->totalQuantity ++;
    }
}





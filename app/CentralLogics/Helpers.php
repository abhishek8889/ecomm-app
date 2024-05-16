<?php
namespace App\CentralLogics;
use App\Models\Product;
class Helpers{
    public static function generateUniqueChar($name,$length){
        $char = strtolower(substr($name,0,$length).'-'.rand(100,999));
        $product = Product::where('slug',$char)
                    ->orWhere('sku',$char)
                    ->first();
        if($product){
            return self::generateUniqueChar($name,$length);
        }
        return $char;
    }
    
    
}
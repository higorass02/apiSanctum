<?php

namespace App\Exceptions\Validations\Products;

use App\Models\Categories;
use App\Models\Products;

class ProductsValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if(!Categories::where('id',$payload['category_product'])->get()->last()){
            throw new \InvalidArgumentException("Dont found Category");
        }
        $products = Products::where('title','like',$payload['title'])->get()->last();
        if($id){
            $products = Products::where('title','like',$payload['title'])->where('id','<>',$id)->get()->last();
        }
        if($products){
            throw new \InvalidArgumentException("Already Product with equals title");
        }
    }

    public static function isEnabled($product): void{
        if($product->status != Products::STATUS_ENABLED){
            throw new \InvalidArgumentException("Product already disabled");
        }
    }

    public static function isDisabled($product): void{
        if($product->status != Products::STATUS_DISABLED){
            throw new \InvalidArgumentException("Product already disabled");
        }
    }

    public static function isListEmpty($product): void{
        if($product->count() == 0){
            throw new \InvalidArgumentException("Product are Empty");
        }
    }

    public static function isExist($product,$id): void{
        if(!$product){
            throw new \InvalidArgumentException("Dont find product {ID: ".$id."}");
        }
    }

    public static function isDirty($product): void{
        if(!$product->isDirty()){
            throw new \InvalidArgumentException("There is no change the Product");
        }
    }
}

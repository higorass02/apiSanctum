<?php

namespace App\Exceptions\Validations\ProductsSales;

use App\Models\Products;

class ProductsSalesValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if(!Products::where('id',$payload['product_sale'])->get()->last()){
            throw new \InvalidArgumentException("Dont found Product");
        }
    }

    public static function isListEmpty($productSale): void{
        if($productSale->count() == 0){
            throw new \InvalidArgumentException("Sale of Products are Empty");
        }
    }

    public static function isExist($product,$id): void{
        if(!$product){
            throw new \InvalidArgumentException("Dont find Sale of Products {ID: ".$id."}");
        }
    }

    public static function isDirty($productSale): void{
        if(!$productSale->isDirty()){
            throw new \InvalidArgumentException("There is no change the Sale");
        }
    }

}

<?php

namespace App\Exceptions\Validations\ProductsStock;

use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductsStock;

class ProductsStockValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if(!Products::where('id',$payload['product_stock'])->get()->last()){
            throw new \InvalidArgumentException("Dont found Product");
        }
    }

    public static function isListEmpty($productStock): void{
        if($productStock->count() == 0){
            throw new \InvalidArgumentException("Stock of Products are Empty");
        }
    }

    public static function isExist($product,$id): void{
        if(!$product){
            throw new \InvalidArgumentException("Dont find Stock of Products {ID: ".$id."}");
        }
    }

}

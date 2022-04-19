<?php

namespace App\Exceptions\Validations\ProductsPhoto;


use App\Models\Products;
use App\Models\ProductsPhotos;

class ProductsPhotoValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if(!Products::where('id',$payload['product_photo'])->get()->last()){
            throw new \InvalidArgumentException("Dont found Product");
        }
    }

    public static function isListEmpty($productPhoto): void{
        if($productPhoto->count() == 0){
            throw new \InvalidArgumentException("Photo this Products are Empty");
        }
    }

    public static function isExist($productPhoto,$id): void{
        if(!$productPhoto){
            throw new \InvalidArgumentException("Dont find Photo of Products {ID: ".$id."}");
        }
    }

    public static function isEnabled($productPhoto): void{
        if($productPhoto->status != Products::STATUS_ENABLED){
            throw new \InvalidArgumentException("Product already disabled");
        }
    }

    public static function isDisabled($productPhoto): void{
        if($productPhoto->status != Products::STATUS_DISABLED){
            throw new \InvalidArgumentException("Product already disabled");
        }
    }

}

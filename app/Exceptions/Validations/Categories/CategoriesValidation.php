<?php

namespace App\Exceptions\Validations\Categories;

use App\Models\Categories;

class CategoriesValidation
{
    public static function isEnabled($category): void{
        if($category->status == Categories::STATUS_ENABLED){
            throw new \InvalidArgumentException("Category already disabled");
        }
    }

    public static function isDisabled($category): void{
        if($category->status == Categories::STATUS_DISABLED){
            throw new \InvalidArgumentException("Category already disabled");
        }
    }

    public static function isListEmpty($category): void{
        if($category->count() == 0){
            throw new \InvalidArgumentException("Categories are Empty");
        }
    }

    public static function isExist($category,$id): void{
        if(!$category){
            throw new \InvalidArgumentException("Dont find category {ID: ".$id."}");
        }
    }

}

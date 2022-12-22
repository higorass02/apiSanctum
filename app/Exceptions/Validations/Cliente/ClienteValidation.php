<?php

namespace App\Exceptions\Validations\Cliente;

use App\Models\Salao\Cliente;

class ClienteValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if($id){
            $cliente = Cliente::where('name','like',$payload['name'])->where('id','<>',$id)->get()->last();
        }else{
            $cliente = Cliente::where('name','like',$payload['name'])->get()->last();
        }        
        if($cliente){
            throw new \InvalidArgumentException("Already Product with equals title");
        }
    }

    public static function isEnabled($cliente): void{
        if($cliente->status != Cliente::STATUS_ENABLED){
            throw new \InvalidArgumentException("Product already disabled");
        }
    }

    public static function isDisabled($cliente): void{
        if($cliente->status != Cliente::STATUS_DISABLED){
            throw new \InvalidArgumentException("Product already disabled");
        }
    }

    public static function isListEmpty($cliente): void{
        if($cliente->count() == 0){
            throw new \InvalidArgumentException("Product are Empty");
        }
    }

    public static function isExist($cliente,$id): void{
        if(!$cliente){
            throw new \InvalidArgumentException("Dont find product {ID: ".$id."}");
        }
    }

    public static function isDirty($cliente): void{
        if(!$cliente->isDirty()){
            throw new \InvalidArgumentException("There is no change the Product");
        }
    }
}

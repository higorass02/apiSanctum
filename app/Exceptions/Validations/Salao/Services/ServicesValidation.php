<?php

namespace App\Exceptions\Validations\Salao\Services;

use App\Models\Salao\Services;

class ServicesValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if($id){
            $services = Services::where('name','like',$payload['name'])->where('id','<>',$id)->get()->last();
        }else{
            $services = Services::where('name','like',$payload['name'])->get()->last();
        }        
        if($services){
            throw new \InvalidArgumentException("Already Service with equals title");
        }
    }

    public static function isEnabled($services): void{
        if($services->status != Services::STATUS_ENABLED){
            throw new \InvalidArgumentException("Service already disabled");
        }
    }

    public static function isDisabled($services): void{
        if($services->status != Services::STATUS_DISABLED){
            throw new \InvalidArgumentException("Service already enabled");
        }
    }

    public static function isListEmpty($services): void{
        if($services->count() == 0){
            throw new \InvalidArgumentException("Service are Empty");
        }
    }

    public static function isExist($services,$id): void{
        if(!$services){
            throw new \InvalidArgumentException("Dont find service {ID: ".$id."}");
        }
    }


    public static function isDirty($services): void{
        if(!$services->isDirty()){
            throw new \InvalidArgumentException("There is no change the Service");
        }
    }
}

<?php

namespace App\Exceptions\Validations\Salao\Scheduling;

use App\Models\Salao\Scheduling;

class SchedulingValidation
{
    public static function isValidateAtributes($payload, $id = null){
        if($id){
            $scheduling = Scheduling::where('dt_scheduling','=',$payload['dt_scheduling'])->where('id','<>',$id)->get()->last();
        }else{
            $scheduling = Scheduling::where('dt_scheduling','=',$payload['dt_scheduling'])->get()->last();
        }        
        if($scheduling){
            throw new \InvalidArgumentException("Already Scheduling with equals title");
        }
    }

    public static function isEnabled($scheduling): void{
        if($scheduling->status == Scheduling::STATUS_ENABLED){
            throw new \InvalidArgumentException("Scheduling is enabled");
        }
    }

    public static function isDisabled($scheduling): void{
        if($scheduling->status == Scheduling::STATUS_DISABLED){
            throw new \InvalidArgumentException("Scheduling is disabled");
        }
    }

    public static function isListEmpty($scheduling): void{
        if($scheduling->count() == 0){
            throw new \InvalidArgumentException("Scheduling are Empty");
        }
    }

    public static function isExist($scheduling,$id): void{
        if(!$scheduling){
            throw new \InvalidArgumentException("Dont find Scheduling {ID: ".$id."}");
        }
    }


    public static function isDirty($scheduling): void{
        if(!$scheduling->isDirty()){
            throw new \InvalidArgumentException("There is no change the Scheduling");
        }
    }

    public function isAlreadyScheduled($payload)
    {
        $datePayLoad = $payload['dt_scheduling']->format('d-m-Y');
        $scheduling = Scheduling::
            where('dt_scheduling', $payload['dt_scheduling']->format('Y-m-d'))
            ->where('id_cliente', $payload['id_cliente'])
            ->where('id_services', $payload['id_services'])
            ->where('status', Scheduling::STATUS_ENABLED)
            ->get()
            ->last();
        if($scheduling){
            throw new \InvalidArgumentException("Date already has another appointment {DT_SCHEDUCLING: '$datePayLoad', ID_CLIENTE: $scheduling->id_cliente, ID_SERVICES: $scheduling->id_services }");
        }
    }

    public function isDateAlreadyHasAnotherScheduled()
    {
        
    }
}

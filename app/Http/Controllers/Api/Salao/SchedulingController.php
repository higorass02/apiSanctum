<?php

namespace App\Http\Controllers\Api\Salao;

use App\Exceptions\Validations\Salao\Scheduling\SchedulingValidation;
use App\Exceptions\Validations\Salao\Cliente\ClienteValidation;
use App\Exceptions\Validations\Salao\Services\ServicesValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchedulingRequest;
use App\Models\Salao\Scheduling;
use App\Models\Salao\Services;
use App\Models\Salao\Cliente;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $scheduling = Scheduling::select('*')->where('status',Scheduling::STATUS_ENABLED)->get();
            $response['services'] = $scheduling;
            return $this->success($response,'load success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }


    /**
     * @param SchedulingRequest $request
     * @return JsonResponse
     */
    public function store(SchedulingRequest $request)
    {
        try{
            $payload = $request->all();

            SchedulingValidation::isValidateAtributes($payload);

            /** @var Scheduling $scheduling */
            $scheduling = new Scheduling();

            $payload['dt_scheduling'] = \DateTime::createFromFormat('d/m/Y', $payload['dt_scheduling']);
            
            SchedulingValidation::isAlreadyScheduled($payload);
            SchedulingValidation::isDateAlreadyHasAnotherScheduled($payload);

            $scheduling->setAttribute('dt_scheduling', $payload['dt_scheduling']);
            
            $cliente = Cliente::select('*')->where('id', $payload['id_cliente'])->get()->last();
            ClienteValidation::isExist($cliente, $payload['id_cliente']);
            $scheduling->setAttribute('id_cliente', $cliente->id);

            $service = Services::select('*')->where('id', $payload['id_services'])->get()->last();
            ServicesValidation::isExist($service, $payload['id_services']);
            $scheduling->setAttribute('id_services', $service->id);

            $scheduling->save();
            $scheduling->refresh();
            $response['scheduling'] = $scheduling;
            $response['cliente'] = $cliente;
            $response['services'] = $service;
            
            return $this->success($response,'save success',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try{
            $scheduling = Scheduling::select('*')->where('id',$id)->get()->last();
            SchedulingValidation::isListEmpty($scheduling);
            SchedulingValidation::isDisabled($scheduling);
            $response[0]['services'] = $scheduling;
            return $this->success($response,'show success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param ServicesUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try{
            $payload = $request->all();       
            SchedulingValidation::isValidateAtributes($payload,$id);

            /** @var Services $scheduling */
            $scheduling = Scheduling::select('*')->where('id', $id)->get()->last();

            SchedulingValidation::isEnabled($scheduling);

            $dt_birthday = \DateTime::createFromFormat('d/m/Y', $payload['dt_scheduling']);
            $scheduling->setAttribute('dt_scheduling', $dt_birthday);
            
            $cliente = Cliente::select('*')->where('id', $payload['id_cliente'])->get()->last();
            ClienteValidation::isExist($cliente, $payload['id_cliente']);
            $scheduling->setAttribute('id_cliente', $cliente->id);

            $service = Services::select('*')->where('id', $payload['id_services'])->get()->last();
            ServicesValidation::isExist($service, $payload['id_services']);
            $scheduling->setAttribute('id_services', $service->id);
            
            $scheduling->save();
            $scheduling->refresh();
            $response['scheduling'] = $scheduling;
            $response['cliente'] = $cliente;
            $response['services'] = $service;
            
            return $this->success($response,'save success',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function disable($id)
    {

        try{
            /** @var Services $scheduling */
            $scheduling = Scheduling::where('id', $id)->get()->last();

            SchedulingValidation::isExist($scheduling, $id);
            SchedulingValidation::isDisabled($scheduling);

            $scheduling->setAttribute('status',Scheduling::STATUS_DISABLED);
            $scheduling->update();

            return $this->success($scheduling,'disable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function enable($id)
    {
        try{
            /** @var Services $scheduling */
            $scheduling = Scheduling::where('id', $id)->get()->last();

            SchedulingValidation::isEnabled($scheduling);

            $scheduling->setAttribute('status',Scheduling::STATUS_ENABLED);
            $scheduling->update();

            return $this->success($scheduling,'enable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

}

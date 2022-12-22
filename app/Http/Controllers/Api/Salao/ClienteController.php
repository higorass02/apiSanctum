<?php

namespace App\Http\Controllers\Api\Salao;

use App\Exceptions\Validations\Salao\Cliente\ClienteValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClienteRequest;
use App\Models\Salao\Cliente;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $cliente = Cliente::select('*')->where('status',Cliente::STATUS_ENABLED)->get();
            $response['cliente'] = $cliente;
            return $this->success($response,'load success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }


    /**
     * @param ClienteRequest $request
     * @return JsonResponse
     */
    public function store(ClienteRequest $request)
    {
        try{
            $payload = $request->all();

            ClienteValidation::isValidateAtributes($payload);

            /** @var Cliente $cliente */
            $cliente = new Cliente();

            $cliente->setAttribute('name',$payload['name']);
            $cliente->setAttribute('number',$payload['number']);
            if(!empty($payload['email'])){
                $cliente->setAttribute('email',$payload['email']);
            }
            if(!empty($payload['dt_birthday'])){
                $dt_birthday = \DateTime::createFromFormat('d/m/Y', $payload['dt_birthday']);
                $cliente->setAttribute('dt_birthday',$dt_birthday);
            }
            $cliente->save();

            return $this->success($cliente,'save success',200);
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
            $cliente = Cliente::select('*')->where('id',$id)->get()->last();
            ClienteValidation::isListEmpty($cliente);
            $response[0]['cliente'] = $cliente;
            return $this->success($response,'show success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try{
            $payload = $request->all();       
            ClienteValidation::isValidateAtributes($payload,$id);

            /** @var Cliente $cliente */
            $cliente = Cliente::select('*')->where('id', $id)->get()->last();

            ClienteValidation::isEnabled($cliente);

            $cliente->setAttribute('name',$payload['name']);
            $cliente->setAttribute('number',$payload['number']);
            if(!empty($payload['email'])){
                $cliente->setAttribute('email',$payload['email']);
            }
            if(!empty($payload['dt_birthday'])){
                $dt_birthday = \DateTime::createFromFormat('d/m/Y', $payload['dt_birthday']);
                $cliente->setAttribute('dt_birthday',$dt_birthday);
            }
            ClienteValidation::isDirty($cliente);
            $cliente->update();

            return $this->success($cliente,'update success!',200);
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
            /** @var Cliente $cliente */
            $cliente = Cliente::where('id', $id)->get()->last();

            // ClienteValidation::isExist($cliente, $id);
            // ClienteValidation::isEnabled($cliente);

            $cliente->setAttribute('status',Cliente::STATUS_DISABLED);
            $cliente->update();

            return $this->success($cliente,'disable success!',200);
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
            /** @var Cliente $cliente */
            $cliente = Cliente::where('id', $id)->get()->last();

            // ClienteValidation::isDisabled($cliente);

            $cliente->setAttribute('status',Cliente::STATUS_ENABLED);
            $cliente->update();

            return $this->success($cliente,'enable success!',200);
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
    public function cLienteSuggestion($keySuggestion, $valueSuggestion)
    {
        try{
            /** @var Cliente $cliente */
            $cliente = Cliente::where($keySuggestion, $valueSuggestion)->get();
            ClienteValidation::isDisabled($cliente);

            $response['cliente'] = $cliente;
            return $this->success($response,'enable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }
}

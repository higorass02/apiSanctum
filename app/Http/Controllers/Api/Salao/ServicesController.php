<?php

namespace App\Http\Controllers\Api\Salao;

use App\Exceptions\Validations\Salao\Services\ServicesValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServicesRequest;
use App\Models\Salao\Services;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $services = Services::select('*')->where('status',Services::STATUS_ENABLED)->get();
            $response['services'] = $services;
            return $this->success($response,'load success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }


    /**
     * @param ServicesRequest $request
     * @return JsonResponse
     */
    public function store(ServicesRequest $request)
    {
        try{
            $payload = $request->all();

            ServicesValidation::isValidateAtributes($payload);

            /** @var Services $services */
            $services = new Services();

            $services->setAttribute('name',$payload['name']);
            if(!empty($payload['type'])){
                $services->setAttribute('type',$payload['type']);
            }
            if(!empty($payload['desc'])){
                $services->setAttribute('desc',$payload['desc']);
            }
            $services->save();

            return $this->success($services,'save success',200);
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
            $services = Services::select('*')->where('id',$id)->get()->last();
            ServicesValidation::isListEmpty($services);
            $response[0]['services'] = $services;
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
            ServicesValidation::isValidateAtributes($payload,$id);

            /** @var Services $services */
            $services = Services::select('*')->where('id', $id)->get()->last();

            ServicesValidation::isEnabled($services);

            $services->setAttribute('name',$payload['name']);
            if(!empty($payload['type'])){
                $services->setAttribute('type',$payload['type']);
            }
            if(!empty($payload['desc'])){
                $services->setAttribute('desc',$payload['desc']);
            }
            $services->save();

            return $this->success($services,'update success!',200);
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
            /** @var Services $services */
            $services = Services::where('id', $id)->get()->last();

            ServicesValidation::isExist($services, $id);
            ServicesValidation::isEnabled($services);

            $services->setAttribute('status',Services::STATUS_DISABLED);
            $services->update();

            return $this->success($services,'disable success!',200);
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
            /** @var Services $services */
            $services = Services::where('id', $id)->get()->last();

            ServicesValidation::isEnabled($services);

            $services->setAttribute('status',Services::STATUS_ENABLED);
            $services->update();

            return $this->success($services,'enable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validations\ProductsSales\ProductsSalesValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsSalesRequest;
use App\Models\Store\Products;
use App\Models\Store\ProductsSales;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsSalesController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $ProductsSales = ProductsSales::select('*')->get();

            ProductsSalesValidation::isListEmpty($ProductsSales);

            $response = [];
            foreach ($ProductsSales as $key=>$productStock){
                $product = Products::select('*')->where('id',$productStock->product_sale)->where('status',Products::STATUS_ENABLED)->get()->last();
                if($product){
                    $response[$key]['ProductsSales'] = $productStock;
                    $response[$key]['product'] = $product;
                }
            }

            return $this->success($response,'load success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),500);
        }
    }


    /**
     * @param ProductsSalesRequest $request
     * @return JsonResponse
     */
    public function store(ProductsSalesRequest $request)
    {
        try{
            $payload = $request->all();

            ProductsSalesValidation::isValidateAtributes($payload);

            /** @var ProductsSales $ProductsSales */
            $ProductsSales = new ProductsSales();
            $ProductsSales->setAttribute('qtd',$payload['qtd']);
            $ProductsSales->setAttribute('status',ProductsSales::STATUS_ENABLED);
            $ProductsSales->setAttribute('product_sale',$payload['product_sale']);

            if(!empty($payload['dt_expired'])){
                $ProductsSales->setAttribute('dt_expired',Carbon::createFromFormat('d/m/Y',$payload['dt_expired'])->setTime(23,59,59));
            }

            $ProductsSales->save();

            return $this->success($ProductsSales,'save success',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try{
            /** @var ProductsSales $ProductsSales */
            $ProductsSales = ProductsSales::where('id', $id)->get()->last();

            $response = [];
            if($ProductsSales){
                $product = Products::select('*')->where('id',$ProductsSales->product_sale)->get()->last();
                if($product){
                    $response[0]['ProductsSales'] = $ProductsSales;
                    $response[0]['product'] = $product;
                }
            }
            return $this->success($response,'show success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),500);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $payload = $request->all();

            ProductsSalesValidation::isValidateAtributes($payload,$id);

            /** @var ProductsSales $ProductsSales */
            $ProductsSales = ProductsSales::select('*')->where('id', $id)->get()->last();

            if(!empty($payload['qtd'])){
                $ProductsSales->setAttribute('qtd',$payload['qtd']);
            }
            if(!empty($payload['dt_expired'])){
                $ProductsSales->setAttribute('dt_expired',Carbon::createFromFormat('d/m/Y',$payload['dt_expired'])->setTime(23,59,59));
            }
            if(!empty($payload['product_sale'])){
                $ProductsSales->setAttribute('product_sale',$payload['product_sale']);
            }
            ProductsSalesValidation::isDirty($ProductsSales);

            $ProductsSales->update();

            return $this->success($ProductsSales,'update success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try{
            /** @var ProductsSales $ProductsSales */
            $ProductsSales = ProductsSales::where('id', $id)->get()->last();
            $ProductsSales->delete();

            return $this->success($ProductsSales,'disable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),500);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function showSaleForProduct($id)
    {
        try{
            /** @var Products $products */
            $product = Products::where('id', $id)->get()->last();

            $response = [];
            if($product){
                /** @var ProductsSales $ProductsSales */
                $ProductsSales = ProductsSales::where('product_sale', $product->id)->get();

                if($ProductsSales){
                    $response[0]['ProductsSales'] = $ProductsSales;
                    $response[0]['product'] = $product;
                }
            }
            return $this->success($response,'show success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),500);
        }
    }

}

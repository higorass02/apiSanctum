<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validations\ProductsStock\ProductsStockValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsStockRequest;
use App\Models\Categories;
use App\Models\Products;
use App\Models\ProductsStock;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class ProductsStockController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $productsStock = ProductsStock::select('*')->get();

            ProductsStockValidation::isListEmpty($productsStock);

            $response = [];
            foreach ($productsStock as $key=>$productStock){
                $product = Products::select('*')->where('id',$productStock->product_stock)->where('status',Products::STATUS_ENABLED)->get()->last();
                if($product){
                    $response[$key]['productsStock'] = $productStock;
                    $response[$key]['product'] = $product;
                }
            }

            return $this->success($response,'load success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }


    /**
     * @param ProductsStockRequest $request
     * @return JsonResponse
     */
    public function store(ProductsStockRequest $request)
    {
        try{
            $payload = $request->all();

            ProductsStockValidation::isValidateAtributes($payload);

            /** @var ProductsStock $productsStock */
            $productsStock = new ProductsStock();
            $productsStock->setAttribute('quantity',$payload['quantity']);
            $productsStock->setAttribute('product_stock',$payload['product_stock']);
            $productsStock->save();

            return $this->success($productsStock,'save success',200);
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
            /** @var ProductsStock $productsStock */
            $productsStock = ProductsStock::where('id', $id)->get()->last();

            $response = [];
            if($productsStock){
                $product = Products::select('*')->where('id',$productsStock->product_stock)->get()->last();
                if($product){
                    $response[0]['productsStock'] = $productsStock;
                    $response[0]['product'] = $product;
                }
            }
            return $this->success($response,'show success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    public function update(ProductsStockRequest $request, $id)
    {
        try{
            $payload = $request->all();

            ProductsStockValidation::isValidateAtributes($payload,$id);

            /** @var ProductsStock $productsStock */
            $productsStock = ProductsStock::select('*')->where('id', $id)->get()->last();
            $productsStock->setAttribute('quantity',$payload['quantity']);
            $productsStock->setAttribute('product_stock',$payload['product_stock']);
            $productsStock->update();

            return $this->success($productsStock,'update success!',200);
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
    public function delete($id)
    {
        try{
            /** @var ProductsStock $productsStock */
            $productsStock = ProductsStock::where('id', $id)->get()->last();
            $productsStock->delete();

            return $this->success($productsStock,'disable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

}

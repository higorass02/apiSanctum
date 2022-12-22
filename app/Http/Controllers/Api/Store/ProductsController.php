<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validations\Products\ProductsValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Models\Store\Categories;
use App\Models\Store\Products;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $products = Products::select('*')->where('status',Products::STATUS_ENABLED)->get();
            ProductsValidation::isListEmpty($products);
            $response = [];
            foreach ($products as $key=>$product){
                $category = Categories::select('title','description','created_at','updated_at')->where('id',$product->category_product)->where('status',Categories::STATUS_ENABLED)->get()->last();
                if($category){
                    $response[$key]['product'] = $product;
                    $response[$key]['category'] = $category;
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
     * @param ProductsRequest $request
     * @return JsonResponse
     */
    public function store(ProductsRequest $request)
    {
        try{
            $payload = $request->all();

            ProductsValidation::isValidateAtributes($payload);

            /** @var Products $product */
            $product = new Products();

            $product->setAttribute('title',$payload['title']);
            $product->setAttribute('description',$payload['description']);
            $product->setAttribute('type_capacity',$payload['type_capacity']);
            $product->setAttribute('value_capacity',$payload['value_capacity']);
            $product->setAttribute('price',$payload['price']);
            $product->setAttribute('star',$payload['star']);
            $product->setAttribute('category_product',$payload['category_product']);

            if(!empty($payload['branch'])){
                $product->setAttribute('branch',$payload['branch']);
            }
            if(!empty($payload['model'])){
                $product->setAttribute('model',$payload['model']);
            }
            if(!empty($payload['validity'])){
                $product->setAttribute('validity',Carbon::createFromFormat('d/m/Y',$payload['validity'])->setTime(23,59,59));
            }

            $product->save();

            return $this->success($product,'save success',200);
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
            $products = Products::select('*')->where('id',$id)->get()->last();
            ProductsValidation::isListEmpty($products);

            $response = [];
            if($products){
                $category = Categories::select('title','description','created_at','updated_at')->where('id',$products->category_product)->where('status',Categories::STATUS_ENABLED)->get()->last();
                if($category){
                    $response[0]['product'] = $products;
                    $response[0]['category'] = $category;
                }
            }

            return $this->success($response,'show success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param ProductsRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try{
            $payload = $request->all();

            ProductsValidation::isValidateAtributes($payload,$id);

            /** @var Products $product */
            $product = Products::select('*')->where('id', $id)->get()->last();

            ProductsValidation::isEnabled($product);

            $product->setAttribute('title',$payload['title']);
            $product->setAttribute('description',$payload['description']);
            $product->setAttribute('type_capacity',$payload['type_capacity']);
            $product->setAttribute('value_capacity',$payload['value_capacity']);
            $product->setAttribute('price',$payload['price']);
            $product->setAttribute('star',$payload['star']);
            $product->setAttribute('category_product',$payload['category_product']);

            if($payload['branch']){
                $product->setAttribute('branch',$payload['branch']);
            }
            if($payload['model']){
                $product->setAttribute('model',$payload['model']);
            }
            if($payload['validity']){
                $product->setAttribute('validity',Carbon::createFromFormat('d/m/Y',$payload['validity'])->setTime(23,59,59));
            }
            ProductsValidation::isDirty($product);
            $product->update();

            return $this->success($product,'update success!',200);
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
            /** @var Products $product */
            $product = Products::where('id', $id)->get()->last();

            ProductsValidation::isExist($product, $id);
            ProductsValidation::isEnabled($product);

            $product->setAttribute('status',Products::STATUS_DISABLED);
            $product->update();

            return $this->success($product,'disable success!',200);
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
            /** @var Products $product */
            $product = Products::where('id', $id)->get()->last();

            ProductsValidation::isDisabled($product);

            $product->setAttribute('status',Products::STATUS_ENABLED);
            $product->update();

            return $this->success($product,'enable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }
}

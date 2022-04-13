<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validations\Products\ProductsValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Models\Categories;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $products = Product::select('*')->where('status',Product::STATUS_ENABLED)->get();

            ProductsValidation::isListEmpty($products);

            return $this->success($products,'load success!',200);
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

            /** @var Product $product */
            $product = new Product();
            $product->setAttribute('title',$payload['title']);
            $product->setAttribute('description',$payload['description']);
            if($payload['branch']){
                $product->setAttribute('branch',$payload['branch']);
            }
            if($payload['model']){
                $product->setAttribute('model',$payload['model']);
            }
            if($payload['validity']){
                $product->setAttribute('validity',$payload['validity']);
            }
            $product->setAttribute('type_capacity',$payload['type_capacity']);
            $product->setAttribute('value_capacity',$payload['value_capacity']);
            $product->setAttribute('price',$payload['price']);
            $product->setAttribute('star',$payload['star']);
            $product->setAttribute('status',Product::STATUS_ENABLED);
            $product->setAttribute('category_product',$payload['category_product']);
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
            /** @var Categories $category */
            $category = Categories::where('id', $id)->where('status',true)->get()->last();

            ProductsValidation::isEnabled($category);


            return $this->success($category,'show success!',200);
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
    public function update(ProductsRequest $request, $id)
    {
        try{
            $payload = $request->all();

            ProductsValidation::isValidateAtributes($payload,$id);

            /** @var Product $product */
            $product = Product::select('*')->where('id', $id)->get()->last();

            ProductsValidation::isEnabled($product);

            $product->setAttribute('title',$payload['title']);
            $product->setAttribute('description',$payload['description']);
            if($payload['branch']){
                $product->setAttribute('branch',$payload['branch']);
            }
            if($payload['model']){
                $product->setAttribute('model',$payload['model']);
            }
            if($payload['validity']){
                $product->setAttribute('validity',$payload['validity']);
            }
            $product->setAttribute('type_capacity',$payload['type_capacity']);
            $product->setAttribute('value_capacity',$payload['value_capacity']);
            $product->setAttribute('price',$payload['price']);
            $product->setAttribute('star',$payload['star']);
            $product->setAttribute('category_product',$payload['category_product']);
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
            /** @var Product $product */
            $product = Product::where('id', $id)->get()->last();

            ProductsValidation::isExist($product, $id);
            ProductsValidation::isEnabled($product);

            $product->setAttribute('status',Product::STATUS_DISABLED);
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
            /** @var Product $product */
            $product = Product::where('id', $id)->get()->last();

            ProductsValidation::isDisabled($product);

            $product->setAttribute('status',Product::STATUS_ENABLED);
            $product->update();

            return $this->success($product,'enable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validations\Products\ProductsValidation;
use App\Exceptions\Validations\ProductsPhoto\ProductsPhotoValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsPhotoRequest;
use App\Models\Store\Products;
use App\Models\Store\ProductsPhotos;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsPhotoController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $productsPhotos = ProductsPhotos::select('*')->get();

            ProductsPhotoValidation::isListEmpty($productsPhotos);

            $response = [];
            foreach ($productsPhotos as $key=>$productPhoto){
                $product = Products::select('*')->where('id',$productPhoto->product_photo)->where('status',Products::STATUS_ENABLED)->get()->last();
                if($product){
                    $response[$key]['productsPhoto'] = $productPhoto;
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
     * @param ProductsPhotoRequest $request
     * @return JsonResponse
     */
    public function store(ProductsPhotoRequest $request)
    {
        try{
            $payload = $request->all();

            ProductsPhotoValidation::isValidateAtributes($payload);

            /** @var ProductsPhotos $productsPhoto */
            $productsPhoto = new ProductsPhotos();
            $productsPhoto->setAttribute('URL',$payload['URL']);
            $productsPhoto->setAttribute('path',$payload['path']);
            $productsPhoto->setAttribute('local',$payload['local']);
            $productsPhoto->setAttribute('status',ProductsPhotos::STATUS_ENABLED);
            $productsPhoto->setAttribute('product_photo',$payload['product_photo']);
            $productsPhoto->save();

            return $this->success($productsPhoto,'save success',200);
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
            /** @var ProductsPhotos $productsPhoto */
            $productsPhoto = ProductsPhotos::where('id', $id)->get()->last();

            ProductsPhotoValidation::isExist($productsPhoto,$id);
            ProductsPhotoValidation::isEnabled($productsPhoto);

            $response = [];
            if($productsPhoto){
                $product = Products::select('*')->where('id',$productsPhoto->product_photo)->get()->last();

                ProductsValidation::isExist($product,$productsPhoto->product_photo);

                if($product){
                    $response[0]['productsPhoto'] = $productsPhoto;
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

    public function update(Request $request, $id)
    {
        try{
            $payload = $request->all();

            ProductsPhotoValidation::isValidateAtributes($payload,$id);

            /** @var ProductsPhotos $productsPhoto */
            $productsPhoto = ProductsPhotos::select('*')->where('id', $id)->get()->last();

            ProductsPhotoValidation::isExist($productsPhoto,$id);
            ProductsPhotoValidation::isEnabled($productsPhoto);

            $productsPhoto->setAttribute('URL',$payload['URL']);
            $productsPhoto->setAttribute('path',$payload['path']);
            $productsPhoto->setAttribute('local',$payload['local']);
            $productsPhoto->setAttribute('product_photo',$payload['product_photo']);
            $productsPhoto->update();

            return $this->success($productsPhoto,'update success!',200);
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
            /** @var ProductsPhotos $productsPhoto */
            $productsPhoto = ProductsPhotos::where('id', $id)->get()->last();
            $productsPhoto->delete();

            return $this->success($productsPhoto,'disable success!',200);
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
    public function showPhotoForProduct($id)
    {
        try{
            /** @var Products $products */
            $product = Products::where('id', $id)->get()->last();

            $response = [];
            if($product){
                /** @var ProductsPhotos $productsPhoto */
                $productsPhoto = ProductsPhotos::where('product_photo', $product->id)->get();

                if($productsPhoto){
                    $response[0]['productsPhoto'] = $productsPhoto;
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

}

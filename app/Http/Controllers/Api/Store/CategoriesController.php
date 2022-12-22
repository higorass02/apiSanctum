<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Validations\Categories\CategoriesValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Store\Categories;
use App\Traits\ApiResponser;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use ApiResponser;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        try{
            $categories = Categories::select('*')->where('status',true)->get();

            CategoriesValidation::isListEmpty($categories);

            return $this->success($categories,'load success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }

    /**
     * @param CategoriesRequest $request
     * @return JsonResponse
     */
    public function store(CategoriesRequest $request)
    {
        try{
            $payload = $request->all();

            /** @var Categories $category */
            $category = new Categories();
            $category->setAttribute('title',$payload['title']);
            $category->setAttribute('description',$payload['description']);
            $category->setAttribute('spotlight',$payload['spotlight']);
            $category->setAttribute('status',true);
            $category->save();

            return $this->success($category,'save success',200);
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

            CategoriesValidation::isEnabled($category);

            return $this->success($category,'show success!',200);
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

            /** @var Categories $category */
            $category = Categories::select('id','title','description','spotlight','status')->where('id', $id)->get()->last();

            CategoriesValidation::isEnabled($category);
            if(!empty($payload['title'])){
                $category->setAttribute('title',$payload['title']);
            }
            if(!empty($payload['description'])){
                $category->setAttribute('description',$payload['description']);
            }
            if(!empty($payload['spotlight'])){
                $category->setAttribute('spotlight',$payload['spotlight']);
            }
            CategoriesValidation::isDirty($category);
            $category->update();

            return $this->success($category,'update success!',200);
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
            /** @var Categories $category */
            $category = Categories::where('id', $id)->get()->last();


            CategoriesValidation::isExist($category, $id);
            CategoriesValidation::isEnabled($category);

            $category->setAttribute('status',Categories::STATUS_DISABLED);
            $category->update();

            return $this->success($category,'disable success!',200);
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
            /** @var Categories $category */
            $category = Categories::where('id', $id)->get()->last();

            CategoriesValidation::isDisabled($category);

            $category->setAttribute('status',Categories::STATUS_ENABLED);
            $category->update();

            return $this->success($category,'enable success!',200);
        }catch (\InvalidArgumentException $e){
            return $this->error($e->getMessage(),404);
        }catch (\Exception $e){
            return $this->error($e->getMessage(),404);
        }
    }
}

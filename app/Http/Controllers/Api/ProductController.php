<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @package App\Http\Controllers\Api
 */
class ProductController extends BaseController
{

    /**
     * @var ProductRepository
     */
    private  ProductRepository $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get current user's Product
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|object
     */
    public function getItem(int $id){

        return $this->response( new ProductResource(
            $this->productRepository->getEntityById($id, Auth::id()))
        )
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Get all current user's Products
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|object
     */
    public function  getAllItems()
    {

        $products = $this->productRepository->getAllEntities(Auth::id());

        return $this->response( ProductResource::collection($products))
            ->setStatusCode(Response::HTTP_OK);

    }

    /**
     * Create Product resource in storage
     * @param CreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function store(CreateRequest $request)
    {
        $product = $this->productRepository->createEntity(
            $request->name,
            $request->description,
            $request->image,
            Auth::id(),
            [1,2,3]

        );

        return $this->response(
            new ProductResource($product)
        )->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update Product resource in storage
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response|object
     */
    public function update(UpdateRequest $request,int $id)
    {

        $product = $this->productRepository->updateEntity(
            $request->name,
            $request->description,
            $request->image,
            $id,
            Auth::id()
        );

        return $this->response(
            new ProductResource($product)
        )->setStatusCode(Response::HTTP_OK);

    }

    /**
     * Destroy Product resource from storage
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response|object
     */
    public function destroy(int $id)
    {

        return $this->response(new MessageResource(
            $this->productRepository->deleteEntity($id, Auth::id())
        ))->setStatusCode(Response::HTTP_NO_CONTENT);

    }
}

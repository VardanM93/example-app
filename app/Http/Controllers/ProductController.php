<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ProductController extends Controller
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


    public function  showAll(){

        $products = $this->productRepository->showAllEntity();


        dd($products);
        return response()->json(
            new ProductResource($products),
            ResponseAlias::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     * @param ProductFormRequest $request
     * @return void
     */
    public function store(ProductFormRequest $request):JsonResponse
    {
        $product = $this->productRepository->createEntity(
            $request->name,
            $request->description,
            $request->image
        );


        return response()->json(
            new ProductResource($product),
            ResponseAlias::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage
     * @param ProductFormRequest $request
     * @param int $id
     * @return JsonResponse
     */


    public function update(ProductFormRequest $request,int $id): JsonResponse
    {
        $product = $this->productRepository->updateEntity(
            $request->name,
            $request->description,
            $request->image,
            $id
        );


        return response()->json(
            new ProductResource($product),
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */

    public function destroy(int $id): JsonResponse
    {
        return response()->json(
            $this->productRepository->deleteEntity($id),
            ResponseAlias::HTTP_OK
        );
    }
}

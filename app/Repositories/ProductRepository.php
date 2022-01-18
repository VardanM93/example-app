<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;


class ProductRepository
{
    /**
     * @param string $name
     * @param string $description
     * @param string $image
     * @return Product
     */
    public function createEntity(string $name, string $description, string $image):Product
    {
        return Product::create([

            'user_id' => auth()->id(),
            'name' => $name,
            'description' => $description,
            'image' => $image
        ]);
    }

    public function showAllEntity()
    {
        return User::find(auth()->id())->products;
    }



    /**
     * @param string $name
     * @param string $description
     * @param string $image
     * @param int $id
     * @return Product
     */
    public function updateEntity(string $name, string $description, string $image,int $id):Product
    {

        $product = Product::find($id);

        $product->name = $name;
        $product->description = $description;
        $product->image = $image;
        $product->save();

        return $product;

    }


    public function deleteEntity(int $id): int
    {

        return Product::destroy($id);

    }
}

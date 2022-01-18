<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class ProductRepository
{

    const IMAGE_PATH = "images/products/";

    /**
     * @param string $name
     * @param string $description
     * @param object $image
     * @return Product
     */
    public function createEntity(string $name, string $description, object $image):Product
    {


        return Product::create([

            'user_id' => auth()->id(),
            'name' => $name,
            'description' => $description,
            'image' => $this->createImageEntity($image)
        ]);
    }

    /**
     * @return mixed
     */
    public function showAllEntity()
    {

        return User::find(auth()->id())->products;
    }


    /**
     * @param string $name
     * @param string $description
     * @param object $image
     * @param int $id
     * @return Product
     */
    public function updateEntity(string $name, string $description, object $image,int $id):Product
    {

        $product = Product::find($id);


        $product->name = $name;
        $product->description = $description;
        $product->image = $this->updateImageEntity($product->image, $image);
        $product->save();

        return $product;

    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteEntity(int $id): int
    {

        $product = Product::find($id);
        $image = $product->image;


        if ($result = $product->destroy($id))
        {
            if (Storage::exists(Storage::url(self::IMAGE_PATH).$image)){

                Storage::delete(Storage::url(self::IMAGE_PATH).$image);
            }
        }

        return $result;

    }

    /**
     * @param $image
     * @return string|null
     */
    public function createImageEntity($image): ?string
    {



        if ($image){

            $fileName = $image->hashName();

            Storage::put(Storage::url(self::IMAGE_PATH),$image);

            return $fileName;
        }


       return Null;
    }


    /**
     * @param $old
     * @param $new
     * @return string|null
     */
    public function updateImageEntity($old,$new): ?string
    {



        if(Storage::exists(Storage::url(self::IMAGE_PATH).$old))
        {
            Storage::delete(Storage::url(self::IMAGE_PATH).$old);
        };

        return $this->createImageEntity($new);
    }

}

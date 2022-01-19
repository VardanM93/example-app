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
            'image' => $this->saveImage($image)
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
        $product->image = $this->updateImage($product->image, $image);
        $product->save();

        return $product;

    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteEntity(int $id): int
    {

        if ($product = Product::find($id))
        {
            $this->deleteImage($product->image);
        }

        return $product->destroy($id);

    }

    /**
     * @param $image
     * @return string|null
     */
    public function saveImage($image): ?string
    {

        $fileName = $image->hashName();

        Storage::put(Storage::url(self::IMAGE_PATH),$image);

        return $fileName;

    }

    /**
     * @param $old
     * @param $new
     * @return string|null
     */
    public function updateImage($old,$new): ?string
    {

        if (!is_null($new)){

            $this->deleteImage($old);

            return  $this->saveImage($new);
        }

        return $old;

    }


    public function deleteImage($path): bool
    {

       return Storage::delete(Storage::url(self::IMAGE_PATH) . $path);

    }

}

<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class ProductRepository
{
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

        return Product::destroy($id);

    }

    /**
     * @param $image
     * @return string|null
     */
    public function createImageEntity($image): ?string
    {
        if ($image){

            $file = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $path = 'images/products' . '/' . $file;


            Storage::disk('local')->put($path,$file,'public');

            return $file;
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


        if(Storage::disk('local')->exists('images/products'.'/'. $old))
        {
            Storage::disk('local')->delete('images/products' . '/' .$old);
        };

        return $this->createImageEntity($new);
    }

}

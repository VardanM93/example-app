<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductRepository
 * @package App\Repositories
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $name
 * @property-read string $description
 * @property-read string $image
 */
class ProductRepository
{
    /**
     * Get Product by id and user_id
     * @param int $id
     * @param int $user_id
     * @return Product
     */
    public function getEntityById(int $id, int $user_id): Product
    {
        return Product::where('id',$id)
                        ->where('user_id',$user_id)->firstOrFail();

    }

    /**
     * Create Product in storage
     * @param string $name
     * @param string $description
     * @param object $image
     * @param int $user_id
     * @return Product
     */
    public function createEntity(string $name, string $description, object $image, int $user_id, array $tags):Product
    {
        $product =  Product::create([

            'user_id' => $user_id,
            'name' => $name,
            'description' => $description,
            'image' => $this->saveImage($image)
        ]);

        $product->tags()->attach($tags);

        return $product;

    }

    /**
     * Get all current user's Products
     * @param int $user_id
     * @return object
     */
    public function getAllEntities(int $user_id): object
    {


        return    Product::where('user_id',$user_id)->get();


    }

    /**
     * Update Product in storage
     * @param string|null $name
     * @param string|null $description
     * @param object|null $image
     * @param int $id
     * @param int $user_id
     * @return Product
     */
    public function updateEntity(string $name, string $description, ?object  $image, int $id, int $user_id, array $tags):Product
    {

        $product = $this->getEntityById($id, $user_id);

        if (!is_null($image))
        {
            $product->image = $this->updateImage($product->image, $image);

        }

        $product->name = $name;
        $product->description = $description;

        $product->update();



        return $product;

    }

    /**
     * Remove Product from storage
     * @param int $id
     * @param int $user_id
     * @return null
     */
    public function deleteEntity(int $id, int $user_id)
    {

        $product = $this->getEntityById($id, $user_id);

        $this->deleteImage($product->image);
        $product->destroy($id);

        return   null;

    }

    /**
     * Store image in storage
     * @param $image
     * @return string|null
     */
    public function saveImage($image): ?string
    {

        $fileName = $image->hashName();
        $image->storeAs(Product::PRODUCT_IMAGE_PATH . "/",$fileName);

        return $fileName;

    }

    /**
     * Update image in storage and remove old
     * @param $old
     * @param $new
     * @return string|null
     */
    public function updateImage($old,$new): ?string
    {
        $this->deleteImage($old);
        return  $this->saveImage($new);
    }

    /**
     * Remove image from storage
     * @param $path
     * @return bool
     */
    public function deleteImage($path): bool
    {
       return Storage::delete((Product::PRODUCT_IMAGE_PATH) . "/" . $path);
    }

}

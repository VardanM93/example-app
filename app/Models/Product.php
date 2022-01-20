<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product Model
 * @package App\Models
 * @property string $description
 * @property string|null $image
 * @property string $name
 * @method static where(string $string, int|null $id)
 * @method static find($id)
 * @method static create(array $array)
 */
class Product extends Model
{
    use HasFactory;

    const IMAGE_PATH = "products/";

    /**
     * @var string[]
     */
    protected $fillable = [

        'user_id',
        'name',
        'description',
        'image'

    ];



}

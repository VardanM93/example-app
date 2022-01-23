<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    const PRODUCT_IMAGE_PATH = "products";


    /**
     * @var string[]
     */
    protected $fillable = [

        'user_id',
        'name',
        'description',
        'image'

    ];

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany();
    }

}

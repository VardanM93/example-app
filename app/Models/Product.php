<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, int|null $id)
 * @method static find($id)
 */
class Product extends Model
{
    use HasFactory;




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

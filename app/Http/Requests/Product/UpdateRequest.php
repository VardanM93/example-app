<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRequest
 * @property string $name
 * @property string $description
 * @property object $image
 * @package App\Http\Requests\Product
 */
class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return
            [
                'name' => 'string',
                'description' => 'string',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];
    }
}

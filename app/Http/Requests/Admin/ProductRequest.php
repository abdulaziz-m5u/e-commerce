<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => ['required', 'max:255'],
                    'price' => ['required', 'numeric'],
                    'quantity' => ['required', 'numeric'],
                    'category_id' => ['required'],
                    'tags' => ['required'],
                    'featured' => ['required'],
                    'status' => ['required'],
                    'description' => ['required', 'max:1000'],
                    'details' => ['required', 'max:10000']
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => ['required', 'max:255'],
                    'description' => ['required', 'max:1000'],
                    'price' => ['required', 'numeric'],
                    'quantity' => ['required', 'numeric'],
                    'tags' => ['required'],
                    'category_id' => ['required'],
                    'featured' => ['required'],
                    'details' => ['required', 'max:10000'],
                    'status' => ['required'],
                ];
            }
            default: break;
        }
    }
}

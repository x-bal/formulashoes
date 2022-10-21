<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_product' => 'required|string|unique:products,nama_product,' . $this->product->id,
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'mimes:jpg,jpeg,png'
        ];
    }
}

<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CategoryProductRequest extends FormRequest
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
        return [
            'name'  => "required|unique:adm_product_categories,name,{$this->kategori_produk},id_category"
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama harus diisi',
            'name.unique'       => 'Kategori sudah terdaftar'
        ];
    }
}

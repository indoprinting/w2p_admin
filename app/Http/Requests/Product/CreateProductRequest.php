<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name'      => 'required',
            'berat'     => 'required',
            'min_order'     => 'required',
            'img_product'   => 'required',
            'img_product2'  => 'required',
            'size_price.*'  => 'required',
            'size_name.*'   => 'required',
            'material_name.*'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Nama produk harus diisi',
            'berat.required'        => 'Berat produk harus diisi',
            'min_order.required'    => 'Minimal order harus diisi',
            'img_product.required'  => 'Thumbnail produk harus diisi',
            'img_product2.required' => 'Thumbnail Tambahan harus diisi',
            'size_price.*.required' => 'Harga ukuran harus diisi (x harga bahan)',
            'size_name.*.required'  => 'Nama/jenis ukuran harus diisi',
            'material_name.*.required'    => 'Bahan tidak boleh kosong',
        ];
    }
}

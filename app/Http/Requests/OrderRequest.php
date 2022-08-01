<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'operator'  => 'required',
            'pic'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'operator.required' => 'Operator harus diisi',
            'pic.required'      => 'PIC harus diisi',
        ];
    }
}

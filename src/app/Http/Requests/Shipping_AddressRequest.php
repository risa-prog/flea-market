<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Shipping_AddressRequest extends FormRequest
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
            'post_code'=>'required',
            'post_code'=>' regex: /^[0-9]{3}[-][0-9]{4}$/',
            'address'=>'required',
            'building'=>'required',
        ];
    }

    public function messages(){
        return [
            'post_code.required'=>'郵便番号を入力してください',
            'post_code.regex'=>'郵便番号はハイフンありの8文字で入力してください',
            'address.required'=>'住所を入力してください',
            'building.required'=>'建物名を入力してください'
        ];
    }
}

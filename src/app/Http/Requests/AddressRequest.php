<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'user_name'=>'required',
            'post_code'=>'required',
            'post_code'=>' regex: /^[0-9]{3}[-][0-9]{4}$/',
            'address'=>'required',
            'building'=>'required',
            'profile_image'=>'file|mimes:jpeg,png',
            
        ];
    }

    public function messages(){
        return [
            'user_name.required'=>'お名前を入力してください',
            'post_code.required'=>'郵便番号を入力してください',
            'post_code.regex'=>'郵便番号はハイフンありの8文字で入力してください',
            'address.required'=>'住所を入力してください',
            'building.required'=>'建物名を入力してください',
            'profile_image.mimes'=>'拡張子が.jpegもしくは.pngタイプのファイルを指定してください'

        ];
    }
}

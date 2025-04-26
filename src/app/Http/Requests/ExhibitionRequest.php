<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name'=>'required',
            'item_image'=>'required|mimes:jpg,jpeg,png',
            'category_id'=>'required',
            'description'=>'required|max:255',
            'condition'=>'required',
            'price'=>'required|integer|min:1',
            
        ];
    }

    public function messages(){
        return [
            'item_name.required'=>'商品名を入力してください',
            'item_image.required'=>'画像をアップロードしてください',
            'item_image.mimes'=>'拡張子が.jpegもしくは.pngタイプのファイルを指定してください',
            'category_id.required'=>'カテゴリーを選択してください',
            'description.required'=>'商品説明を入力してください',
            'description.max'=>'商品説明は255文字以内で入力してください',
            'condition.required'=>'商品の状態を選択してください',
            'price.required'=>'販売価格を指定してください',
            'price.integer'=>'販売価格は数値で入力してください',
            'price.min'=>'販売価格は0円以上を入力してください'
        ];
    }
}

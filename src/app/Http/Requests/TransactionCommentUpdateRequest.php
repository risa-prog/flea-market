<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionCommentUpdateRequest extends FormRequest
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
            'content2' => 'array|required',
            'content2.*' => 'required|max:400',
        ];
    }

    public function messages() {
        return [
            'content2.*.required' => '本文を入力してください',
            'content2.*.max' => '本文は400文字以内で入力してください',
        ];
    }
}

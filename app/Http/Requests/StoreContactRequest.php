<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'last_name'  => 'required|string',
        'first_name' => 'required|string',
        'gender' => 'required',
        'email' => 'required|email',
        'tel1' => 'required|digits_between:2,4',
        'tel2' => 'required|digits_between:2,4',
        'tel3' => 'required|digits_between:3,4',
        'address' => 'required|string',
        'building' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'content' => 'required|string|max:120',
    ];
    }
        public function messages()
    {
        return [
        'last_name.required'  => '姓を入力してください',
        'first_name.required' => '名を入力してください',
        'gender.required' => '性別を選択してください',
        'email.required' => 'メールアドレスを入力してください',
        'email.email'    => 'メールアドレスはメール形式で入力してください',
        'tel1.required'       => '電話番号を入力してください',
        'tel2.required'       => '電話番号を入力してください',
        'tel3.required'       => '電話番号を入力してください',
        'tel1.digits_between' => '電話番号は5桁まで数字で入力してください',
        'tel2.digits_between' => '電話番号は5桁まで数字で入力してください',
        'tel3.digits_between' => '電話番号は5桁まで数字で入力してください',
        'address.required' => '住所を入力してください',
        'category_id.required' => 'お問い合わせの種類を選択してください',
        'content.required' => 'お問い合わせ内容を入力してください',
        'content.max'      => 'お問い合わせ内容は120文字以内で入力してください',
    ];
    }
}

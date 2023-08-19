<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpotRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image_path' =>  ['required'],
            'description' => ['max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'image_path.required' => '画像を選択してください',
            'description.max' => '画像の説明は255文字以内で入力してください',
        ];
    }
}

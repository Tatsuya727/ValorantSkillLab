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
            'title' =>        ['required', 'max:150'],
            'description' =>  ['required','max:255'],
            'map_id' =>       ['required', 'exists:maps,id', 'integer'],
            'character_id' => ['required', 'exists:characters,id', 'integer'],
            'is_public' =>    ['boolean'],
            'images.*.image_path' =>  ['required'],
            'images.*.description' => ['max:255'],
            'categories' =>   ['required'],
            'tags' =>         ['array', 'max:3'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.max' => 'タイトルは150文字以内で入力してください',
            'description.max' => '説明は255文字以内で入力してください',
            'description.required' => '説明は必須です',
            'map_id.required' => 'マップを選択してください',
            'map_id.exists' => 'マップが存在しません',
            'character_id.required' => 'キャラクターを選択してください',
            'character_id.exists' => 'キャラクターが存在しません',
            'images.*.image_path.required' => '画像を選択してください',
            'images.*.description.max' => '画像の説明は255文字以内で入力してください',
            'tags.max' => 'タグは最大3つまで選択できます',
        ];
    }
}

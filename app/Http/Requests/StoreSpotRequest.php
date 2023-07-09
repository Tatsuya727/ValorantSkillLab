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
            'description' =>  [ 'max:255'],
            'map_id' =>       ['required', 'exists:maps,id', 'integer'],
            'character_id' => ['required', 'exists:characters,id', 'integer'],
            'images.*.image_path' =>  ['required'],
            'images.*.description' => ['max:255'],
        ];
    }
}

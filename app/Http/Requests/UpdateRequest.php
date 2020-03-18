<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'required|max:255',
            'image' => 'nullable|max:1000|mimes:jpeg,jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vul een titel in.',
            'title.max' => 'Titel mag niet langer dan 255 tekens zijn.',
            'image.max' => 'Foto mag niet groter dan 1mb zijn.',
            'image.mimes' => 'Foto mag alleen de volgende extensies hebben: png, jpg en jpeg.'
        ];
    }
}

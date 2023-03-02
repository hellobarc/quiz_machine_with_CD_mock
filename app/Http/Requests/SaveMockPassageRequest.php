<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMockPassageRequest extends FormRequest
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
            'mock_exercise_id'   => 'required|integer',
            'title'              => 'required|string',
            'passage'            => 'required',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }
}

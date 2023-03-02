<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveManageMockRequest extends FormRequest
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
            'mock_name'           => 'required|string',
            'thumbnail'         => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'description'       => 'required|string',
            'instruction'       => 'required|string',
            'mock_category'       => 'required|string',
            
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
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
        $rules = [
            'type' => 'required',
            'description' => 'required',
            'title' => 'required',
            'category_id' => 'required',

            'color' => 'required',
            'origin' => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => __('Type can\'t be null'),
            'title.required' => __('Title can\'t be empty'),
            'category_id.required' => __('Category can\'t be empty'),
            'color.required' => __('Color can\'t be empty'),
            'origin.required' => __('Origin can\'t be empty'),
        ];
    }
}

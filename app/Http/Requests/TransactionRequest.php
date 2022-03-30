<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'value' => 'required|numeric',
            'type'  => 'required|in:income,outcome'
        ];
    }
    
    public function messages()
    {
        return [
            'title.required'    => 'please enter title',
            'title.min'         => 'minimum characters is 3',
            'value.required'    => 'please enter value',
            'value.numeric'     => 'only numbers',
            'type.in'           => 'please enter income or outcome',
        ];
    }
}

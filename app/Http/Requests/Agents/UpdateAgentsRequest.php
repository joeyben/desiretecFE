<?php

namespace App\Http\Requests\Agents;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentsRequest extends FormRequest
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
            'name'  => 'required|string|max:64',
            'email' => 'required|email|max:255',
            'telephone' =>  'required'
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.max'          => 'Name may not be greater than 64 characters.',
            'email.max'         => 'Email may not be greater than 64 characters.',
            'telephone.integer' => 'Phone should be a number.',
        ];
    }
}

<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\Request;

/**
 * Class StoreContactRequest.
 */
class StoreContactRequest extends Request
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
            'first_name'         => 'required|max:191',
            'last_name'          => 'required|max:191',
            'email'              => ['required', 'email', 'max:255'],
            'subject'            => 'required|max:191'
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
            'first_name.required' => 'Please insert Contact First name',
            'last_name.required'  => 'Please insert Contact Last name',
            'email.required'      => 'Please insert Contact Email',
            'subject.required'    => 'Please insert Contact Subject'
        ];
    }
}

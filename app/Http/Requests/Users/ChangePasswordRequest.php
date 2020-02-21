<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChangePasswordRequest.
 */
class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password'     => 'required|min:6|confirmed',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least 1 uppercase letter and 1 number.',
        ];
    }
}

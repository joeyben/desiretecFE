<?php

namespace App\Http\Requests\Wishes;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreWishesRequest extends FormRequest
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
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        return response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     * Determine if the form has failed validation.
     *
     * @return bool
     */
    public function failed()
    {
        return $this->getValidatorInstance()->fails();
    }

    /**
     * Determine if the form has failed validation.
     *
     * @return object
     */
    public function errors()
    {
        return $this->getValidatorInstance()->errors();
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'airport'         => 'required|max:200',
            'destination'     => 'required|max:200',
            'earliest_start'  => 'required|max:200',
            'latest_return'   => 'required|max:200',
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
            'airport.required' => 'Please insert Wish airport',
        ];
    }
}

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
            'airport'         => 'required',
            'destination'     => 'required',
            'earliest_start'  => 'required',
            'latest_return'   => 'required',
            'adults'          => 'required',
            'terms'           => 'required',
            'email'           => 'required|email'
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        $validator->sometimes('ages1', 'required', function ($input) {
            return $input->kids >= 1;
        });
        $validator->sometimes('ages2', 'required', function ($input) {
            return $input->kids >= 2;
        });
        $validator->sometimes('ages3', 'required', function ($input) {
            return $input->kids >= 3;
        });
        $validator->sometimes('ages4', 'required', function ($input) {
            return $input->kids >= 4;
        });

        return $validator;
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'            => trans('email.required'),
            'email.email'               => trans('layer.email.required'),
            'earliest_start.required'   => trans('earliest_start.required'),
            'latest_return.required'    => trans('latest_return.required'),
            'adults.required'           => trans('adults.required'),
            'airport.required'          => trans('airport.required'),
            'destination.required'      => trans('destination.required'),
            'ages1.required'            => trans('ages1.required'),
            'ages2.required'            => trans('ages2.required'),
            'ages3.required'            => trans('ages3.required'),
            'ages4.required'            => trans('ages4.required'),
        ];
    }
}

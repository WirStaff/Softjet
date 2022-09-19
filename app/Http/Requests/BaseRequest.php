<?php

namespace App\Http\Requests;

use Arr;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $validatorException = new ValidationException($validator);

        $errors = Arr::flatten($validatorException->errors());

        throw new HttpResponseException(response()->json([
            'errors' => $errors
        ])->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}

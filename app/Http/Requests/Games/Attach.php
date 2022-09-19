<?php

namespace App\Http\Requests\Games;

use App\Http\Requests\BaseRequest;

class Attach extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'genres' => ['required', 'array']
        ];
    }
}

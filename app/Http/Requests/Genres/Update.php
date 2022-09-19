<?php

namespace App\Http\Requests\Genres;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Update extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('genres', 'name')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название должно быть обязательно',
            'name.unique' => 'Название уже существует',
        ];
    }
}

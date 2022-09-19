<?php

namespace App\Http\Requests\Games;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class Store extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('games', 'name')],
            'description' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название должно быть обязательно',
            'name.unique' => 'Название уже существует',
            'description.required' => 'Описание должно быть обязательным'
        ];
    }
}

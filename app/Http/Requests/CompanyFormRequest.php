<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => ['required'],
            'description' => ['required'],
        ];
    }
}

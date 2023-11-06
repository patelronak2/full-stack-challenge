<?php

namespace App\Http\Requests;

use App\Models\Job;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'         => ['required', 'max:255'],
            'description'   => ['required'],
            'position_type' => ['required', Rule::in([Job::JOB_TYPE_IN_PERSON, Job::JOB_TYPE_REMOTE])],
            'salary_min'    => ['required', 'integer'],
            'salary_max'    => ['required', 'integer', 'gte:salary_min'],
            'location'      => ['nullable', 'string'],
            'company_id'    => ['required', 'uuid', 'exists:companies,id'],
        ];
    }
}

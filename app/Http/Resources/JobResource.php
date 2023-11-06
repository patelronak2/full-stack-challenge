<?php

namespace App\Http\Resources;

use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Job */
class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'position_type' => $this->position_type,
            'salary_min'    => JobService::convertCentsToDollars($this->salary_min),
            'salary_max'    => JobService::convertCentsToDollars($this->salary_max),
            'location'      => $this->location,
            'created_at'    => $this->created_at->format('M d, Y g:i A'),
            'company'       => CompanyResource::make($this->whenLoaded('company')),
            'company_id'    => $this->company_id
        ];
    }
}

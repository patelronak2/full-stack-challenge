<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
    public function getCompaniesWithJobCount(): Collection
    {
        return Company::withCount('jobs')->get();
    }

    public function getCompanyWithJobs(string $id): Company
    {
        return Company::with('jobs')->findOrFail($id);
    }
}

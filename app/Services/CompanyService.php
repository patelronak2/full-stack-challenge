<?php

namespace App\Services;

use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function deleteCompanyAndPublishedJobs(string $id): void
    {
        $company = Company::findOrFail($id);

        DB::beginTransaction();
        try {
            $company->jobs()->delete();
            $company->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            //Log or notify appropriate stakeholder of the error here

            throw new Exception(
                sprintf("Something went wrong while deleting company with id: %s and it's published jobs", $id)
            );
        }
    }

    public function getCompaniesWithJobCount(): Collection
    {
        return Company::withCount('jobs')->get();
    }

    public function getCompanyWithJobs(string $id): Company
    {
        return Company::with('jobs')->findOrFail($id);
    }
}

<?php

namespace App\Services;

use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function createNewCompany(array $validated): Company
    {
        $company = new Company();
        $this->setCompanyAttributes($company, $validated);
        $company->save();

        return $company;
    }

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

    public function updateCompany(mixed $validated, Company $company): void
    {
        $this->setCompanyAttributes($company, $validated);
        $company->save();
    }

    private function setCompanyAttributes(Company $company, array $validated): void
    {
        $company->name = $validated['name'];
        $company->description = $validated['description'];
    }
}

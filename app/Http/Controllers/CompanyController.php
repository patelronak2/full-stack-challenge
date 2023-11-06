<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyFormRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\JobResource;
use App\Models\Company;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $companyService)
    {
    }

    public function index(): Response
    {
        $companies = $this->companyService->getCompaniesWithJobCount();

        return Inertia::render('Company/List', [
            'companies' => new CompanyCollection($companies)
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Company/Create');
    }

    public function store(CompanyFormRequest $request)
    {
        try {
            $company = $this->companyService->createNewCompany($request->validated());

            return redirect()->route('companies.index')->with(
                'success',
                sprintf("New Company: %s created successfully", $company->name)
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function show(string $id): Response
    {
        $company = $this->companyService->getCompanyWithJobs($id);

        return Inertia::render('Company/Show', [
            'company' => new CompanyResource($company)
        ]);
    }

    public function edit(Company $company): Response
    {
        return Inertia::render('Company/Edit', [
            'company' => new CompanyResource($company)
        ]);
    }

    public function update(CompanyFormRequest $request, Company $company)
    {
        try {
            $this->companyService->updateCompany($request->validated(), $company);

            return back()->with('success', 'Company Updated successfully');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->companyService->deleteCompanyAndPublishedJobs($id);

            return redirect()->route('companies.index')
                ->with('success', sprintf('Company with id: %s and published jobs deleted successfully', $id));
        } catch (Exception $exception) {
            return redirect()->route('companies.destroy', $id)
                ->with('error', $exception->getMessage());
        }
    }
}

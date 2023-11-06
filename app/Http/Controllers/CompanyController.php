<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\JobResource;
use App\Services\CompanyService;
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

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id): Response
    {
        $company = $this->companyService->getCompanyWithJobs($id);

        return Inertia::render('Company/Show', [
            'company' => new CompanyResource($company)
        ]);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}

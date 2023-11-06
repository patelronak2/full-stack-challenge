<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCollection;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function __construct(private readonly CompanyService $companyService)
    {
    }

    public function index()
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

    public function show($id)
    {
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

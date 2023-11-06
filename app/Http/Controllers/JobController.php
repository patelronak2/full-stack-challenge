<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobCollection;
use App\Models\Job;
use App\Services\CompanyService;
use App\Services\JobService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobController extends Controller
{
    public function __construct(
        private readonly JobService $jobService,
        private readonly CompanyService $companyService
    )
    {
    }

    public function index(): Response
    {
        return Inertia::render('Job/List', [
            'jobs' => new JobCollection(Job::with('company')->orderByDesc('created_at')->get())
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

<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
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

    public function show(string $id): Response
    {
        $job = $this->jobService->getDetailsForAJob($id);

        return Inertia::render('Job/Show', [
            'job' => new JobResource($job)
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

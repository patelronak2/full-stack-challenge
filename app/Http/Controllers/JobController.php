<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobFormRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\CompanyService;
use App\Services\JobService;
use Exception;
use Illuminate\Http\RedirectResponse;
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

    public function create(): Response
    {
        return Inertia::render('Job/Create', [
            'companies' => new CompanyCollection($this->companyService->getAllCompanies())
        ]);
    }

    public function store(JobFormRequest $request)
    {
        try {
            $job = $this->jobService->createNewJob($request->validated());

            return redirect()->route('jobs.index')->with(
                'success',
                sprintf("New job with id: %s created successfully", $job->id)
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function show(string $id): Response
    {
        $job = $this->jobService->getDetailsForAJob($id);

        return Inertia::render('Job/Show', [
            'job' => new JobResource($job)
        ]);
    }

    public function update(JobFormRequest $request, Job $job): RedirectResponse
    {
        try {
            $this->jobService->updateJob($request->validated(), $job);

            return back()->with('success', 'Changes made successfully');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function edit(Job $job)
    {
        return Inertia::render('Job/Edit', [
            'job' => new JobResource($job),
            'companies' => new CompanyCollection($this->companyService->getAllCompanies())
        ]);
    }

    public function destroy($id)
    {
    }
}

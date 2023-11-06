<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class JobService
{
    private function setJobAttributes(Job $job, array $validated): void
    {
        $job->title = $validated['title'];
        $job->description = $validated['description'];
        $job->position_type = $validated['position_type'];
        $job->salary_min = self::convertDollarsToCents($validated['salary_min']);
        $job->salary_max = self::convertDollarsToCents($validated['salary_max']);
        $job->company_id = $validated['company_id'];
        $job->location = $job->position_type === Job::JOB_TYPE_IN_PERSON ? $validated['location'] : null;
    }

    public function createNewJob(array $validated): Job
    {
        $job = new Job();
        $this->setJobAttributes($job, $validated);
        $job->save();

        return $job;
    }

    public function deleteJob(Job $job): void
    {
        $job->delete();
    }

    public function getFilteredJobs(Request $request): Collection
    {
        $jobQuery = Job::with('company')->orderByDesc('created_at');

        if ($request->input('position_type')) {
            $jobQuery->where('position_type', $request->input('position_type'));
        }

        if ($request->input('salary_min')) {
            $jobQuery->where('salary_min', '>=', self::convertDollarsToCents($request->input('salary_min')));
        }

        if ($request->input('salary_max')) {
            $jobQuery->where('salary_max', '<=', self::convertDollarsToCents($request->input('salary_max')));
        }

        if ($request->input('company_id')) {
            $jobQuery->where('company_id', $request->input('company_id'));
        }

        if ($request->input('location')) {
            $jobQuery->where('location', $request->input('location'));
        }

        return $jobQuery->get();
    }

    public function updateJob(array $validated, Job $job): void
    {
        $this->setJobAttributes($job, $validated);
        $job->save();
    }

    public static function convertCentsToDollars(int $amountInCents): float|int
    {
        return $amountInCents / 100;
    }

    public static function convertDollarsToCents(float|int $amountInDollars): int
    {
        return $amountInDollars * 100;
    }

    public static function generateMinimumSalary(): int
    {
        return self::convertDollarsToCents(fake()->randomDigitNotNull() * 10000);
    }

    public static function generateMaximumSalary(int $minimumSalary): int
    {
        return $minimumSalary + self::convertDollarsToCents(fake()->randomDigitNotNull() * 10000);
    }

    public function getDetailsForAJob(string $id): Job
    {
        return Job::with('company')->findOrFail($id);
    }
}

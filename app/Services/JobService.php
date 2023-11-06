<?php

namespace App\Services;

use App\Models\Job;

class JobService
{
    private function setJobAttributes(Job $job, array $validated): void
    {
        $job->title = $validated['title'];
        $job->description = $validated['description'];
        $job->position_type = $validated['position_type'];
        $job->salary_min = $validated['salary_min'] * 100;
        $job->salary_max = $validated['salary_max'] * 100;
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

    public function updateJob(array $validated, Job $job): void
    {
        $this->setJobAttributes($job, $validated);
        $job->save();
    }

    public static function generateMinimumSalary(): int
    {
        return fake()->randomDigitNotNull() * 10000000; // Generate in cents
    }

    public static function generateMaximumSalary(int $minimumSalary): int
    {
        return $minimumSalary + (fake()->randomDigitNotNull() * 1000000); // Generate in cents
    }

    public function getDetailsForAJob(string $id): Job
    {
        return Job::with('company')->findOrFail($id);
    }
}

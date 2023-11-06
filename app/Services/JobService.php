<?php

namespace App\Services;

use App\Models\Job;

class JobService
{
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

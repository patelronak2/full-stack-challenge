<?php

namespace Database\Factories;

use App\Models\Job;
use App\Services\JobService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        $minimumSalary = JobService::generateMinimumSalary();
        $positionType = $this->faker->randomElement([Job::JOB_TYPE_IN_PERSON, Job::JOB_TYPE_REMOTE]);

        return [
            'title'         => $this->faker->jobTitle(),
            'description'   => $this->faker->paragraphs(6, true),
            'position_type' => $positionType,
            'salary_min'    => $minimumSalary,
            'salary_max'    => JobService::generateMaximumSalary($minimumSalary),
            'location'      => $positionType !== Job::JOB_TYPE_REMOTE ? $this->faker->city() : null,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}

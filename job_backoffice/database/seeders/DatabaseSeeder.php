<?php

namespace Database\Seeders;

use App\Models\jobCategory;
use App\Models\company;
use App\Models\jobVacancy;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\resume;
use App\Models\jobApplication;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed the admin user first
        User::firstOrCreate([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Load the JSON data
        $jsonPath = database_path('data/job_data.json');

        if (file_exists($jsonPath)) {
            $jobData = json_decode(file_get_contents($jsonPath), true);
            $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

            // 3. Loop through and seed categories
            foreach ($jobData['jobCategories'] as $category) {
                jobCategory::firstOrCreate([
                    'name' => $category,
                ]);
            }
        }

        foreach ($jobData['companies'] as $company) {
            $companyowner = User::firstOrCreate([
                'email' => fake()->unique()->email(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate(
                [
                    'name' => $company['name'],

                ],
                [
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'ownerId' => $companyowner->id,
                ]
            );
        }

        foreach ($jobData['jobVacancies'] as $job) {
            //get the created company
            $company = Company::where('name', $job['company'])->firstOrFail();

            //get the created job category
            $jobCategory = jobCategory::where('name', $job['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $job['title'],
                'companyId' => $company->id,

            ],     [
                'description' => $job['description'],
                'location' => $job['location'],
                'type' => $job['type'],
                'salary' => $job['salary'],
                'jobCategoryId' => $jobCategory->id,
            ]);
        }

        //create job Applications
        foreach ($jobApplications['jobApplications'] as $application) {
            // get random job
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            //get applicant (job seeker)
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail()
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            //create resume
            // create resume
            $resume = Resume::firstOrCreate([
                'userId' => $applicant->id,
            ], [
                // CHANGE '$applicant' TO '$application' ON ALL THESE LINES:
                'filename'       => $application['resume']['filename'],
                'fileUri'        => $application['resume']['fileUri'],
                'contactDetails' => $application['resume']['contactDetails'],
                'summary'        => $application['resume']['summary'],
                'skills'         => $application['resume']['skills'],
                'experience'     => $application['resume']['experience'],
                'education'      => $application['resume']['education'],
            ]);

            //create job application
            jobApplication::firstOrCreate([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
                'status' => $application['status'],
                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
            ]);
        }
    }
}

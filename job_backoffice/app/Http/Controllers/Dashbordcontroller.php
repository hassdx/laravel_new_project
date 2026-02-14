<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\jobApplication;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\User;

class Dashbordcontroller extends Controller
{
    public function index()
    {
        if(auth()->user()->role == 'admin'){
            $analytics = $this->adminDashboard();
        }else{
            $analytics = $this->companyOnwerDashboard();
        }

        return view('dashboard.index', compact(['analytics']));
    }

    private function adminDashboard()
    {
          // last 30 days active users
          $activeUsers = User::where('last_log_at', '>=', now()->subDays(30))
          ->where('role', 'job-seeker')->count();

      // total jobs  not delleted

      $totalJobs = JobVacancy::whereNull('deleted_at')->count();

      // total applications not deleted
      $totalApplications = jobApplication::whereNull('deleted_at')->count();



      // most appleid jobs
      $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
          ->whereNull('deleted_at')
          ->orderByDesc('totalCount')
          ->take(5)
          ->get();

      // conversion rates
      $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
          ->having('totalCount', '>', 0)
          ->orderByDesc('totalCount')
          ->take(5)
          ->get()
          ->map(function ($job) {
              if ($job->viewCount > 0) {
                  $job->conversionRate = round(($job->totalCount / $job->viewCount) * 100, 2);
              } else {
                  $job->conversionRate = 0;
              }
              return $job;
          });

          $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates
        ];

          return $analytics;
    }

    private function companyOnwerDashboard()
    {
        $company = auth()->user()->company;

        //filter active users by appliying jobs
        $activeUsers = User::where('last_log_at', '>=', now()->subDays(30))
        ->where('role', 'job-seeker')
        ->whereHas('jobApplications', function ($query) use ($company) {
            $query->whereIn('jobVacancyId', $company->JobVacancies->pluck('id')); 
        })->count();

        //total jobs of the company
        $totalJobs = $company->JobVacancies->count();

        //total applications of the company
        $totalApplications = jobApplication::whereIn('jobVacancyId', $company->JobVacancies->pluck('id'))->count();

        // most applied jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->where('companyId', $company->id)
            ->whereNull('deleted_at')
            ->orderByDesc('totalCount')
            ->take(5)
            ->get();

        // conversion rates
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->where('companyId', $company->id)
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->take(5)
            ->get()
            ->map(function ($job) {
                if ($job->viewCount > 0) {
                    $job->conversionRate = round(($job->totalCount / $job->viewCount) * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });




        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates

        ];

        return $analytics;

    }
      
}

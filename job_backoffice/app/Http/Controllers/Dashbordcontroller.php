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
        // last 30 days active users
        $activeUsers = User::where('last_log_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        // total jobs  not delleted

        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // total applications not deleted
        $totalApplications = jobApplication::whereNull('deleted_at')->count();

        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
        ];

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

        return view('dashboard.index', compact(['analytics', 'mostAppliedJobs', 'conversionRates']));
    }
}

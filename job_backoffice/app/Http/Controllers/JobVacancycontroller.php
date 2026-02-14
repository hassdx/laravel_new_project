<?php

namespace App\Http\Controllers;
use App\Models\JobVacancy;  
use App\Models\Company; 
use Illuminate\Http\Request;
use App\Models\jobCategory;
use App\Http\Requests\JobVacancyUpdateRequest;


class JobVacancycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start the query
        $query = JobVacancy::query();
        
        if(auth()->user()->role == 'company-owner') {
            $query->where('companyId', auth()->user()->company->id);
        }

    
        // Check if we want archived items
        if ($request->input('archived') == 'true') {
            $query = JobVacancy::onlyTrashed(); // Assign the trashed query to $query
        }
    
        // Apply sorting and pagination
        $jobVacancies = $query->latest()->paginate(10)->onEachSide(1);
    
        return view('job-vacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $jobCategories = jobCategory::all();
        return view('job-vacancy.create', compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyUpdateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = jobVacancy::findOrFail($id);
        return view('job-vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = jobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobCategories = jobCategory::all();
        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = jobVacancy::findOrFail($id);
        $jobVacancy->update($validated);

        if ($request->query('redirectToList') == 'false') {
            return redirect()->route('job-vacancies.show', $id)->with('success', 'Job vacancy updated successfully.');
        }

        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = jobVacancy::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy deleted successfully.');
    }

        /**
        * Restore the specified resource from storage.
        */
        public function restore(string $id)
        {
            $jobVacancy = jobVacancy::withTrashed()->findOrFail($id);
            $jobVacancy->restore();
            return redirect()->route('job-vacancies.index', ['archived' => 'true'])->with('success', 'Job vacancy restored successfully.');
        }
}

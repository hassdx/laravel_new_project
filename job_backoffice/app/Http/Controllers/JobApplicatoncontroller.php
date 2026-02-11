<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\jobApplication;
use Illuminate\Http\Request;

class JobApplicatoncontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       //active
       $query = jobApplication::latest();

       //archived
       if ($request->input('archived') == 'true') {
           $query->onlyTrashed();
       }
       $jobVacancies = $query->paginate(10)->onEachSide(1);
       return view('job-vacancy.index', compact('jobVacancies'));
   }   



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = jobApplication::findOrFail($id);
        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = jobApplication::findOrFail($id);
        return view('job-application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = jobApplication::findOrFail($id);
        $validated = $request->validated();
        $jobApplication->update([
            'Status' => $request->input('Status'),
        ]);

        if ($request->query('redirectToList') == 'false') {
            return redirect()->route('job-applications.show', $id)->with('success', 'Job vacancy updated successfully.');
        }

        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = jobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'Job application deleted successfully.');
    }

    public function restore(string $id)
    {
        $jobApplication = jobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-applications.index', ['archived' => 'true'])->with('success', 'Job application restored successfully.');
    }
}

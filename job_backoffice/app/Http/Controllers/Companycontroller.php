<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\companyUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class Companycontroller extends Controller
{
    public $industries = [
        'Technology',
        'Finance',
        'Healthcare',
        'Education',
        'Retail',
        'Manufacturing',
        'Transportation',
        'Energy',
        'Entertainment',
        'Hospitality',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        //active
        $query = company::latest();

        //archived
        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }
        $companies = $query->paginate(10)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(companyCreateRequest $validated)
    {

        $validatedData = $validated->validated();

        // create owner
        $owner = User::create([
            'name' => $validated->owner_name,
            'email' => $validated->owner_email,
            'password' => hash::make($validated->owner_password),
            'role' => 'company-owner',  
        ]);

        //return error if owner creation failed
        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Failed to create company owner. Please try again.');
        }

        // create company
       Company::create([
            'name' => $validated->name,
            'address' => $validated->address,
            'industry' => $validated->industry,
            'website' => $validated->website,
            'ownerId' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = company::findOrFail($id);
        $industries = $this->industries;
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        // Validate the request
        $validated = $request->validated();
    
        // Find the company
        $company = Company::findOrFail($id);
    
        // Update the company fields
        $company->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
        ]);
    
        // Update the owner fields
        $owner = $company->owner; // Get the related owner
        $owner->name = $validated['owner_name'];
    
        // Update the password only if provided
        if (!empty($validated['owner_password'])) {
            $owner->password = Hash::make($validated['owner_password']);
        }
    
        $owner->save(); // Save the updated owner
    
        // Redirect based on the query parameter
        if ($request->query('redirectToList') == 'false') {
            return redirect()->route('companies.show', $company)->with('success', 'Company updated successfully.');
        }
    
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = company::findOrFail($id);
        $category->delete();
        return redirect()->route('companies.index')->with('success', 'company archived successfully.');
    }

    public function restore(string $id)
    {
        $category = company::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'company restored successfully.');
    }
}

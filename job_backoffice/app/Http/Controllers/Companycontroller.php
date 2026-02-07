<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\companyUpdateRequest;


class Companycontroller extends Controller
{
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
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(companyCreateRequest $request)
    {
        $validatedData = $request->validated();
        company::create($validatedData);
        return redirect()->route('company.index')->with('success', 'company created successfully.');
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
        $category = company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $category = company::findOrFail($id);
        $category->update($validatedData);
        return redirect()->route('company.index')->with('success', 'company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = company::findOrFail($id);
        $category->delete();
        return redirect()->route('company.index')->with('success', 'company archived successfully.');
    }

    public function restore(string $id)
    {
        $category = company::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('company.index', ['archived' => 'true'])->with('success', 'company restored successfully.');
    }
}

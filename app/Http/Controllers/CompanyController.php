<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $companies = Company::all();

        return DataTables::of($companies)
            ->addColumn('action', function ($company) {
                $editUrl = route('companies.edit', $company->id);
                $deleteUrl = route('companies.destroy', $company->id);
                $buttons = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>';
                $buttons .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>';
                return $buttons;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $companies = Company::all(); // Define the $companies variable

    return view('companies.index', compact('companies'));
}

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'logo' => 'required',
        ]);


     $image = $request->logo;
     $imgNewName = time().$image->getClientOriginalName();
     $imgPath = $image->move('images' ,  $imgNewName);

 


        // Create a new company
        $company = new Company();
        $company->name = $request->input('name');
        $company->address = $request->input('address');
        $company->logo = $imgPath;
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        // Update the company
        $company = Company::findOrFail($id);
        $company->name = $request->input('name');
        $company->address = $request->input('address');
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.show', compact('company'));
    }
}

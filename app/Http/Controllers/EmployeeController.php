<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function index(Request $request)
     {
         if ($request->ajax()) {
             $employees = Employee::query();

             if ($request->has('company')) {
                 $employees->where('company_id', $request->input('company'));
             }

             return DataTables::of($employees)
                 ->addColumn('company', function ($employee) {
                     return $employee->company->name;
                 })
                 ->addColumn('edit', function ($employee) {
                     return '<a href="' . route('employees.edit', $employee->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                 })
                 ->addColumn('delete', function ($employee) {
                     $deleteUrl = route('employees.destroy', $employee->id);
                     $deleteForm = '<form action="' . $deleteUrl . '" method="POST" style="display:inline">';
                     $deleteForm .= csrf_field();
                     $deleteForm .= method_field('DELETE');
                     $deleteForm .= '<button type="submit" class="btn btn-sm btn-danger">Delete</button>';
                     $deleteForm .= '</form>';
                     return $deleteForm;
                 })
                 ->addColumn('image', function ($employee) {
                     return '<img src="' . $employee->image_url . '" alt="Employee Image" width="50" height="50">';
                 })
                 ->rawColumns(['edit', 'delete', 'image'])
                 ->make(true);
         }

         $companies = Company::pluck('name', 'id'); // Fetch only the company names and IDs
         $employees = Employee::all();

         return view('employees.index', compact('employees', 'companies'));
     }
             public function create()
    {
        $companies = Company::all();

        return view('employees.create', compact('companies'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'company_id' => 'required|exists:companies,id',
            'password' => 'required',
            'image'=>'required'
        ]);

     $photo = $request->image;
     $imgNewName = time().$photo->getClientOriginalName();
     $imgPath = $photo->move('images' ,  $imgNewName);




        // Create a new employee
        $employee = new Employee();
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->password = Hash::make($request->input('password'));
        $employee->image = $imgPath;
        $employee->company_id = $request->input('company_id');
        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::with('company')->findOrFail($id);
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Update the employee
        $employee = Employee::findOrFail($id);
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->company_id = $request->input('company_id');
        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function show($id)
    {
        $employee = Employee::with('company')->findOrFail($id);
        return view('employees.show', compact('employee'));
    }
    }

<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id','desc')->paginate(3); 
        $companies = Company::orderBy('name')->get(); 
        return Inertia::render('Employee', [
            'employees' => $employees,
            'companies' => $companies
        ]);
    }
    
    public function create(Request $request)
    {
        Employee::create($request->all());
        return redirect()->back()->with('success', 'Employee Added');
    }

    public function update(Request $request)
    {
        if ($request->has('id')) {
            Employee::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('success', 'Employee Updated');
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            Employee::find($request->input('id'))->delete();
            return redirect()->back()->with('success', 'Employee Deleted');
        }
    }
}

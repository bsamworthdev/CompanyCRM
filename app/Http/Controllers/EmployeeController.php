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
        $employees = Employee::orderBy('first_name')->paginate(10); 
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

    public function update(Request $request, $employee_id)
    {
        if ($employee_id) {
            Employee::find($employee_id)->update($request->all());
            return redirect()->back()->with('success', 'Employee Updated');
        }
    }

    public function delete(Request $request, $employee_id)
    {
        if ($employee_id) {
            Employee::find($employee_id)->delete();
            return redirect()->back()->with('success', 'Employee Deleted');
        }
    }
}

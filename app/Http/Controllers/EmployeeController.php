<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); 
        return Inertia::render('Employee', ['employees' => $employees]);
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

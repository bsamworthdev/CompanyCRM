<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all(); 
        return Inertia::render('Company', ['companies' => $companies]);
    }
    
    public function create(Request $request)
    {
        Company::create($request->all());
        return redirect()->back()->with('success', 'Company Added');
    }

    public function update(Request $request)
    {
        if ($request->has('id')) {
            Company::find($request->input('id'))->update($request->all());
            return redirect()->back()->with('success', 'Company Updated');
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            Company::find($request->input('id'))->delete();
            return redirect()->back()->with('success', 'Company Deleted');
        }
    }
}

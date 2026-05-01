<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Employee;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('hr.departments', compact('departments'));
    }

    public function create()
    {
        return view('hr.add_department');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required'
        ]);

        Department::create([
            'department_name' => $request->department_name
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'Department Added');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('hr.edit_department', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $department->update([
            'department_name' => $request->department_name
        ]);

        return redirect()->route('departments.index')
            ->with('success', 'Department Updated');
    }

    
    public function delete($id)
    {
        $department = Department::findOrFail($id);

        // تحقق إذا فيه موظفين
        $hasEmployees = Employee::where('department_id', $id)->exists();

        if ($hasEmployees) {
            return redirect()->route('departments.index')
                ->with('error', 'The department cannot be deleted because it contains employees.');
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department Deleted');
    }
}


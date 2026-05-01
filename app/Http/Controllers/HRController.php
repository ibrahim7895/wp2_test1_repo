<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
Hash::make('123456');

use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;
use App\Models\EmployeeStatus;



class HRController extends Controller
{

    public function dashboard()
    {
        $timeout = 300; // 5 دقائق (بالثواني)

        if (session()->has('last_activity')) {

            if (time() - session('last_activity') > $timeout) {
                session()->flush(); // حذف الجلسة
                return redirect('/login')->with('error', 'Session expired, please login again');
            }
        }
        
        return view('hr.dashboard');     
    }

    public function add_employee()
    {
        $timeout = 10; // 5 دقائق (بالثواني)

        if (session()->has('last_activity')) {

            if (time() - session('last_activity') > $timeout) {
                session()->flush(); // حذف الجلسة
                return redirect('/login')->with('error', 'Session expired, please login again');
            }
        }
        
        return view('hr.add_employee');
    }



public function create()
{
    $departments = Department::all();
    $roles = Role::all();

    return view('hr.add_employee', compact('departments', 'roles'));
}




    public function store(Request $request)
    {

        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'salary' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'department_id' => 'nullable|exists:DEPARTMENT,department_id',
        ]);

        $imagePath = null;

        // ✅ رفع الصورة
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees', 'public');
        }

        // ✅ إدخال البيانات
        
        Employee::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'father' => $request->father,
            'mother' => $request->mother,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'national_number' => $request->national_number,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'salary' => $request->salary,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'upload_file' => $imagePath,
        ]);

        return redirect()->route('hr.employees')
            ->with('success', 'Employee Added Successfully');

    }


    public function index(Request $request)
{
    $employees = Employee::with(['department', 'role', 'status'])

        //  search
        ->when($request->firstName, function ($q) use ($request) {
            $q->where('firstName', 'like', "%{$request->firstName}%");
        })
        ->when($request->father, function ($q) use ($request) {
            $q->where('father', 'like', "%{$request->father}%");
        })
        ->when($request->lastName, function ($q) use ($request) {
            $q->where('lastName', 'like', "%{$request->lastName}%");
        })


        //  filter
        ->when($request->department_id, function ($q) use ($request) {
            $q->where('department_id', $request->department_id);
        })

        ->paginate(10)
        ->appends($request->query());

    $departments = Department::all();
    $statuses = EmployeeStatus::all();

    return view('hr.employees', compact('employees', 'departments', 'statuses'));
}


    public function testDB()
    {
        try {
            DB::connection()->getPdo();
            return "Connected successfully to MySQL!";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }




    public function delete($id)
{
    $employee = Employee::findOrFail($id);

    if ($employee->department_id != null) {
        return redirect()->route('hr.employees')
            ->with('error', 'Cannot delete: Employee has a department!');
    }

    $employee->delete();

    return redirect()->route('hr.employees')
        ->with('success', 'Employee Deleted Successfully');
}





    public function edit($id)
{
    $employee = Employee::findOrFail($id);
    $departments = Department::all();
    $roles = Role::all();

    return view('hr.edit_employee', compact('employee', 'departments', 'roles'));
}   






    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $imagePath = $employee->upload_file;

        // ✅ إذا في صورة جديدة
        if ($request->hasFile('image')) {

            // حذف القديمة (اختياري 🔥)
            if ($employee->upload_file) {
                \Storage::disk('public')->delete($employee->upload_file);
            }

            // رفع الجديدة
            $imagePath = $request->file('image')->store('employees', 'public');
        }

        // ✅ تحديث البيانات
        $employee->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'father' => $request->father,
            'mother' => $request->mother,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'salary' => $request->salary,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'upload_file' => $imagePath,
        ]);

        return redirect()->route('hr.employees')
            ->with('success', 'Employee Updated Successfully');
    }


    public function changeStatus(Request $request, $id)
    {
        $user = session('user');

        if (!$user || $user->account_status != 'hr_manager') {
            return "Unauthorized";
        }

        DB::statement('CALL ChangeEmployeeStatus(?, ?)', [
            $id,
            $request->employee_status_id
        ]);

        return back()->with('success', 'Status Updated Successfully');
    }

   public function statusPage()
    {
        $employees = Employee::with('status')->get();
        $statuses = EmployeeStatus::all();

        return view('hr.employee_status', compact('employees', 'statuses'));
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return view('hr.employee_details', compact('employee'));
    }
}
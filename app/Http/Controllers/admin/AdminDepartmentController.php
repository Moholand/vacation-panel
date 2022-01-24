<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateDepartmentRequest;
use App\Http\Requests\AdminUpdateDepartmentRequest;

class AdminDepartmentController extends Controller
{
    public function index() 
    {
        $departments = Department::with(['administrator', 'employees'])->get();

        return view('admin.departments.index', ['departments' => $departments]);
    }

    public function create() 
    {
        return view('admin.departments.create', ['users' => User::all()]);
    }

    public function store(AdminCreateDepartmentRequest $request) {
        Department::create( $request->only(['name', 'head']) );

        return redirect()->back()->with('successMessage', 'واحد کاری جدید با موفقیت ایجاد شد');
    }

    public function edit(Department $department) {
         return view('admin.departments.create', ['department' => $department, 'users' => User::all()]); 
    }

    public function update(AdminUpdateDepartmentRequest $request, Department $department) 
    {
        $department->update( $request->only(['name', 'head']) );

        return redirect()->back()->with('successMessage', 'واحد کاری با موفقیت ویرایش شد');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        
        return redirect()->back()->with('successMessage', 'واحد کاری با موفقیت حذف شد');
    }
}

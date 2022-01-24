<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateDepartmentRequest;
use App\Http\Requests\AdminUpdateDepartmentRequest;

class AdminDepartmentController extends Controller
{
    public function index() 
    {
        $departments = Department::all();

        return view('admin.departments.index', ['departments' => $departments]);
    }

    public function create() 
    {
        return view('admin.departments.create', 
            ['users' => User::all()]
        );
    }

    public function store(AdminCreateDepartmentRequest $request) {
        Department::create([
            'name' => $request->name,
            'head' => $request->head
        ]);

        session()->flash('successMessage', 'واحد کاری جدید با موفقیت ایجاد شد');
        return redirect()->back();
    }

    public function edit(Department $department) {
        $users = User::all();

        return view('admin.departments.create', 
            ['department' => $department, 'users' => $users]
        ); 
    }

    public function update(AdminUpdateDepartmentRequest $request, Department $department) 
    {
        $department->update([
            'name' => $request->name,
            'head' => $request->head
        ]);

        session()->flash('successMessage', 'واحد کاری جدید با موفقیت ایجاد شد');
        return redirect()->back();
    }

    public function destroy(Department $department)
    {
        $department->delete();
        session()->flash('successMessage', 'واحد کاری با موفقیت حذف شد');
        return redirect()->back();
    }
}

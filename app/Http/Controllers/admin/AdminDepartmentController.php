<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCreateDepartmentRequest;

class AdminDepartmentController extends Controller
{
    public function index() 
    {
        return view('admin.departments.index', 
            ['departments' => Department::all()]
        );
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

    public function edit(Request $request, Department $department) {
        $users = User::all();

        return view('admin.departments.create', 
            ['department' => $department, 'users' => $users]
        ); 
    }

    public function update(Department $department) 
    {
        //
    }
}

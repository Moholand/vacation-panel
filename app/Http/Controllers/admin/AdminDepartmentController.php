<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDepartmentController extends Controller
{
    public function index() 
    {
        $departments = Department::all();
        
        return view('admin.departments.index', ['departments' => $departments]);
    }
}

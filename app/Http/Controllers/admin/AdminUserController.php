<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Jobs\UserConfirmation;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();

        $employees = User::with('department')->where('isAdmin', false)
        ->searchInUser()
        ->filterByDepartment()
        ->filterByStatus()
        ->paginate($request->perPage ?? 20) // 20 is the default perPage
        ->withQueryString();;

        return view('admin.users', compact(['employees', 'departments']));
    }

    public function update(Request $request, User $user)
    {
        // Update user isVerified field
        $user->isVerified = $request->verification === 'verified' ? true : false;
        $user->save();

        // Send notification to user
        UserConfirmation::dispatch($user, $request->verified);

        session()->flash('successMessage', 'تغییرات با موفقیت ذخیره شد');
        return redirect()->back();
    }
}

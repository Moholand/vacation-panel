<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\UserConfirmation;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Facades\Cache;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();

        if($request->search) {
            $employees = User::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')->get();
        } else if($request->department_id) {
            $employees = User::where('department_id', $request->department_id)->get();
        } else if($request->user_status) {
            $employees = User::where('isVerified', $request->user_status === 'confirm' ? 1 : 0)->get();
        } else {
            // Cache all employees  
            $employees = Cache::rememberForever('employees', function() {
                return User::where('isAdmin', false)->with('department')->get();
            });
        }

        return view('admin.users', ['employees' => $employees, 'departments' => $departments]);
    }

    public function update(Request $request, User $user)
    {
        // Update user isVerified field
        $user->isVerified = $request->verification === 'verified' ? true : false;
        $user->save();

        // Send notification to user / Delete cache to see the changes Immediately
        UserConfirmation::dispatch($user, $request->verified);
        Cache::forget('employees');

        session()->flash('successMessage', 'تغییرات با موفقیت ذخیره شد');
        return redirect()->back();
    }
}

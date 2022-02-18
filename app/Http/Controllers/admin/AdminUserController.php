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

        if($request->all()) {
            $employees = User::searchInUser()
                ->filterByDepartment()
                ->filterByStatus()
                ->get();
        } else {
            // Cache all employees  
            $employees = Cache::rememberForever('employees', function() {
                return User::where('isAdmin', false)->with('department')->get();
            });
        }

        return view('admin.users', compact(['employees', 'departments']));
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

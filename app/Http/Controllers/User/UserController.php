<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile', ['departments' => Department::all()]);
    }

    public function update(UserUpdateRequest $request, User $user) 
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id
        ]);

        if($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        session()->flash('successMessage', 'اطلاعات شما با موفقیت ویرایش شد');

        return redirect()->back();
    }
}

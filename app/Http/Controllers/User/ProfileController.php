<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class ProfileController extends Controller
{
    public function show()
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

        return redirect()->back()->with('successMessage', 'اطلاعات شما با موفقیت ویرایش شد');
    }
}

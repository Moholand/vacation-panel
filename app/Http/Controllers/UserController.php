<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function profile()
    {
        return view('vacation.profile');
    }

    public function update(UserUpdateRequest $request, User $user) 
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        session()->flash('successMessage', 'اطلاعات شما با موفقیت ویرایش شد');

        return redirect()->back();
    }
}

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
        $user = auth()->user();

        return view('vacation.profile', ['user' => $user]);
    }

    public function update(UserUpdateRequest $request, User $user) 
    {
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        session()->flash('successMessage', 'اطلاعات شما با موفقیت ویرایش شد');

        return redirect()->back();
    }

    public function uploadCropImage(Request $request)
    {
        $folderPath = public_path('img/avatars/');
 
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
 
        $imageName = uniqid() . '.png';
 
        $imageFullPath = $folderPath.$imageName;

        $imageInUI = asset('img/avatars') . '/' . $imageName;
 
        file_put_contents($imageFullPath, $image_base64);
 
        // $saveFile = new Picture;
        // $saveFile->name = $imageName;
        // $saveFile->save();
    
        return response()->json(['success'=> $imageInUI]);
    }
}

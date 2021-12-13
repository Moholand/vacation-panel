<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UserAvatarUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $folderPath = public_path('img/avatars/');
    
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
    
        $imageName = uniqid() . '.png';
    
        $imageFullPath = $folderPath . $imageName;

        $imageInUI = asset('img/avatars') . '/' . $imageName;
    
        file_put_contents($imageFullPath, $image_base64);

        // Set image as current user`s avatar
        $user = User::findOrFail($request->userId);
        
        if($user->avatar) {
            File::delete(public_path('img/avatars') . '/' . $user->avatar);
        }

        $user->avatar = $imageName;
        $user->save();
    
        return response()->json(['success'=> $imageInUI]);
    }
}

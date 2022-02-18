<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\File;

class UserService
{
  public function getTeammatesIds() : array
  {
    $teammate_ids = [];

    $teammates = auth()->user()->department()->with(['employees'])
    ->get()
    ->pluck('employees')
    ->collapse();

    foreach ($teammates as $teammate) {
        array_push($teammate_ids, $teammate->id);
    }

    return $teammate_ids;
  }

  public function setAvatar($image, $user_id) : string
  {
    $folderPath = public_path('img/avatars/');
    
    $image_parts = explode(";base64,", $image);
    // $image_type_aux = explode("image/", $image_parts[0]);
    // $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);

    $imageName = uniqid() . '.png';

    $imageFullPath = $folderPath . $imageName;

    $imageUIPath = asset('img/avatars') . '/' . $imageName;

    file_put_contents($imageFullPath, $image_base64);

    // Set image as current user`s avatar
    $user = User::findOrFail($user_id);
    
    if($user->avatar) {
      File::delete(public_path('img/avatars') . '/' . $user->avatar);
    }

    $user->avatar = $imageName;
    $user->save();

    return $imageUIPath;
  }
}
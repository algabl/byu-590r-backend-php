<?php

namespace App\Http\Controllers\API;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    public function getUser()
    {
        // dd('getUser');
        $authUser = Auth::user();
        $user = User::findOrFail($authUser->id);
        $user->avatar = $this->getS3Url($user->avatar);
        return $this->sendResponse($user, 'User');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $authUser = Auth::user();
            $user = User::findOrFail($authUser->id);
            $image_name = $authUser->id . '.' . $extension;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            Storage::disk('s3')->setVisibility($path, "public");
            $user->avatar = $path;
            $user->save();
            $success['avatar'] = null;
            if (isset($user->avatar)) {
                $success['avatar'] = $this->getS3Url($path);
            }
            return $this->sendResponse($success, 'User profile avatar uploaded successfully!');
        }
        return $this->sendError('Error uploading avatar');
    }

    public function removeAvatar()
    {
        $authUser = Auth::user();
        $user = User::findOrFail($authUser->id);
        // delete the file from s3
        Storage::disk('s3')->delete($user->avatar);
        $user->avatar = null;
        $user->save();
        return $this->sendResponse(null, 'User profile avatar removed successfully!');
    }
}
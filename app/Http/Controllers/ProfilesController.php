<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index($user)
    {
        //dd($user);
        $user = User::findOrFail($user);
        return view('profiles/index', ["user" => $user]);
    }

    public  function  edit(\App\User $user){
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public  function  update(\App\User $user)
    {
        $this->authorize('update', $user->profile);

        $data = \request()->validate([
            "title" => "required",
            "description" => "required",
            "url" => "url",
            "image" => "",
        ]);

        //dd($data);

        auth()->user->profile->update($data);

        if (\request('image')) {
            $imagePath = \request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
            $image->save();
        }

        return redirect("/profile/{$user->id}");


    }
}


<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index($user)
    {
        //dd($user);
        $user = User::findOrFail($user);
        return view('profiles/index', ["user" => $user]);
    }

    public  function  edit(\App\User $user){
        return view('profiles.edit', compact('user'));
    }

    public  function  update(\App\User $user)
    {
        $data = \request()->validate([
            "title" => "required",
            "description" => "required",
            "url" => "url",
            "image" => "",
        ]);

        //dd($data);

        auth()->user->profile->update($data);

        return redirect("/profile/{$user->id}");


    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'profile_pic' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'], 
        ]);
    }

    //show of user profile
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('/profile', ['user' => $user]);
    }

    public function edit($id)
    {
        $userinfo = User::findOrFail($id);

        return view('/profileEdit', ['info' => $userinfo]);
    }

    public function update(Request $request, $id)
    {
        $userinfo = User::findOrFail($id);

        $this->validator($request->all())->validate();

        $userinfo->name = $request->name;
        $userinfo->profile_pic = $request->profile_pic;
        $userinfo->bio = $request->bio;
        $userinfo->save();

        return redirect()->route('profile.show', $userinfo->id)->with('success', 'Profile updated successfully!');
    }
}

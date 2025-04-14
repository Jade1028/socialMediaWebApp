<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'profile_pic' => ['nullable', 'image', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:500'], 
        ]);
    }

    //show of user profile
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.profile', ['user' => $user]);
    }

    public function edit($id)
    {
        $userinfo = User::findOrFail($id);

        $this->authorize('edit', $userinfo);

        return view('pages.profileEdit', ['info' => $userinfo]);
    }

    public function update(Request $request, $id)
    {
        $userinfo = User::findOrFail($id);

        $this->authorize('update', $userinfo);
    
        $this->validator($request->all())->validate();
    
        $userinfo->name = $request->name;
    
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName(); // Generate unique filename
            $path = $file->storeAs('uploads/profile_pics', $filename, 'public'); // Store in storage/app/uploads/profile_pics
            $userinfo->profile_pic = $path; // Store the path in the database
        }
    
    
        $userinfo->bio = $request->bio;
        $userinfo->save();
    
        return redirect()->route('profile.show', $userinfo->id)->with('success', 'Profile updated successfully!');
    }
}

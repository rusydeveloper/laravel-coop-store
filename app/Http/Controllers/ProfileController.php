<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;

        $profile = Profile::where('user_id', $user_id)->first();

        return view('profiles.index', compact('profile'));
    }


    public function create()
    {
        return view('profiles.create');
    }


    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $profile = new Profile;
        $profile->user_id = $user_id;
        $profile->save();

        return redirect()->route('profile')->with('sucess', 'Profile berhasil dibuat.');
    }


    public function show(Profile $profile)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::where('user_id', $user_id)->first();

        return view('profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::where('user_id', $user_id)->first();
         return view('profiles.edit', compact('profile'));
    }


    public function update(Request $request, Profile $profile)
    {
        $user_id = Auth::user()->id;
        $profile_id = $request->profile_id;

        $profile = Profile::where('id', $profile_id)->first();
        
        $profile->name = $request->name;
        $profile->save();

        return redirect()->route('profile')->with('sucess', 'Profile berhasil diedit.');
    }

    public function destroy(Profile $profile)
    {
        Profile::destroy($request->profile_id);

        return redirect()->route('profile')->with('danger', 'Profile berhasil didelete.');
    }
}

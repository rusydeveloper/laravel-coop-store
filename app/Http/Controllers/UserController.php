<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $user = User::where('user_id', $user_id)->first();

        return view('users.index', compact('user'));
    }


    public function create()
    {
        return view('users.create');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:8|max:16',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'unique_id' => $unix_timestamp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin_user')->with('status', 'User berhasil dibuat.');
    }


    public function show(User $user)
    {
        $user_id = Auth::user()->id;
        $user = User::where('unique_id', $user_id)->first();

        return view('users.show', compact('user'));
    }

    public function edit(User $user, Request $request)
    {
        
        $item = User::where('unique_id', $request->user_id)->first();

         return view('users.edit', compact('item'));
    }


    public function update(Request $request, User $user)
    {
        
        $user = User::where('unique_id', $request->user_id)->first();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

         return redirect()->route('user')->with('status', 'User berhasil diedit.');
    }

    public function destroy(User $user)
    {
        User::destroy($request->user_id);

        return redirect()->route('user')->with('danger', 'User berhasil didelete.');
    }
}

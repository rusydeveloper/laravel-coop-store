<?php

namespace App\Http\Controllers;

use App\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;

        $picture = Picture::where('user_id', $user_id)->first();

        return view('pictures.index', compact('picture'));
    }


    public function create()
    {
        return view('pictures.create');
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $picture = new Picture;
        $picture->user_id = $user_id;
        $picture->save();

        return redirect()->route('picture')->with('sucess', 'Picture berhasil dibuat.');
    }


    public function show(Picture $picture)
    {
        $user_id = Auth::user()->id;
        $picture = Picture::where('user_id', $user_id)->first();

        return view('pictures.show', compact('picture'));
    }

    public function edit(Picture $picture)
    {
        $user_id = Auth::user()->id;
        $picture = Picture::where('user_id', $user_id)->first();
         return view('pictures.edit', compact('picture'));
    }

    public function update(Request $request, Picture $picture)
    {
        $user_id = Auth::user()->id;
        $picture_id = $request->picture_id;

        $picture = Picture::where('id', $picture_id)->first();
        
        $picture->name = $request->name;
        $picture->save();

         return redirect()->route('picture')->with('sucess', 'Picture berhasil diedit.');
    }

    public function destroy(Picture $picture)
    {
        Picture::destroy($request->picture_id);

        return redirect()->route('picture')->with('danger', 'Picture berhasil didelete.');
    }
}

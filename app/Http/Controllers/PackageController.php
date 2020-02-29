<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;

        $package = Package::where('user_id', $user_id)->first();

        return view('packages.index', compact('package'));
    }


    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $package = new Package;
        $package->user_id = $user_id;
        $package->save();

        return redirect()->route('package')->with('sucess', 'Package berhasil dibuat.');
    }


    public function show(Package $package)
    {
        $user_id = Auth::user()->id;
        $package = Package::where('user_id', $user_id)->first();

        return view('packages.show', compact('package'));
    }


    public function edit(Package $package)
    {
        $user_id = Auth::user()->id;
        $package = Package::where('user_id', $user_id)->first();
         return view('packages.edit', compact('package'));
    }


    public function update(Request $request, Package $package)
    {
        $user_id = Auth::user()->id;
        $package_id = $request->package_id;

        $package = Package::where('id', $package_id)->first();
        
        $package->name = $request->name;
        $package->save();

         return redirect()->route('package')->with('sucess', 'Package berhasil diedit.');
    }


    public function destroy(Package $package)
    {
         Package::destroy($request->package_id);

        return redirect()->route('package')->with('danger', 'Package berhasil didelete.');
    }
}

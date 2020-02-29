<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $business = Business::where('user_id', $user_id)->first();

        return view('businesses.index', compact('business'));
    }

    public function create()
    {
        return view('businesses.create');
    }

  
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $business = new Business;
        $business->user_id = $user_id;
        $business->save();

        return redirect()->route('business')->with('sucess', 'Business berhasil dibuat.');
    }

 
    public function show(Business $business)
    {
        $user_id = Auth::user()->id;
        $business = Business::where('user_id', $user_id)->first();

        return view('businesses.show', compact('business'));

    }

    public function edit(Business $business)
    {
        $user_id = Auth::user()->id;
        $business = Business::where('user_id', $user_id)->first();
         return view('businesses.edit', compact('business'));
    }

 
    public function update(Request $request, Business $business)
    {
        $user_id = Auth::user()->id;
        $business_id = $request->business_id;

        $business = Business::where('id', $business_id)->first();
        
        $business->name = $request->name;
        $business->save();

         return redirect()->route('business')->with('sucess', 'Business berhasil diedit.');


    }

    public function destroy(Business $business)
    {
        Business::destroy($request->business_id);

        return redirect()->route('business')->with('danger', 'Business berhasil didelete.');
    }
}

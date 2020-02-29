<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;

class PageController extends Controller
{
	public function landing()
    {
    	if(Auth::check()){
    	$user_role = Auth::user()->role;
    	if ($user_role=="admin") {
    		return redirect()->route('admin')->with('success', 'Berhasil masuk sebagai admin.');
    	}elseif ($user_role=="cashier") {
    		return redirect()->route('cashier')->with('success', 'Berhasil masuk sebagai cashier.');
    	}elseif ($user_role=="manager") {
    		return redirect()->route('manager')->with('success', 'Berhasil masuk sebagai manager.');
    	}
    	elseif ($user_role=="tenant") {
    		return redirect()->route('tenant')->with('success', 'Berhasil masuk sebagai tenant.');
    	}else{
    		return "tidak dapat akses";
    	}
    }

    }

    public function aboutus()
    {
        return view('pages.aboutus');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_role = Auth::user()->role;
        switch ($user_role) {
            case "tenant":
            return redirect()->route('tenant')->with('success', 'Berhasil masuk sebagai tenant.');
                break;
            case "cashier":
            return redirect()->route('cashier_order')->with('success', 'Berhasil masuk sebagai cashier.');
            case "manager":
            return redirect()->route('manager_order')->with('success', 'Berhasil masuk sebagai manager.');
            case "admin":
            return redirect()->route('admin')->with('success', 'Berhasil masuk sebagai admin.');
                break;
            case "user":

            return '/';
                break;
            default:
            return view('home');        
        }
        
    }

    public function back_to()
    {
        return redirect()->back();
    }
}

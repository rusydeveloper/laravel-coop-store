<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;

        $payment = Payment::where('user_id', $user_id)->first();

        return view('payments.index', compact('payment'));
    }

    public function create()
    {
        return view('payments.create');
    }


    public function store(Request $request)
    {
         $user_id = Auth::user()->id;

        $payment = new Payment;
        $payment->user_id = $user_id;
        $payment->save();

        return redirect()->route('payment')->with('sucess', 'Payment berhasil dibuat.');
    }

    public function show(Payment $payment)
    {
        $user_id = Auth::user()->id;
        $payment = Payment::where('user_id', $user_id)->first();

        return view('payments.show', compact('payment'));
    }


    public function edit(Payment $payment)
    {
        $user_id = Auth::user()->id;
        $payment = Payment::where('user_id', $user_id)->first();
         return view('payments.edit', compact('payment'));
    }


    public function update(Request $request, Payment $payment)
    {
        $user_id = Auth::user()->id;
        $payment_id = $request->payment_id;

        $payment = Payment::where('id', $payment_id)->first();
        
        $payment->name = $request->name;
        $payment->save();

         return redirect()->route('payment')->with('sucess', 'Payment berhasil diedit.');
    }

    public function destroy(Payment $payment)
    {
        Payment::destroy($request->payment_id);

        return redirect()->route('payment')->with('danger', 'Payment berhasil didelete.');
    }
}

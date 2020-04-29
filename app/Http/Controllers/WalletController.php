<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet()
    {
        $wallets = Wallet::orderBy('created_at','DESC')->paginate(50);

        return view('admins.wallet', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function wallet_edit(Wallet $wallet, Request $request)
    {

        $wallet = Wallet::where('unique_id', $request->unique_id)->first();
        
        return view('admins.wallets.edit', compact('wallet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function wallet_update(Request $request, Wallet $wallet)
    {
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $wallet = Wallet::where('unique_id', $request->unique_id)->first();
        $wallet->status = $request->status;

        $description = "";
        
        if($request->method=="TOP UP"){
            $wallet->balance += $request->amount;
            $description = "Penambahan saldo oleh Admin";
        }elseif($request->method=="WITHDRAW"){
            $wallet->balance -= $request->amount;
            $description = "Pengurangan saldo oleh Admin";
        }
        $wallet->save();

        $walletHistory = New WalletHistory;
        $walletHistory->unique_id = $unix_timestamp;
        $walletHistory->business_id = $wallet->business_id;
        $walletHistory->user_id = $wallet->user_id;
        $walletHistory->wallet_id = $wallet->id;
        $walletHistory->status = "success";
        $walletHistory->type = $request->method;
        $walletHistory->amount = $request->amount;
        $walletHistory->description = $description;
        $walletHistory->save();

        return redirect()->route('admin_wallet')->with('status', 'Transaksi Dompet berhasil .');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}

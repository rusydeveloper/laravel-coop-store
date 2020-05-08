<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Business;
use App\Wallet;
use App\WalletHistory;
use App\Test;
use Mail;
use App\Mail\UserRegistration;

use App\Mail\EmailTest;
use Zendesk;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'phone' => 'required|string',
            'tnc' => 'required'
        ]);
        
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'cooperative',
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'unique_id' => $unix_timestamp,
        ]);
        $user->isagree = $request->tnc;
        $user->save();

        
        

        
        

        $business = New Business;
        $business->user_id = $user->id;
        $business->name = $request->cooperative;
        $business->status = "active";
        $business->address = $request->address;
        $business->description = 'Baru Mendaftar';
        $business->category = 'koperasi';
        $business->country = 'Indonesia';
        $business->unique_id = $unix_timestamp;
        $business->save();

        

        // return response()->json([
        //     'message' => 'Successfully created user!'
        // ], 201);
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);


        $credentials = request(['email', 'password']);
        
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();

        $business = Business::where('user_id', $user->id)->first();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();


        //Create wallet
        $wallet = New Wallet;
        $wallet->unique_id = $unix_timestamp;
        $wallet->business_id = $business->id;
        $wallet->user_id = $user->id;
        $wallet->status = "active";
        $wallet->balance = 0;
        $wallet->save();

        //Create wallet history
        $walletHistory = New WalletHistory;
        $walletHistory->unique_id = $unix_timestamp;
        $walletHistory->business_id = $business->id;
        $walletHistory->user_id = $user->id;
        $walletHistory->wallet_id = $wallet->id;
        $walletHistory->status = "success";
        $walletHistory->type = "NEW ACCOUNT";
        $walletHistory->amount = 0;
        $walletHistory->description = "Pembuatan Account Kredit";
        $walletHistory->save();

        $wallet = Wallet::where('business_id', $business->id)->first();

        // $messageBody = "Terdapat pendaftar baru:".$request->name.", ".$request->email.", ".$request->phone;
        // Mail::raw($messageBody, function ($message) {
        //     $message->from('rusy@nectico.com', 'Admin Belanja Bersama Koperasi');
        //     $message->to('koperasi@nectico.com');
        //     $message->subject('Pendaftar Baru');
        // });

        $data = ['cooperative' => $request->cooperative,'name' => $request->name, 'phone' => $request->phone, 'address' => $request->address, 'email' => $request->email];

        $body_zendesk = "<table><tr><td>Nama pendaftar</td><td>".$request->name."</td></tr><tr><td>Nama Koperasi</td><td>".$request->cooperative."</td></tr><tr><td>Nomor HP</td><td>".$request->phone."</td></tr><tr><td>Alamat Koperasi</td><td>".$request->address."</td></tr><tr><td>Email</td><td>".$request->email."</td></tr></table>";

        Mail::to('koperasi@nectico.com')->send(new UserRegistration($data));
        Zendesk::tickets()->create([
            'subject' => 'Pendaftaran Koperasi',
            "tag" => "pendaftaran",
            'comment' => [
                'html_body' => $body_zendesk
            ],
            'priority' => 'normal'
        ]);

        
        return response()->json([
            'access_token' => 'Bearer '. $tokenResult->accessToken,
            'user' => $user,
            'business' => $business,
            'wallet' => $wallet,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $business = Business::where('user_id', $user->id)->first();
        $wallet = Wallet::where('business_id', $business->id)->first();
        
        return response()->json([
            'access_token' => 'Bearer '. $tokenResult->accessToken,
            'user' => $user,
            'business' => $business,
            'wallet' => $wallet,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return "halo";
        // return response()->json($request->user());
    }

    public function testAPInew(Request $request)
    {
        // return "halo";
        return response()->json($request->user());
    }
}
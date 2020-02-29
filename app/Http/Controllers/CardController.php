<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;
use App\User;
use App\Business;
use App\Product;
use App\Order;
use App\Payment;
use App\Report;
use App\Picture;
use App\Invoice;
use Carbon\Carbon;
use DB;
use Auth;
use DateTime;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('cards.index');
    }

    public function order(Request $request)
    {
        $card_number_qr = $request->card_number_qr;
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get()->sortBy("name");
        return view('cards.order', compact('products', 'card_number_qr'));
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
        // return $request;
        $user = Auth::user();
        $data_invoice = "";
        $invoice_description = "";
        $customerInfo = "";
        $data_order = "";
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $length = 7;
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $confirmationCode = Auth::user()->id;
        for ($i = 0; $i < $length; $i++) {
            $confirmationCode .= $characters[rand(0, $charactersLength - 1)];
        }

        $customerInfo = $request->customer.", no: ".$request->tableNumber;

        $data_order = "[".$request->orderContent."]";
        $data_order_json =json_decode($data_order);

        $data_invoice = "[".$request->invoiceContent."]";
        $data_invoice_json =json_decode($data_invoice);

        $cardNumberQr = $request->cardNumberQr;

       foreach ($data_order_json as $item) {
            $invoice_description .= $item->totalQuantity."pcs ".$item->name." ".$item->notes.",";
            $product = Product::where('unique_id', $item->id)->first();
            $order =  new Order;
            $order->user_id = $user->id;
            $order->business_id = $product->business->id;
            $order->product_id = $item->id;
            $order->quantity = $item->totalQuantity;
            $order->price = $item->totalPrice;
            $order->guest_name = $customerInfo;
            $order->status = 'order';
            $order->description = $item->notes;
            $order->booking_id = $confirmationCode;
            $order->unique_id = $user->id.$unix_timestamp; 
            $order->card_number_qr = $cardNumberQr;
            $order->save();
        }
        $invoice_description = substr($invoice_description, 0, -1);

        $invoice =  new Invoice;
        $invoice->user_id = $user->id;
        $invoice->business_id = $product->business_id;
        $invoice->firebase_user_id = $user->firebase_user_id;
        $invoice->status = 'unpaid';
        $invoice->quantity = $data_invoice_json[0]->invoiceQuantity;
        $invoice->amount = $data_invoice_json[0]->invoicePrice;
        $invoice->unique_id = $user->id.$unix_timestamp;
        $invoice->booking_id = $confirmationCode;
        $invoice->description = $invoice_description;
        $invoice->customer = $customerInfo;
        $invoice->card_number_qr = $cardNumberQr;
        $invoice->save();
        
        return view('cards.confirm', compact('confirmationCode', 'customerInfo'))->with('status', 'Pesanan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Order;
use App\Invoice;
use App\Product;
use Cart;

use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;

        $order = Order::where('user_id', $user_id)->first();

        return view('orders.index', compact('order'));
    }


    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $order = new Order;
        $order->user_id = $user_id;
        $order->save();

        return redirect()->route('order')->with('sucess', 'Order berhasil dibuat.');
    }

    public function show(Order $order)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->first();


        return view('orders.show', compact('order', 'cart'));
    }

    public function edit(Order $order)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->first();
         return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $user_id = Auth::user()->id;
        $order_id = $request->order_id;

        $order = Order::where('id', $order_id)->first();
        
        $order->name = $request->name;
        $order->save();

         return redirect()->route('order')->with('sucess', 'Order berhasil diedit.');
    }

    public function destroy(Order $order)
    {
        Order::destroy($request->order_id);

        return redirect()->route('order')->with('danger', 'Order berhasil didelete.');
    }

    public function add(Request $request)
    {
        $product = Product::where('unique_id', $request->product_id)->first();
        
        $cart = Cart::add($product->id, $product->name, $request->quantity, $product->price, array('notes' => $request->notes));
        return redirect()->route('landing')->with('warning', 'Pesanan berhasil disimpan, tambah lagi pesananmu.');
    }
    public function cart()
    {
        $cart = Cart::content();
        $cart_total = Cart::total();
        // return $cart;
        return view('carts.index', compact('cart', 'cart_total'));
    }

    public function cart_remove(Request $request)
    {
        $rowId = $request->rowId;
        Cart::remove($rowId);
        return redirect()->route('landing')->with('danger', 'We remove the item from your cart');
    }

    public function cart_minus(Request $request)
    {
        $rowId = $request->rowId;
        
        
        $qty_update = Cart::get($rowId)->qty-1;
        if ($qty_update == 0) {
           Cart::remove($rowId); 
        }else{
        Cart::update($rowId, $qty_update);
        }
        return redirect()->route('cart')->with('status', 'Jumlah pesanan berhasil dikurangi');
    }
    public function cart_plus(Request $request)
    {
        $rowId = $request->rowId;
        
        $qty_update = Cart::get($rowId)->qty+1;
        Cart::update($rowId, $qty_update);
        
        return redirect()->route('cart')->with('status', 'Jumlah pesanan berhasil ditambah');
    }

    public function cart_delete(Request $request)
    {
        $cart = Cart::destroy();
        return redirect()->route('landing')->with('danger', 'We remove all item from your cart');
    }

    public function complete()
    {
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);
        $cart = Cart::content();
        
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $booking_code = '';
        $random_string_length = 5;
         $max = strlen($characters) - 1;
         for ($i = 0; $i < $random_string_length; $i++) {
              $booking_code .= $characters[mt_rand(0, $max)];
         };

        $invoice_description = '';

        foreach ($cart as $item) {
            $order =  new Order;
            $order->status = 'order';
            $order->product_id = $item->id; 
            
            $product = Product::where('id', $item->id)->first();
            $invoice_description .= $item->qty." pcs ".$product->name."; ";

            $order->quantity = $item->qty; 
            $order->price = $item->subtotal;
            //owner
            $order->user_id = $product->user_id;
            $order->business_id = $product->business_id;

            $order->booking_id = $booking_code;
            $order->unique_id = $unix_timestamp; 
            $order->save();
        }
        $cart_total = Cart::total();
        $cart_total = substr($cart_total, 0, -3);
        $cart_total = str_replace(',','',$cart_total);

        $invoice =  new Invoice;
        $invoice->status = 'unpaid';
        $invoice->amount = $cart_total;
        $invoice->unique_id = $unix_timestamp;
        $invoice->booking_id = $booking_code;
        $invoice->description = $invoice_description;

        
        
        $invoice->save();

        $cart = Cart::destroy();
        
        // return redirect()->route('order_complete')->with('status', 'Your order is submitted');
        return view('carts.complete', compact('booking_code'));
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Business;
use App\Category;
use App\Campaign;

use App\Product;
use App\Order;
use App\Payment;
use App\Report;
use App\Picture;
use App\Invoice;
use App\Wallet;

use App\Test;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function user()
    {
        $users = User::all(); 
        return response()->json($users);
    }

    public function login(Request $request){

        return 'success';

        // $content = $request->getContent();


        // $array = explode('&', $content);
        // $content_all = "";
        // foreach ($array as $item) {
        //     $content_item = explode('=', $item);
        //     $format_key = str_replace("%20"," ",$content_item[0]);
        //     $format_key = str_replace("%40","@",$format_key);

        //     $format_value = str_replace("%20"," ",$content_item[1]);
        //     $format_value = str_replace("%40","@",$format_value);

        //     $content_all .= '"'.$format_key.'":"'.$format_value.'",';
        // }

        // $content_all = substr($content_all, 0, -1);
        // $content_all = '{'.$content_all.'}';

        // $content_json =json_decode($content_all);
        // // return response()->json($content_json);


        // $user = User::where('email', $content_json->email)->first();

        // if ($user === null) {
        //     // return response()->json($user);
        //     return response()->json(null);
        // }else{

        //     if (Hash::check($content_json->password, $user->password)) {
        //         return response()->json($user);
        //     }else{
        //         return response()->json(null);
        //     }
        // }
    }


    public function product()
    {
        $products = Product::paginate(50);
        // $products = Product::All()->first()->picture->first();

        

        return response()->json($products);
    }

    public function productCategory($id)
    {
        $products = Product::where('category', $id)->paginate(50);

        return response()->json($products);
    }

    public function productSearch($search)
    {
        $products = Product::where('name', 'LIKE', "%{$search}%")->paginate(50);

        return response()->json($products);
    }

    public function category()
    {
        $categories = Category::where('parent', '0')->orderBy("id")->get();

        return response()->json($categories);
    }

    public function tenantProduct(Product $product, $unique_id)
    {   
        $user = User::where('unique_id', $unique_id)->first(); 
        $products = Product::where('user_id', $user->id)->where('status', 'active')->orderBy('name')->get();

        return response()->json($products);
    }

    public function tenantInvoice(Invoice $invoice, $unique_id)
    {   
        $user = User::where('unique_id', $unique_id)->first(); 
        $invoices = Invoice::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();

        return response()->json($invoices);
    }

    public function tenantReport(Invoice $invoice, $unique_id)
    {   
        $user = User::where('unique_id', $unique_id)->first(); 
        $data = "";
        
        $today_date = (int)date('d');


        $date = date('Y-m-d');
        $date_year = date('Y');
        $date_month = date('m');
        $last_date = date('t');
        $first_week_start = $date_year."-".$date_month."-01";
        $first_week_end = $date_year."-".$date_month."-07";
        $second_week_start = $date_year."-".$date_month."-08";
        $second_week_end = $date_year."-".$date_month."-14";
        $third_week_start = $date_year."-".$date_month."-15";
        $third_week_end = $date_year."-".$date_month."-21";
        $fourth_week_start = $date_year."-".$date_month."-22";

        $last_week = $date_year."-".$date_month."-".$last_date;

        if ($today_date<=7) {
            $date_from = $first_week_start;
            $date_end = $first_week_end;
        }elseif($today_date<=14){
          $date_from = $second_week_start;
            $date_end = $second_week_end;  
        }elseif($today_date<=21){
          $date_from = $third_week_start;
            $date_end = $third_week_end;  
        }else{
            $date_from = $fourth_week_start;
            $date_end = $last_week;
        }

        //All Time
        $invoice_count_allTime = Invoice::where('user_id', $user->id)->where('status', 'paid')->where('created_at','<=',$date_end)->where('created_at','>=',$date_from)->count();
        $invoice_sum_allTime = Invoice::where('user_id', $user->id)->where('status', 'paid')->where('created_at','<=',$date_end)->where('created_at','>=',$date_from)->sum('amount');


        //Today Time
        $invoice_count_today = Invoice::where('user_id', $user->id)->where('status', 'paid')->whereDate('created_at', Carbon::today())->count();
        $invoice_sum_today = Invoice::where('user_id', $user->id)->where('status', 'paid')->whereDate('created_at', Carbon::today())->sum('amount');

        $invoice_sum_allTime = $invoice_sum_allTime*75/100;
        $invoice_sum_today = $invoice_sum_today*75/100;

        $data .= '"invoice_startPeriod":"'.$date_from.'",';
        $data .= '"invoice_endPeriod":"'.$date_end.'",';
        $data .= '"invoice_count_allTime":"'.$invoice_count_allTime.'",';
        $data .= '"invoice_sum_allTime":"'.$invoice_sum_allTime.'",';
        $data .= '"invoice_count_today":"'.$invoice_count_today.'",';
        $data .= '"invoice_sum_today":"'.$invoice_sum_today.'"';
        $data = '{'.$data.'}';

        $data_json =json_decode($data);

        return response()->json($data_json);
    }

    public function tenantReportInvoice(Invoice $invoice, $unique_id)
    {   
        $user = User::where('unique_id', $unique_id)->first(); 
        $invoices = Invoice::where('user_id', $user->id)->where('status', 'paid')->orderBy('created_at', 'desc')->get();

        return response()->json($invoices);
    }

    public function tenantOrder(Request $request){


        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $content = $request->getContent();

        $content_array = explode('&', $content);
        $content_all = "";
        $content_item_order = "";
        $invoice_description = "";
    

        foreach ($content_array as $item) {
            $content_item = explode('=', $item);

            $format_key = str_replace("%20"," ",$content_item[0]);
            $format_key = str_replace("%40","@",$format_key);

            $format_value = str_replace("%20"," ",$content_item[1]);
            $format_value = str_replace("%40","@",$format_value);
            $format_value = str_replace("%2C",",",$format_value);
            $format_value = str_replace("%7C","|",$format_value);
            $content_all .= '"'.$format_key.'":"'.$format_value.'",';
        }



    //Create JSON Object
        $content_all = substr($content_all, 0, -1);
        $content_all = '{'.$content_all.'}';
        
        
        $content_json =json_decode($content_all);



        $content_json_order = $content_json->description;
        
        

        $content_json_confirmationCode = $content_json->confirmationCode;
       
        

        $content_json_totalItem = $content_json->totalItem;

        $content_json_totalPrice = $content_json->totalPrice;
        $content_json_customer = $content_json->customer;
        $content_json_firebase_user_id = $content_json->firebaseUserId;
       
        $content_json_firebase_invoice_id = $content_json->firebaseInvoicerId;
       

        
        $content_order = substr($content_json_order, 0, -1);


        $content_order_array = explode('|', $content_order);


        foreach ($content_order_array as $item) {
            $content_item_order_array = explode(',', $item);
    

            $content_order_unique_id = $content_item_order_array[0];
            $content_order_product_name = $content_item_order_array[1];
            $content_order_quantity = $content_item_order_array[2];
            $content_order_subtotal = $content_item_order_array[3];
 
            

            $product = Product::where('unique_id', $content_order_unique_id)->first();

            $order =  new Order;
            $order->status = 'order';
            $order->product_id = $product->id; 

            $invoice_description .= $content_order_quantity." pcs ".$product->name.", ";
            $order->quantity = $content_order_quantity; 
            $order->price = $content_order_subtotal;

    //     //owner
            $order->user_id = $product->user_id;
            $order->business_id = $product->business_id;

            $order->booking_id = $content_json_confirmationCode;
            $order->unique_id = $product->user_id.$product->business_id.$unix_timestamp; 
            $order->save();



            $content_item_order_array = [];

        
        }

        $invoice =  new Invoice;
        $invoice->status = 'unpaid';
        $invoice->quantity = $content_json_totalItem;
        $invoice->amount = $content_json_totalPrice;
        $invoice->firebase_user_id = $content_json_firebase_user_id;
        $invoice->firebase_invoice_id = $content_json_firebase_invoice_id;
        $invoice->user_id = $product->user_id;
        $invoice->business_id = $product->business_id;
        $invoice->unique_id = $product->user_id.$product->business_id.$unix_timestamp; 
        $invoice->booking_id = $content_json_confirmationCode;
        $invoice->description = $invoice_description;
        $invoice->customer = $content_json_customer;


        $invoice->save();
       

        $user = User::where('user_id', $product->user_id)->first(); 

        return response()->json($user);
    }

    public function tenantInvoiceDetail(Invoice $invoice, $unique_id)
    {   


        $invoice = Invoice::where('unique_id', $unique_id)->first();
         $user = User::where('id', $invoice->user_id)->first();
         $data = "";
         $data .= '{"id":'.$invoice->id.',';
            $data .= '"user_id":'.$invoice->user_id.',';
            $data .= '"business_id":'.$invoice->business_id.',';
            $data .= '"status":"'.$invoice->status.'",';
            $data .= '"amount":'.$invoice->amount.',';
            $data .= '"description":"'.$invoice->description.'",';
            $data .= '"unique_id":"'.$invoice->unique_id.'",';
            $data .= '"booking_id":"'.$invoice->booking_id.'",';
            $data .= '"created_at":"'.$invoice->created_at.'",';
            $data .= '"updated_at":"'.$invoice->updated_at.'",';
            $data .= '"quantity":'.$invoice->quantity.',';
            $data .= '"info":"'.$invoice->info.'",';
            $data .= '"user_unique_id":"'.$user->unique_id.'"}';
        $data_json =json_decode($data);
        
        return response()->json($data_json);
    }



    public function cashierInvoice(Invoice $invoice, $unique_id)
    {   

        $user = User::where('unique_id', $unique_id)->first(); 
        $invoices = Invoice::orderBy('created_at', 'desc')->whereDate('created_at', Carbon::today())->get();

        return response()->json($invoices);
    }

    public function cashierInvoiceDetail(Invoice $invoice, $unique_id)
    {   


        $invoice = Invoice::where('unique_id', $unique_id)->first();

        return response()->json($invoice);
    }

    public function cashierOrderDetail(Invoice $invoice, $unique_id)
    {   
        $data = "";
        $orders = Order::where('unique_id', $unique_id)->get();
        
        foreach ($orders as $item) {
            $data .= '{"unique_id":"'.$item->unique_id.'",';
            $data .= '"name":"'.$item->product->name.'",';
            $data .= '"quantity":'.$item->quantity.',';
            $data .= '"price":'.$item->price.',';
            $data .= '"created_at":"'.$item->created_at.'"},';
        }
        
        $data = substr($data, 0, -1);
        $data = '['.$data.']';

        $data_json =json_decode($data);
        // return $data;
        return response()->json($data_json);

    }

    

    

    public function cashierPayment(Request $request){
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $content = $request->getContent();
        $content_array = explode('&', $content);
        $content_all = "";


        $discount_amount = 0.00;
        $discount_float = 0.00;

        foreach ($content_array as $item) {
            $content_item = explode('=', $item);

            $format_key = str_replace("%20"," ",$content_item[0]);
            $format_key = str_replace("%40","@",$format_key);

            $format_value = str_replace("%20"," ",$content_item[1]);
            $format_value = str_replace("%40","@",$format_value);
            $format_value = str_replace("%2C",",",$format_value);
            $format_value = str_replace("%7C","|",$format_value);
            $content_all .= '"'.$format_key.'":"'.$format_value.'",';
        }

        $content_all = substr($content_all, 0, -1);
        $content_all = '{'.$content_all.'}';
        $content_json =json_decode($content_all);


        
        $invoice_id = $content_json->invoice_id;
        $user_id = $content_json->user_unique_id;

        $user = User::where("unique_id", $user_id)->first();
        $invoice = Invoice::where("unique_id", $invoice_id)->first();

        $invoice_amount = $invoice->amount;
        $discount_request = $content_json->discount;

        if($discount_request != "Tidak Ada"){
            $discount_float =((float)$discount_request)/100; 
            $discount_amount = ((float)$invoice_amount)*$discount_float;
        }

        
        $invoice->payment = $content_json->payment_method;
        $invoice->bank = $content_json->bank;
        $invoice->discount = $discount_amount;
        $invoice->card_number = $content_json->cardNumber;
        $invoice->cashier_name = $user->name;
        $invoice->cash_amount = $content_json->cash_amount;
        $invoice->status = "paid";
        $invoice->save();

        

        return response()->json($user);
    }

    public function cashierReport(Invoice $invoice, $unique_id)
    {   
        $user = User::where('unique_id', $unique_id)->first(); 
        $data = "";
        //All Time
        $invoice_count_allTime = Invoice::where('status', 'paid')->count();
        $invoice_sum_allTime = Invoice::where('status', 'paid')->sum('amount');


        //Today Time
        $invoice_count_today = Invoice::where('status', 'paid')->whereDate('created_at', Carbon::today())->count();
        $invoice_sum_today = Invoice::where('status', 'paid')->whereDate('created_at', Carbon::today())->sum('amount');

        $data .= '"invoice_count_allTime":"'.$invoice_count_allTime.'",';
        $data .= '"invoice_sum_allTime":"'.$invoice_sum_allTime.'",';
        $data .= '"invoice_count_today":"'.$invoice_count_today.'",';
        $data .= '"invoice_sum_today":"'.$invoice_sum_today.'"';
        $data = '{'.$data.'}';

        $data_json =json_decode($data);

        return response()->json($data_json);
    }

    public function cashierReportInvoice(Invoice $invoice, $unique_id)
    {   
        $user = User::where('unique_id', $unique_id)->first(); 
        $invoices = Invoice::where('status', 'paid')->orderBy('created_at', 'desc')->get();

        return response()->json($invoices);
    }

    public function campaigns()
    {
        $campaigns = Campaign::with(['product', 'business', 'user'])->get(); 
        return response()->json($campaigns);
    }


    public function invoice()
    {
        $invoices = Invoice::orderBy('created_at','DESC')->with('order.product')->get();
        return response()->json($invoices);
    }

    public function invoiceUser($user_id)
    {
        $invoices = Invoice::orderBy('created_at','DESC')->where('user_id', $user_id)->with('order.product')->get();
        return response()->json($invoices);
    }

    public function checkWallet(Wallet $wallet, $user_id)
    {   
    $wallet = Wallet::where('user_id', $user_id)->first();
    return response()->json($wallet);
    }


// =====================UNUSED=============UNUSED==============UNUSED=============UNUSED=============
// =====================UNUSED=============UNUSED==============UNUSED=============UNUSED=============
// =====================UNUSED=============UNUSED==============UNUSED=============UNUSED=============
// =====================UNUSED=============UNUSED==============UNUSED=============UNUSED=============


    public function productDetail(Product $product, $unique_id){
        $product = Product::where('unique_id', $unique_id)->first();
        return response()->json($product);
    }

    

    public function business()
    {
        $businesses = Business::All();
        return response()->json($businesses);
    }

    // public function invoice()
    // {
    //     $invoices = Invoice::all()->sortByDesc('created_at');
    //     return response()->json($invoices);
    // }

    public function order()
    {
        $orders = Order::all()->sortByDesc('created_at');
        return response()->json($orders);
    }

    public function testpost()
    {
        return 'heloo';
    }

    public function add_order(Request $request)
    {
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);
        
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $booking_code = '';
        $random_string_length = 5;
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $random_string_length; $i++) {
          $booking_code .= $characters[mt_rand(0, $max)];
      };

      $invoice_description = '';
      $cart = $request->all();
      foreach($cart as $x => $x_value) {
        $order =  new Order;
        $order->product_id = $x_value['id'];
        $order->quantity = $x_value['quantity'];
        $order->price = $x_value['price']*$x_value['quantity'];
        $order->description = $x_value['name'];
        
        $order->save();
    }
    return response()->json($request, 201);
}
public function posts()
{
    $products = Product::All();

    return response()->json($products);

}

public function testuser(Request $request){
    $user = User::All()->first();
   
    return response()->json($user);
    
}

public function testrespond(Request $request){
    return response()->json($request);
}

public function testrequest(Request $request){

    $content = $request->getContent();

    $array = explode('=', $content);
    $data_info = $array[1];
    $data_info = str_replace("%20"," ",$array[1]);
    $data_info = str_replace("%40","@",$data_info);

    $test = new Test;
    $test->info = $data_info;
    $test->save();

    $data = '{"info":"'.$data_info.'"}';
    $data = json_decode($data);


    return response()->json($data);


}



}

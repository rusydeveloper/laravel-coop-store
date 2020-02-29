<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use App\User;
use App\Business;
use App\Product;
use App\Order;
use App\Payment;
use App\Report;
use App\Picture;
use App\Invoice;
use DB;
use Auth;
use Redirect;

class ManagerController extends Controller
{
    public function manager_recap()
    {
        $businesses = Business::All();
        return view('managers.recap', compact('businesses'));
    }


    public function manager_order()
    {
        $invoices = DB::table('invoices')->whereDate('created_at', '=', date('Y-m-d'))->get()->sortByDesc('created_at');
        
        return view('managers.index', compact('invoices', 'credit_providers', 'debit_providers'));
    }
    
    public function manager_payment(Invoice $invoice, Request $request)
    {
        // return $request;
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $orders = Order::where('unique_id', $request->unique_id)->get();
        // return $orders;
        $credit_providers = Payment::where('category', 'Credit')->get();
        $debit_providers = Payment::where('category', 'Debit')->get();
        $other_providers = Payment::where('category', 'Other')->get();

        return view('managers.payment', compact('invoice', 'orders', 'credit_providers', 'debit_providers', 'other_providers'));
    }

    public function manager_paid(Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $orders = Order::where('unique_id', $request->unique_id)->get();
        
        $invoice->status = 'paid';
        $invoice->payment = $request->method;
        $invoice->save();

        foreach ($orders as $item) {
            $item->status = 'paid';
            $item->save();
        }
        
        return redirect()->route('manager_order')->with('status', 'Payment berhasil dilakukan.');
    }

    public function manager_show(Invoice $invoice, Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $orders = Order::where('unique_id', $request->unique_id)->get();
        return view('managers.show', compact('invoice', 'orders'));
    }

    public function manager_report()
    {
        $invoices = DB::table('invoices')->whereDate('created_at', '=', date('Y-m-d'))->get()->sortByDesc('created_at');
        
        $orders = DB::table('orders')->whereDate('created_at', '=', date('Y-m-d'))->get()->sortByDesc('created_at');

        $group = 'user_id';
            $group_in = 'sum(amount) as sum,'.$group;
            $invoices_groupBy_tenant= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->pluck('sum',$group);
        return view('managers.report', compact('invoices', 'orders', 'invoices_groupBy_tenant'));
    }

    public function discount_request(Request $request, $unique_id)
    {
        $invoice = Invoice::where('unique_id', $unique_id)->first();

        $discount = $request->discount;
        $amount = $invoice->amount;
        $discount_amount = ($discount*$amount)/100;
        $invoice->discount = $discount_amount;
        $invoice->status = "waiting approval";
        $invoice->save();

        return redirect()->route('manager_order')->with('status', 'Request Discount Berhasil, menunggu disetujui!');
    }

    public function discount_verify(Request $request, $unique_id)
    {
        
        $password = 'pass123';
        if($password === $request->verify_password){
            $invoice = Invoice::where('unique_id', $unique_id)->first();
            $discount = $request->discount;
            $amount = $invoice->amount;
            $discount_amount = ($discount*$amount)/100;
            $invoice->discount = $discount_amount;
            $invoice->save();
            return redirect()->route('manager_order')->with('status', 'Permintaan discount berhasil, lanjutkan pembayaran!');
        }else{
            return redirect()->route('manager_order')->with('danger', 'Password Salah, ulangi permintaan discount!');
        }
        
    }


    public function report_daily(Request $request)
    {
        $category = $request->category;
        
        $date_report =  $request->date_report;
        
        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');
            
            return view('managers.reports.orders.daily', compact('orders', 'date_report'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');

            $invoices_groupBy_tenant = Invoice::groupBy('user_id')
            ->whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))
            ->selectRaw('sum(amount) as sum, user_id')
            ->pluck('sum','user_id');



            $invoices = Invoice::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');

            $group = 'user_id';
            $group_in = 'sum(amount) as sum,'.$group;
            $invoices_groupBy_tenant= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))
            ->pluck('sum',$group);


            return view('managers.reports.invoices.daily', compact('invoices', 'date_report', 'invoices_groupBy_tenant'));
        }
    }


    public function report_monthly(Request $request)
    {
        $category = $request->category;
        $month_report =  $request->month_report;
        $year_report =  $request->year_report;
        $monthNum  = $month_report;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        
        
        if ($category == 'order') {
            $orders = Order::whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)->get()->sortByDesc('created_at');
            return view('managers.reports.orders.monthly', compact('orders', 'month_report', 'year_report', 'monthName', 'subgroup'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)->get()->sortByDesc('created_at');

            $group = 'day(created_at)';
            $group_in = 'sum(amount) as sum,'.$group;
            $subgroup= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereMonth('created_at', '=', $month_report)
            ->whereYear('created_at', '=', $year_report)
            ->pluck('sum',$group);

             $group = 'user_id';
            $group_in = 'sum(amount) as sum,'.$group;
            $invoices_groupBy_tenant= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)
            ->pluck('sum',$group);

            return view('managers.reports.invoices.monthly', compact('invoices', 'month_report', 'year_report', 'monthName', 'subgroup','invoices_groupBy_tenant'));
        }
    }

    public function report_periodic(Request $request)
    {
        $category = $request->category;
        
        $date_report_start =  $request->date_report_start;
        $date_report_end =  $request->date_report_end;
        
        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            
            return view('managers.reports.orders.periodic', compact('orders', 'date_report_start', 'date_report_end'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            $group = 'user_id';
            $group_in = 'sum(amount) as sum,'.$group;
            $invoices_groupBy_tenant= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))
            ->pluck('sum',$group);


            
           


            return view('managers.reports.invoices.periodic', compact('invoices', 'date_report_start', 'date_report_end', 'invoices_groupBy_tenant'));
        }
    }

    public function manager_recap_order(Request $request){
        $tenant_user_id = $request->owner;
        $products = Product::where('user_id', $request->owner)->get()->sortBy("name");
        return view('managers.recaps.order', compact('products', 'tenant_user_id'));
    }



    public function manager_recap_submit(Request $request){

        $tenant_user_id = $request->tenant_user_id;
        // $user = Auth::user();
        $user = User::find($tenant_user_id);
        $data_invoice = "";
        $invoice_description = "";
        $customerInfo = "";
        $data_order = "";
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $length = 7;
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $confirmationCode = $tenant_user_id;
        for ($i = 0; $i < $length; $i++) {
            $confirmationCode .= $characters[rand(0, $charactersLength - 1)];
        }

        $customerInfo = $request->customer." oleh ".Auth::user()->name;

        $data_order = "[".$request->orderContent."]";
        $data_order_json =json_decode($data_order);

        $data_invoice = "[".$request->invoiceContent."]";
        $data_invoice_json =json_decode($data_invoice);

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
            $order->unique_id = $unix_timestamp; 
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
        $invoice->unique_id = $unix_timestamp;
        $invoice->booking_id = $confirmationCode;
        $invoice->description = $invoice_description;
        $invoice->customer = $customerInfo;
        $invoice->save();
        
        return view('managers.recaps.confirm', compact('confirmationCode', 'customerInfo', 'tenant_user_id'))->with('status', 'Pesanan berhasil dibuat');
    }
}

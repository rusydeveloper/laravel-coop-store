<?php

namespace App\Http\Controllers;

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
use Redirect;

class CashierController extends Controller
{
    public function cashier_order()
    {
        $invoices = DB::table('invoices')->whereDate('created_at', '=', date('Y-m-d'))->get()->sortByDesc('created_at');
        return view('cashiers.index', compact('invoices', 'credit_providers', 'debit_providers'));
    }
    
    public function cashier_payment(Invoice $invoice, Request $request)
    {
        $invoice = Invoice::whereDate('created_at', '=', date('Y-m-d'))->first();
        $orders = Order::whereDate('created_at', '=', date('Y-m-d'))->get();

        $credit_providers = Payment::where('category', 'Credit')->get();
        $debit_providers = Payment::where('category', 'Debit')->get();
        $other_providers = Payment::where('category', 'Other')->get();

        return view('cashiers.payment', compact('invoice', 'orders', 'credit_providers', 'debit_providers', 'other_providers'));
    }

    public function cashier_paid(Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $orders = Order::where('booking_id', $invoice->booking_id)->whereDate('created_at', Carbon::today())->get();
        
        $invoice->status = 'paid';
        $invoice->payment = $request->method;
        $invoice->save();

        foreach ($orders as $item) {
            $item->status = 'paid';
            $item->save();
        }
        
        return redirect()->route('cashier_order')->with('status', 'Payment berhasil dilakukan.');
    }

    public function cashier_show(Invoice $invoice, Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $orders = Order::where('unique_id', $request->unique_id)->get();
        return view('cashiers.show', compact('invoice', 'orders'));
    }

    public function cashier_report()
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
        return view('cashiers.report', compact('invoices', 'orders', 'invoices_groupBy_tenant'));
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

        return redirect()->route('cashier_order')->with('status', 'Request Discount Berhasil, menunggu disetujui!');
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
            return redirect()->route('cashier_order')->with('status', 'Permintaan discount berhasil, lanjutkan pembayaran!');
        }else{
            return redirect()->route('cashier_order')->with('danger', 'Password Salah, ulangi permintaan discount!');
        }
        
    }


    public function report_daily(Request $request)
    {
        $category = $request->category;
        
        $date_report =  $request->date_report;
        
        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');
            
            return view('cashiers.reports.orders.daily', compact('orders', 'date_report'));
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


            return view('cashiers.reports.invoices.daily', compact('invoices', 'date_report', 'invoices_groupBy_tenant'));
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
            return view('cashiers.reports.orders.monthly', compact('orders', 'month_report', 'year_report', 'monthName', 'subgroup'));
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

            return view('cashiers.reports.invoices.monthly', compact('invoices', 'month_report', 'year_report', 'monthName', 'subgroup','invoices_groupBy_tenant'));
        }
    }

    public function report_periodic(Request $request)
    {
        $category = $request->category;
        
        $date_report_start =  $request->date_report_start;
        $date_report_end =  $request->date_report_end;
        
        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            
            return view('cashiers.reports.orders.periodic', compact('orders', 'date_report_start', 'date_report_end'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            return view('cashiers.reports.invoices.periodic', compact('invoices', 'date_report_start', 'date_report_end'));
        }
    }
    
}

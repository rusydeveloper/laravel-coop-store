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
use Auth;
use DateTime;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->where('status','active')->get()->sortBy("name");
        return view('tenants.index', compact('products'));
    }

    public function user()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->get(); 
        
        return view('tenants.user', compact('users'));
    }

    public function user_show(User $user)
    {
        $user_id = Auth::user()->id;
        $user = User::where('unique_id', $user_id)->first();

        return view('tenants.users.show', compact('user'));
    }

    public function user_edit(User $user, Request $request)
    {
        
        $item = User::where('unique_id', $request->user_id)->first();

         return view('tenants.users.edit', compact('item'));
    }

    public function user_update(Request $request, User $user)
    {
        
        $user = User::where('unique_id', $request->user_id)->first();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

         return redirect()->route('tenant_user')->with('status', 'User berhasil diedit.');
    }

    public function user_reset_password(Request $request)
    {
        $item = User::where('unique_id', $request->user_id)->first();
        return view('tenants.users.reset', compact('item'));
    }

    public function user_reset_password_submit(Request $request)
    {
        $user = User::where('unique_id', $request->user_id)->first();
        if (Auth::user()->role == "admin") {
            $user->password = Hash::make($request->password);
            $user->save();
        }else{
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        }
        
        
        return redirect()->route('tenant_user')->with('status', 'Password User berhasil direset.');
    }
    
    public function business()
    {
        $user = Auth::user();
        $businesses = Business::where('user_id', $user->id)->get();
        return view('tenants.business', compact('businesses'));
    }

    public function business_create()
    {
        $user = Auth::user();
        return view('tenants.businesses.create', compact('user'));
    }

    public function business_store(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = New Business;
        $business->name = $request->name;
        $business->contact = $request->contact;
        $business->category = $request->category;
        $business->status = $request->status;
        $business->description = $request->description;
        $business->address = $request->address;
        $business->village = $request->village;
        $business->district = $request->district;
        $business->city = $request->city;
        $business->province = $request->province;
        $business->country = 'Indonesia';

        $business->unique_id = $unix_timestamp;
        $business->save();

        //=====UPLOADING IMAGE=====
        // CHECK IF FILE GALLERY IS EXIST
        if ($request->hasFile('picture_file')) {
            $date = date_create();
            $unix_timestamp = date_timestamp_get($date);

        // PICTURES
            $extension_bp = $request->picture_file->extension();

        // CHECK IF FILE IS A PICTURE
            if ($extension_bp ==='jpeg' || $extension_bp ==='jpg' || $extension_bp ==='JPG' || $extension_bp ==='JPEG' || $extension_bp ==='PNG' || $extension_bp ==='png') {

        //FILE NAMING AND SAVING SETTINGS
                $file_name_custom_bp = 'warman_bp_'.$business->user_id.'_'.$business->id.'_'.$unix_timestamp.'.'.$extension_bp;

        // SAVING PROFILE PICTURE FILES
                $path_bp = $request->file('picture_file')->storeAs('public/businesses', $file_name_custom_bp);

                $picture = new Picture;
                $picture->user_id = $business->user_id;
                $picture->business_id = $business->id;
                $picture->category = 'business picture';
                $picture->name = $file_name_custom_bp;
                $picture->save();

            }else{
                return redirect()->route('tenant_business')->with('error', 'File Gambar Business Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah project!');
                
            }
        }

        return redirect()->route('tenant_business')->with('status', 'Business berhasil dibuat.');
    }

    public function business_edit(Business $business, Request $request)
    {
        
        $business = Business::where('unique_id', $request->unique_id)->first();
        $user = Auth::user()->get();
        $picture = Picture::where('business_id', $business->id)->latest()->first();
        
         return view('tenants.businesses.edit', compact('business', 'user', 'picture'));
    }

    public function business_update(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = Business::where('unique_id', $request->unique_id)->first();
        
        $business->name = $request->name;
        $business->contact = $request->contact;
        $business->category = $request->category;
        
        $business->description = $request->description;
        $business->address = $request->address;
        $business->village = $request->village;
        $business->district = $request->district;
        $business->city = $request->city;
        $business->province = $request->province;
        $business->country = 'Indonesia';


        //=====UPLOADING IMAGE=====
        // CHECK IF FILE GALLERY IS EXIST
        if ($request->hasFile('picture_file')) {
            $date = date_create();
            $unix_timestamp = date_timestamp_get($date);

        // PICTURES
            $extension_bp = $request->picture_file->extension();

        // CHECK IF FILE IS A PICTURE
            if ($extension_bp ==='jpeg' || $extension_bp ==='jpg' || $extension_bp ==='JPG' || $extension_bp ==='JPEG' || $extension_bp ==='PNG' || $extension_bp ==='png') {

        //FILE NAMING AND SAVING SETTINGS
                $file_name_custom_bp = 'warman_bp_'.$business->user_id.'_'.$business->id.'_'.$unix_timestamp.'.'.$extension_bp;

        // SAVING PROFILE PICTURE FILES
                $path_bp = $request->file('picture_file')->storeAs('public/businesses', $file_name_custom_bp);

                $picture = new Picture;
                $picture->user_id = $business->user_id;
                $picture->business_id = $business->id;
                $picture->category = 'business picture';
                $picture->name = $file_name_custom_bp;
                $picture->save();

            }else{
                return redirect()->route('tenant_business')->with('error', 'File Gambar Business Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah project!');
                
            }
        }
        $business->save();

        
        return redirect()->route('tenant_business')->with('status', 'Business berhasil diedit.');
    }

    public function business_delete(Business $business, Request $request)
    {
        
        Business::where('unique_id', $request->unique_id)->delete();

        return redirect()->route('tenant_business')->with('danger', 'Business berhasil didelete.');
    }


    public function product()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();
    
        return view('tenants.product', compact('products'));
    }

    public function product_create()
    {
        $user = Auth::user();
        
        $businesses = Business::where('user_id', $user->id)->get();
        return view('tenants.products.create', compact('businesses'));
    }

    public function product_store(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = Business::where('unique_id', $request->owner)->first();

        $product = New Product;
        $product->business_id = $business->id;
        $product->user_id = $business->user->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->subcategory = $request->subcategory;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->unique_id = $unix_timestamp;
        $product->save();

        //=====UPLOADING IMAGE=====
        // CHECK IF FILE GALLERY IS EXIST
        if ($request->hasFile('picture_file')) {
            $date = date_create();
            $unix_timestamp = date_timestamp_get($date);

        // PICTURES
            $extension_bp = $request->picture_file->extension();

        // CHECK IF FILE IS A PICTURE
            if ($extension_bp ==='jpeg' || $extension_bp ==='jpg' || $extension_bp ==='JPG' || $extension_bp ==='JPEG' || $extension_bp ==='PNG' || $extension_bp ==='png') {

        //FILE NAMING AND SAVING SETTINGS
                $file_name_custom_bp = 'warman_bp_'.$product->user_id.'_'.$product->id.'_'.$unix_timestamp.'.'.$extension_bp;

        // SAVING PROFILE PICTURE FILES
                $path_bp = $request->file('picture_file')->storeAs('public/products', $file_name_custom_bp);

                $picture = new Picture;
                $picture->user_id = $product->user_id;
                $picture->product_id = $product->id;
                $picture->category = 'product picture';
                $picture->name = $file_name_custom_bp;
                $picture->save();

            }else{
                return redirect()->route('tenant_product')->with('error', 'File Gambar Product Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah product!');
                
            }
        }
        
        return redirect()->route('tenant_product')->with('status', 'Product berhasil dibuat.');
    }

    public function product_edit(Product $product, Request $request)
    {
        $user = Auth::user();
        $businesses = Business::where('user_id', $user->id)->get();

        $product = Product::where('unique_id', $request->unique_id)->first();
        
        $pictures = Picture::where('product_id', $product->id)->get();
        
         return view('tenants.products.edit', compact('product', 'user', 'pictures', 'businesses'));
    }

    public function product_update(Request $request)
    {
        $product = Product::where('unique_id', $request->unique_id)->first();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category = $request->category;
        $product->subcategory = $request->subcategory;
        $product->status = $request->status;
        $product->description = $request->description;


        //=====UPLOADING IMAGE=====
        // CHECK IF FILE GALLERY IS EXIST
        if ($request->hasFile('picture_file')) {
            $date = date_create();
            $unix_timestamp = date_timestamp_get($date);

        // PICTURES
            $extension_pp = $request->picture_file->extension();

        // CHECK IF FILE IS A PICTURE
            if ($extension_pp ==='jpeg' || $extension_pp ==='jpg' || $extension_pp ==='JPG' || $extension_pp ==='JPEG' || $extension_pp ==='PNG' || $extension_pp ==='png') {

        //FILE NAMING AND SAVING SETTINGS
                $file_name_custom_pp = 'warman_pp_'.$product->user_id.'_'.$product->id.'_'.$unix_timestamp.'.'.$extension_pp;

        // SAVING PROFILE PICTURE FILES
                $path_pp = $request->file('picture_file')->storeAs('public/products', $file_name_custom_pp);

                $picture = new Picture;
                $picture->user_id = $product->user_id;
                $picture->business_id = $product->business_id;
                $picture->product_id = $product->id;
                $picture->category = 'product picture';
                $picture->name = $file_name_custom_pp;
                $picture->save();

            }else{
                return redirect()->route('tenant_product')->with('error', 'File Gambar Product Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah project!');
                
            }
        }
        $product->save();
        
        return redirect()->route('tenant_product')->with('status', 'Product berhasil diedit.');
    }

    public function product_delete(Product $product, Request $request)
    {
        
        Product::where('unique_id', $request->unique_id)->delete();

        return redirect()->route('tenant_product')->with('danger', 'Product berhasil didelete.');
    }

    public function order()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get()->sortByDesc('created_at');
        return view('tenants.order', compact('orders'));
    }

    public function invoice()
    {
        $user = Auth::user();
        $invoices = Invoice::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->get()->sortByDesc('created_at');
        return view('tenants.invoice', compact('invoices'));
    }

    public function report()
    {
        $user = Auth::user();
        $date_report = Carbon::today();
        $group = 'day(created_at)';
        $group_in = 'sum(amount) as sum,'.$group;
        $date_report_start = Carbon::today()->subDays(30)->toDateString();
        
        $subgroup= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))
            ->pluck('sum',$group);

            

            

        $invoices = Invoice::where('user_id', $user->id)->whereDate('created_at', Carbon::today())->get()->sortByDesc('created_at');
        return view('tenants.report', compact('invoices', 'date_report','subgroup'));
    }

    public function report_daily(Request $request)
    {
        $category = $request->category;
        
        $date_report =  $request->date_report;
        $user = Auth::user();
        
        if ($category == 'order') {
            $orders = Order::where('user_id', $user->id)->whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');
            
            return view('tenants.reports.orders.daily', compact('orders', 'date_report'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::where('user_id', $user->id)->whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');


            return view('tenants.reports.invoices.daily', compact('invoices', 'date_report'));
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
        
        $user = Auth::user();

        $group_user = 'user_id';
        $group_product = 'product_id';
            $group_in_user = 'sum(amount) as sum,'.$group_user;
            $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;

        if ($category == 'order') {
            $orders = Order::where('user_id', $user->id)->whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)->get()->sortByDesc('created_at');
            
            return view('tenants.reports.orders.monthly', compact('orders', 'month_report', 'year_report', 'monthName'));
        }elseif ($category == 'revenue') {
            $orders_groupBy_product= Order::where('user_id', $user->id)->whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)->groupBy($group_product)
            ->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;


            $invoices = Invoice::where('user_id', $user->id)->whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)->get()->sortByDesc('created_at');
            return view('tenants.reports.invoices.monthly', compact('invoices', 'month_report', 'year_report', 'monthName', 'orders_groupBy_product'));
        }
    }

    public function report_periodic(Request $request)
    {
        $category = $request->category;
        
        $date_report_start =  $request->date_report_start;
        $date_report_end =  $request->date_report_end;
        
        $user = Auth::user();

        $group_user = 'user_id';
        $group_product = 'product_id';
            $group_in_user = 'sum(amount) as sum,'.$group_user;
            $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;

        if ($category == 'order') {
            $orders = Order::where('user_id', $user->id)->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            return view('tenants.reports.orders.periodic', compact('orders', 'date_report'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::where('user_id', $user->id)->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');

            $orders_groupBy_product= Order::where('user_id', $user->id)->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_product)
            ->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            return view('tenants.reports.invoices.periodic', compact('invoices', 'date_report_start', 'date_report_end', 'monthName', 'orders_groupBy_product'));
        }
    }

    public function order_submit(Request $request){
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

       foreach ($data_order_json as $item) {
            $invoice_description .= $item->totalQuantity."pcs ".$item->name." ".$item->notes.",";
            $product = Product::where('unique_id', $item->id)->first();
            $order =  new Order;
            $order->user_id = $user->id;
            $order->business_id = $product->business->id;
            $order->product_id = $product->id;
            $order->quantity = $item->totalQuantity;
            $order->price = $item->totalPrice;
            $order->guest_name = $customerInfo;
            $order->status = 'order';
            $order->description = $item->notes;
            $order->booking_id = $confirmationCode;
            $order->unique_id = $user->id.$unix_timestamp; 
            $order->info_1 = $product->name;
            $order->info_2 = $product->price;
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
        $invoice->save();
        
        return view('tenants.confirm', compact('confirmationCode', 'customerInfo'))->with('status', 'Pesanan berhasil dibuat');
    }


    public function tenant_card_index()
    {
       
        return view('tenants.cards.index');
    }

    public function tenant_card_order(Request $request)
    {
        $card_number_qr = $request->card_number_qr;
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get()->sortBy("name");
        return view('tenants.cards.order', compact('products', 'card_number_qr'));
    }

    public function tenant_card_store(Request $request)
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
            $order->info_1 = $product->name;
            $order->info_2 = $product->price;
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
        
        return view('tenants.cards.confirm', compact('confirmationCode', 'customerInfo'))->with('status', 'Pesanan berhasil dibuat');
    }
}

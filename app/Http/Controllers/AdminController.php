<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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



use DB;
use DateTime;

use Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use File;
class AdminController extends Controller
{
    public function index()
    {
        $users = User::All();
        $businesses = Business::All();
        $orders = Order::All();
        $invoices = Invoice::All();
        $products = Product::All();
        return view('admins.index', compact('users', 'orders', 'invoices', 'products', 'businesses'));
    }

    public function user()
    {
        $users = User::all(); 
        return view('admins.user', compact('users'));
    }



    public function user_create()
    {
        return view('admins.users.create');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:8|max:16',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }



    public function user_store(Request $request)
    {
        // return $request;
        $this->validator($request->all())->validate();

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'unique_id' => $unix_timestamp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin_user')->with('status', 'User berhasil dibuat.');
    }


    public function user_show(User $user)
    {
        $user_id = Auth::user()->id;
        $user = User::where('unique_id', $user_id)->first();

        return view('admins.users.show', compact('user'));
    }

    public function user_edit(User $user, Request $request)
    {

        $item = User::where('unique_id', $request->user_id)->first();

        return view('admins.users.edit', compact('item'));
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

        return redirect()->route('admin_user')->with('status', 'User berhasil diedit.');
    }

    public function user_delete(User $user, Request $request)
    {

        User::where('unique_id', $request->user_id)->delete();

        return redirect()->route('admin_user')->with('danger', 'User berhasil didelete.');
    }

    public function user_reset_password(Request $request)
    {
        $item = User::where('unique_id', $request->user_id)->first();
        return view('admins.users.reset', compact('item'));
    }

    public function user_reset_password_submit(Request $request)
    {
        $user = User::where('unique_id', $request->user_id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('admin_user')->with('status', 'Password User berhasil direset.');
    }
    
    public function business()
    {
        $businesses = Business::All();
        return view('admins.business', compact('businesses'));
    }

    public function business_create()
    {
        $users = User::All();
        return view('admins.businesses.create', compact('users'));
    }

    public function business_store(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = New Business;
        $business->user_id = $request->owner;
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
                return redirect()->route('admin_business')->with('error', 'File Gambar Business Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah project!');
                
            }
        }

        return redirect()->route('admin_business')->with('status', 'Business berhasil dibuat.');
    }

    public function business_edit(Business $business, Request $request)
    {

        $business = Business::where('unique_id', $request->unique_id)->first();
        $users = User::all(); 
        $picture = Picture::where('business_id', $business->id)->latest()->first();
        
        return view('admins.businesses.edit', compact('business', 'users', 'picture'));
    }

    public function business_update(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = Business::where('unique_id', $request->unique_id)->first();
        $business->user_id = $request->owner;
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
                return redirect()->route('admin_business')->with('error', 'File Gambar Business Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah project!');
                
            }
        }
        $business->save();

        
        return redirect()->route('admin_business')->with('status', 'Business berhasil diedit.');
    }

    public function business_delete(Business $business, Request $request)
    {

        Business::where('unique_id', $request->unique_id)->delete();

        return redirect()->route('admin_business')->with('danger', 'Business berhasil didelete.');
    }

    public function category()
    {
        $categories = Category::All();

        return view('admins.category', compact('categories'));
    }

    public function category_create()
    {
        $businesses = Business::All();
        return view('admins.categories.create', compact('businesses'));
    }

    public function category_store(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = Business::where('unique_id', $request->owner)->first();

        $category = New Category;
        $category->business_id = $business->id;
        $category->user_id = $business->user->id;
        $category->name = $request->name;
        $category->status = $request->status;
        $category->description = $request->description;
        $category->unique_id = $unix_timestamp;
        $category->save();

        return redirect()->route('admin_category')->with('status', 'Category berhasil dibuat.');
    }

    public function category_edit(Category $category, Request $request)
    {
        $businesses = Business::All();
        $category = Category::where('unique_id', $request->unique_id)->first();
        $users = User::all(); 
        
        return view('admins.categories.edit', compact('category', 'users', 'businesses'));
    }

    public function category_update(Request $request)
    {
        $business = Business::where('unique_id', $request->owner)->first();
        $category = Category::where('unique_id', $request->unique_id)->first();
        $category->name = $request->name;
        $category->business_id = $business->id;
        $category->user_id = $business->user->id;
        $category->status = $request->status;
        $category->description = $request->description;

        $category->save();

        
        return redirect()->route('admin_category')->with('status', 'Category berhasil diedit.');
    }

    public function category_delete(Category $category, Request $request)
    {

        Category::where('unique_id', $request->unique_id)->delete();

        return redirect()->route('admin_category')->with('danger', 'Category berhasil didelete.');
    }

    public function product()
    {
        // $products = Product::orderBy('created_at','DESC')->paginate(50);
        $products = Product::orderBy('name','ASC')->paginate(50);

        return view('admins.product', compact('products'));
    }

    public function product_search(Request $request)
    {
        $q = $request->q;
            $products = Product::orderBy('created_at','DESC')->where('name','LIKE','%'.$q.'%')->get();
            if(count($products) > 0)
                return view('admins.products.search', compact('products'));
            else 
            return view('admins.products.search')->with('products', $products)->with('danger', 'Nama produk tidak ada, coba kata kunci lain');
    }

    public function product_create()
    {
        $businesses = Business::All();
        $categories = Category::where('parent','!=' ,0)->get();
        return view('admins.products.create', compact('businesses', 'categories'));
    }

    public function product_store(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $business = Business::where('unique_id', $request->owner)->first();
        $category = Category::where('unique_id', $request->category_detail)->first();

        $product = New Product;
        $product->business_id = $business->id;
        $product->user_id = $business->user->id;
        $product->category_id = $category->id;
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->variation = $request->variation;
        $product->retail_unit = $request->retail_unit;
        $product->bulk_unit = $request->bulk_unit;
        $product->bulk_to_retail = $request->bulk_to_retail;
        $product->buying_price = $request->buying_price;
        $product->price = $request->price;
        $product->category_id = $request->subcategory;
        $product->subcategory = $request->subcategory;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->unique_id = $unix_timestamp;

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
                // $file_name_custom_bp = 'warman_bp_'.$product->user_id.'_'.$product->id.'_'.$unix_timestamp.'.'.$extension_bp;
                $file_name_custom_pp = $request->picture_file->getClientOriginalName();
        // SAVING PROFILE PICTURE FILES
                $path_bp = $request->file('picture_file')->storeAs('public/products', $file_name_custom_pp);
                

                $picture = new Picture;
                $picture->user_id = $product->user_id;
                $picture->product_id = $product->id;
                $picture->category = 'product picture';
                $picture->name = $file_name_custom_pp;
                $picture->save();
                $product->image = "storage/products/".$file_name_custom_pp;

            }else{
                return redirect()->route('admin_product')->with('error', 'File Gambar Product Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah product!');
                
            }
        }
        $product->save();
        
        return redirect()->route('admin_product')->with('status', 'Product berhasil dibuat.');
    }

    public function product_edit(Product $product, Request $request)
    {
        $businesses = Business::where('category','supplier')->get();
        $categories = Category::where('parent','!=' ,0)->get();
        $product = Product::where('id', $request->id)->first();
        
        $users = User::where('role','supplier')->get(); 
        $pictures = Picture::where('product_id', $product->id)->get();
        // return $categories;
        // return $product->category;
        
        return view('admins.products.edit', compact('product', 'users', 'pictures', 'businesses', 'categories'));
    }

    public function product_activate(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $product->status = "active";
        $product->save();
        return redirect()->route('admin_product')->with('status', 'Product berhasil di aktivasi.');
    }

    public function product_deactivate(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $product->status = "non active";
        $product->save();
        return redirect()->route('admin_product')->with('status', 'Product berhasil di non aktifkan.');
    }

    public function product_update(Request $request)
    {

        $product = Product::where('id', $request->id)->first();
        $business = Business::where('id', $request->owner)->first();
        
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->variation = $request->variation;
        $product->retail_unit = $request->retail_unit;
        $product->bulk_unit = $request->bulk_unit;
        $product->bulk_to_retail = $request->bulk_to_retail;
        $product->business_id = $request->owner;
        $product->user_id = $business->user_id;
        $product->buying_price = $request->buying_price;
        $product->price = $request->price;
        $product->category_id = $request->subcategory;
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
                // $file_name_custom_pp = 'warman_pp_'.$product->user_id.'_'.$product->id.'_'.$unix_timestamp.'.'.$extension_pp;
                $file_name_custom_pp ="";
                $file_name_custom_pp = $request->picture_file->getClientOriginalName();

        // SAVING PROFILE PICTURE FILES
                $path_pp = $request->file('picture_file')->storeAs('public/products', $file_name_custom_pp);


                $picture = new Picture;
                $picture->user_id = $product->user_id;
                $picture->business_id = $product->business_id;
                $picture->product_id = $product->id;
                $picture->category = 'product picture';
                $picture->name = $file_name_custom_pp;
                $picture->save();
                $product->image = "storage/products/".$file_name_custom_pp;

            }else{
                return redirect()->route('admin_product')->with('error', 'File Gambar Product Anda Bukan Berupa Gambar.', 'Silahkan ulangi edit produk!');
                
            }
        }

        $product->save();
        
        return redirect()->route('admin_product')->with('status', 'Product berhasil diedit.');
    }

    public function product_delete(Product $product, Request $request)
    {

        Product::where('id', $request->id)->delete();

        return redirect()->route('admin_product')->with('danger', 'Product berhasil didelete.');
    }

    public function order()
    {
        $orders = Order::all()->sortByDesc('created_at');
        
        return view('admins.order', compact('orders'));
    }

    public function invoice()
    {
        $invoices = Invoice::all()->sortByDesc('created_at');
        $invoices_unpaid = Invoice::where('status', 'unpaid')->get()->sortByDesc('created_at');
        $invoices_paid = Invoice::where('status', 'paid')->get()->sortByDesc('created_at');
        return view('admins.invoice', compact('invoices', 'invoices_unpaid', 'invoices_paid'));
    }

    public function admin_invoice_cancel(Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $invoice->status = 'cancel';
        $invoice->save();

        $orders = Order::where('unique_id', $request->unique_id)->get();
        foreach ($orders as $item) {
            $item->status = 'cancel';
            $item->save();
        }
        return redirect()->route('admin_invoice')->with('danger', 'Invoice berhasil dicancel.');
    }

    public function admin_invoice_paid(Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $invoice->status = 'paid';
        $invoice->save();

        $orders = Order::where('unique_id', $request->unique_id)->get();
        foreach ($orders as $item) {
            $item->status = 'paid';
            $item->save();

            $campaign = Campaign::where('id', $item->campaign_id)->first();
            $campaign->amount_ordered += $item->price;
            $campaign->quantity_ordered += $item->quantity;
            $campaign->save();
        }
        return redirect()->route('admin_invoice')->with('danger', 'Invoice berhasil di paid.');
    }

    public function admin_invoice_discount()
    {
        $invoices = Invoice::where('status','waiting approval')->orderBy('created_at','DESC')->get();
        return view('admins.discount', compact('invoices'));
    }

    public function admin_invoice_approve(Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $invoice->status = 'unpaid';
        $invoice->save();
        return redirect()->route('admin_invoice_discount')->with('success', 'Discount berhasil disetujui.');
    }

    public function admin_invoice_reject(Request $request)
    {
        $invoice = Invoice::where('unique_id', $request->unique_id)->first();
        $invoice->discount = 0;
        $invoice->status = 'unpaid';
        $invoice->save();
        return redirect()->route('admin_invoice_discount')->with('success', 'Discount ditolak.');
    }
    

    public function payment()
    {
        $payments = Payment::all();
        return view('admins.payment', compact('payments'));
    }

    public function payment_create()
    {
        return view('admins.payments.create');
    }

    public function payment_store(Payment $payment, Request $request)
    {
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $payment = New Payment;
        $payment->name = $request->name;
        $payment->category = $request->category;
        $payment->description = $request->description;

        $payment->unique_id = $unix_timestamp;

        $payment->save();

        return redirect()->route('admin_payment')->with('status', 'Payment berhasil dibuat.');
    }

    public function payment_edit(Payment $payment, Request $request)
    {
        $payment = Payment::where('unique_id', $request->unique_id)->first();
        
        return view('admins.payments.edit', compact('payment'));
    }

    public function payment_update(Payment $payment, Request $request)
    {
        $payment = Payment::where('unique_id', $request->unique_id)->first();
        $payment->name = $request->name;
        $payment->category = $request->category;
        $payment->description = $request->description;

        $payment->save();
        
        return redirect()->route('admin_payment')->with('status', 'Payment berhasil diedit.');
    }

    public function payment_delete(Payment $payment, Request $request)
    {
        Payment::where('unique_id', $request->unique_id)->delete();

        return redirect()->route('admin_payment')->with('danger', 'Payment berhasil didelete.');
        
    }

    public function report()
    {
        return view('admins.report');
    }

    public function report_daily(Request $request)
    {
       
        $category = $request->category;
        
        $date_report =  $request->date_report;

        $group_user = 'user_id';
        $group_product = 'product_id';
        $group_supplier = 'supplier_id';
        $group_business = 'business_id';

            $group_in_user = 'sum(amount) as sum,'.$group_user;
            $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;
            $group_in_supplier = 'sum(price) as sum,sum(quantity) as quantity,'.$group_supplier;
            $group_in_business = 'sum(price) as sum,sum(quantity) as quantity,'.$group_business;
        
        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->get()->sortByDesc('created_at');
            
            foreach ($orders as $item) {
                if(Invoice::where('booking_id', $item->booking_id)->first()->status=='paid'){
                    $item->status = 'paid';
                    $item->save();
                }
                $item->save();
            }
            $orders_groupBy_product= Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->groupBy($group_product)->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            $orders_groupBy_supplier= Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->groupBy($group_supplier)->selectRaw($group_in_supplier)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            $orders_groupBy_business= Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->groupBy($group_business)->selectRaw($group_in_business)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            return view('admins.reports.orders.daily', compact('orders', 'date_report', 'orders_groupBy_product', 'orders_groupBy_supplier', 'orders_groupBy_business'));
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


            return view('admins.reports.invoices.daily', compact('invoices', 'date_report', 'invoices_groupBy_tenant'));
        }
    }

    public function report_daily_supplier_order(Request $request)
    {
        $supplier_id = $request->business_id;
        $date_report =  $request->date_report;

        $group_supplier = 'business_id';

        $group_in_supplier = 'sum(price) as sum,sum(quantity) as quantity,'.$group_supplier;
        
           
            $supplier = Business::where('category', "supplier")->with("order")->get();

            $table_product = DB::table('products')->select('id','name')->get();
            $table_business = DB::table('businesses')->where('category', 'supplier')->select('id','name','category')->get();
            $table_order = DB::table('orders')->where('status', 'paid')->select('id','status','quantity','price')->get();
            
            $orders_groupBy_supplier= Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->groupBy($group_supplier)->selectRaw($group_in_supplier)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid'], ['supplier_id', $request->business_id]])
                ->get()
            ;
            
            return view('admins.reports.orders.daily_supplier', compact('supplier_id', 'date_report', 'orders_groupBy_supplier'));
    }

    public function report_daily_cooperative_order(Request $request)
    {
        $business_id = $request->business_id;
        $date_report =  $request->date_report;

        $group_product = ['product_id','campaign_id'];

        $group_in_product = 'sum(price) as sum,sum(quantity) as quantity, product_id, campaign_id';

        

        $orders_groupBy_product= Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->groupBy($group_product)->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid'], ['business_id', $business_id]])
                ->get()
            ;

            
        
           
            
            return view('admins.reports.orders.daily_cooperative', compact('business_id', 'date_report', 'orders_groupBy_product'));
    }

    

    public function report_daily_supplier_order_cooperative(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $business_id = $request->business_id;
        $date_report =  $request->date_report;

        $group_product = 'product_id';

        $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;
        
           
            $supplier = Business::where('category', "supplier")->with("order")->get();

            $table_product = DB::table('products')->select('id','name')->get();
            $table_business = DB::table('businesses')->where('category', 'supplier')->select('id','name','category')->get();
            $table_order = DB::table('orders')->where('status', 'paid')->select('id','status','quantity','price')->get();
            
            $orders_groupBy_product= Order::whereDate('created_at', '=', date('Y-m-d H:i:s', strtotime($date_report)))->groupBy($group_product)->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid'], ['supplier_id', $request->supplier_id], ['business_id', $request->business_id]])
                ->get()
            ;
            
            return view('admins.reports.orders.daily_supplier_cooperative', compact('supplier_id', 'business_id', 'date_report', 'orders_groupBy_product'));
    }

    

    public function report_weekly(Request $request)
    {

        $date_report = $request->date_report;
        $day_request = date("d", strtotime($date_report));
        $week_request = date("W", strtotime($date_report));
        $month_request = date("m", strtotime($date_report));
        $year_request = date("Y", strtotime($date_report));
        
        $week = (int)$week_request;
        $month = (int)$month_request;
        $year = (int)$year_request;

        $date_report_start = Carbon\Carbon::createFromDate($year_request, $month_request, $day_request)->startOfWeek()->toDateString();
        $date_report_end = Carbon\Carbon::createFromDate($year_request, $month_request, $day_request)->endOfWeek()->toDateString();

        $group_user = 'user_id';
        $group_product = 'product_id';
        $group_supplier = 'supplier_id';
        $group_business = 'business_id';

            $group_in_user = 'sum(amount) as sum,'.$group_user;
            $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;
            $group_in_supplier = 'sum(price) as sum,sum(quantity) as quantity,'.$group_supplier;
            $group_in_business = 'sum(price) as sum,sum(quantity) as quantity,'.$group_business;
        
        
        $category = $request->category;
        
        $monthNum  = $month;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');

        $group = 'user_id';
            $group_in = 'sum(amount) as sum,'.$group;
            $invoices_groupBy_tenant= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->pluck('sum',$group);


        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');

            $orders_groupBy_product= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_product)
            ->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            $orders_groupBy_supplier= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_supplier)->selectRaw($group_in_supplier)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            $orders_groupBy_business= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_business)->selectRaw($group_in_business)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;
            
            return view('admins.reports.orders.periodic', compact('orders', 'date_report_start', 'date_report_end','orders_groupBy_product', 'orders_groupBy_supplier', 'orders_groupBy_business'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            return view('admins.reports.invoices.periodic', compact('invoices', 'date_report_start', 'date_report_end', 'invoices_groupBy_tenant'));
        }
    }

    public function report_periodic_cooperative_order(Request $request)
    {
        $business_id = $request->business_id;
        $date_report_start =  $request->date_report_start;
        $date_report_end =  $request->date_report_end;

        $group_product = ['product_id','campaign_id'];

        $group_in_product = 'sum(price) as sum,sum(quantity) as quantity, product_id, campaign_id';

        $orders_groupBy_product= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_product)->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid'], ['business_id', $business_id]])
                ->get()
            ;
        
           
            
            return view('admins.reports.orders.periodic_cooperative', compact('business_id', 'date_report_start', 'date_report_end', 'orders_groupBy_product'));
    }

    public function report_periodic_supplier_order(Request $request)
    {
        $supplier_id = $request->business_id;

        $date_report_start = $request->date_report_start;
        $date_report_end = $request->date_report_end;

        $group_supplier = 'business_id';

        $group_in_supplier = 'sum(price) as sum,sum(quantity) as quantity,'.$group_supplier;
        
           
            $supplier = Business::where('category', "supplier")->with("order")->get();

            $table_product = DB::table('products')->select('id','name')->get();
            $table_business = DB::table('businesses')->where('category', 'supplier')->select('id','name','category')->get();
            $table_order = DB::table('orders')->where('status', 'paid')->select('id','status','quantity','price')->get();
            
            $orders_groupBy_supplier= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_supplier)->selectRaw($group_in_supplier)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid'], ['supplier_id', $request->business_id]])
                ->get()
            ;
            
            return view('admins.reports.orders.periodic_supplier', compact('supplier_id', 'date_report_start', 'date_report_end','orders_groupBy_supplier'));
    }

    public function report_periodic_supplier_order_cooperative(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $business_id = $request->business_id;
        $date_report_start = $request->date_report_start;
        $date_report_end = $request->date_report_end;

        $group_product = 'product_id';

        $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;
        
           
            $supplier = Business::where('category', "supplier")->with("order")->get();

            $table_product = DB::table('products')->select('id','name')->get();
            $table_business = DB::table('businesses')->where('category', 'supplier')->select('id','name','category')->get();
            $table_order = DB::table('orders')->where('status', 'paid')->select('id','status','quantity','price')->get();
            
            $orders_groupBy_product= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_product)->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid'], ['supplier_id', $request->supplier_id], ['business_id', $request->business_id]])
                ->get()
            ;
            
            return view('admins.reports.orders.periodic_supplier_cooperative', compact('supplier_id', 'business_id',  'date_report_start', 'date_report_end', 'orders_groupBy_product'));
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
            
            $group = 'day(created_at)';
            $group_in = 'sum(quantity) as sum,'.$group;
            $subgroup= Order::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereMonth('created_at', '=', $month_report)
            ->whereYear('created_at', '=', $year_report)
            ->pluck('sum',$group);

            // return $subgroup;
            return view('admins.reports.orders.monthly', compact('orders', 'month_report', 'year_report', 'monthName', 'subgroup'));
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
             ->whereMonth('created_at', '=', $month_report)
            ->whereYear('created_at', '=', $year_report)
            ->pluck('sum',$group);

            return view('admins.reports.invoices.monthly', compact('invoices', 'month_report', 'year_report', 'monthName', 'subgroup', 'invoices_groupBy_tenant'));
        }
    }


    public function report_yearly(Request $request)
    {
        $category = $request->category;
        
        

        $month_report =  $request->month_report;

        $year_report =  $request->year_report;
        
        if ($category == 'order') {
            $orders = Order::whereMonth('created_at', '=', $month_report)->whereYear('created_at', '=', $year_report)->get()->sortByDesc('created_at');
            


            return view('admins.reports.orders.yearly', compact('orders', 'month_report', 'year_report', 'monthName', 'subgroup'));
        }elseif ($category == 'revenue') {
            $invoices = Invoice::whereYear('created_at', '=', $year_report)->get()->sortByDesc('created_at');

            $group = 'month(created_at)';
            $group_in = 'sum(amount) as sum,'.$group;
            $subgroup= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereYear('created_at', '=', $year_report)
            ->pluck('sum',$group);


            $group = 'user_id';
            $group_in = 'sum(amount) as sum,'.$group;
            $invoices_groupBy_tenant= Invoice::groupBy($group)
            ->selectRaw($group_in)
            ->where([
                ['status', 'paid']])
            ->whereYear('created_at', '=', $year_report)
            ->pluck('sum',$group);

            return view('admins.reports.invoices.yearly', compact('invoices', 'month_report', 'year_report', 'monthName', 'subgroup', 'invoices_groupBy_tenant'));
        }
    }
    public function report_periodic(Request $request)
    {
        $category = $request->category;
        
        $date_report_start =  $request->date_report_start;
        $date_report_end =  $request->date_report_end;

        $group_user = 'user_id';
        $group_product = 'product_id';
        $group_supplier = 'supplier_id';
        $group_business = 'business_id';

            $group_in_user = 'sum(amount) as sum,'.$group_user;
            $group_in_product = 'sum(price) as sum,sum(quantity) as quantity,'.$group_product;
            $group_in_supplier = 'sum(price) as sum,sum(quantity) as quantity,'.$group_supplier;
            $group_in_business = 'sum(price) as sum,sum(quantity) as quantity,'.$group_business;
            

            
        
        if ($category == 'order') {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            foreach ($orders as $item) {
                if(Invoice::where('booking_id', $item->booking_id)->first()->status=='paid'){
                    $item->status = 'paid';
                    $item->save();
                }
                $item->save();
            }
           
            
            $orders_groupBy_product= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_product)
            ->selectRaw($group_in_product)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            $orders_groupBy_business= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_business)->selectRaw($group_in_business)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            $orders_groupBy_supplier= Order::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->groupBy($group_supplier)->selectRaw($group_in_supplier)
            ->orderByRaw('sum DESC')
            ->where([
                ['status', 'paid']])
                ->get()
            ;

            return view('admins.reports.orders.periodic', compact('orders', 'date_report_start', 'date_report_end', 'orders_groupBy_product', 'orders_groupBy_business', 'orders_groupBy_supplier'));
        }elseif ($category == 'revenue') {
            $invoices_groupBy_tenant= Invoice::groupBy($group_user)
            ->selectRaw($group_in_user)
            ->where([
                ['status', 'paid']])
            ->whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))
            ->pluck('sum',$group_user);
            $invoices = Invoice::whereDate('created_at', '>=', date('Y-m-d H:i:s', strtotime($date_report_start)))->whereDate('created_at', '<=', date('Y-m-d H:i:s', strtotime($date_report_end)))->get()->sortByDesc('created_at');
            
            return view('admins.reports.invoices.periodic', compact('invoices', 'date_report_start', 'date_report_end', 'invoices_groupBy_tenant'));
        }
    }
}
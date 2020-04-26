<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResource;
use App\User;
use App\Business;
use App\Campaign;
use App\Category;
use App\Invoice;
use App\Order;
use App\Payment;
use App\Picture;
use App\Product;
use App\Report;
use DB;
use DateTime;
use Carbon;


class CampaignController extends Controller
{
    public function campaign()
    {
        $campaigns = Campaign::orderBy('created_at','DESC')->paginate(50);

        return view('admins.campaign', compact('campaigns'));
    }

    public function campaign_search(Request $request)
    {
        $q = $request->q;
            $campaigns = Campaign::orderBy('created_at','DESC')->where('name','LIKE','%'.$q.'%')->get();
            if(count($campaigns) > 0)
                return view('admins.campaigns.search', compact('campaigns'));
            else 
            return view('admins.campaigns.search')->with('campaigns', $campaigns)->with('danger', 'Nama produk tidak ada, coba kata kunci lain');
    }

    public function campaign_create()
    {
        $users = User::All();
        $businesses = Business::All();
        $categories = Category::All();
        $products = Product::All();
        return view('admins.campaigns.create', compact('businesses', 'categories', 'products', 'users'));
    }

    public function campaign_store(Request $request)
    {

        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        $product = Product::where('unique_id', $request->product_id)->first();
        

        $campaign = New Campaign;
        $campaign->unique_id = $unix_timestamp;
        $campaign->product_id = $product->id;
        $campaign->user_id = $product->user["id"];
        $campaign->business_id = $product->business["id"];
        $campaign->title = $request->title;
        $campaign->status = $request->status;
        $campaign->product_initial_price = $request->product_initial_price;
        $campaign->product_tiering_price_1 = $request->product_tiering_price_1;
        $campaign->product_tiering_quota_1 = $request->product_tiering_quota_1;
        $campaign->product_tiering_max = $request->product_tiering_max;
        $campaign->start_at = $request->start_at;
        $campaign->end_at = $request->end_at;
        $campaign->save();
        
        return redirect()->route('admin_campaign')->with('status', 'Campaign berhasil dibuat.');
    }

    public function campaign_edit(Product $product, Request $request)
    {
        $businesses = Business::All();
        $product = Product::where('unique_id', $request->unique_id)->first();
        
        $users = User::all(); 
        $pictures = Picture::where('product_id', $product->id)->get();
        
        return view('admins.products.edit', compact('product', 'users', 'pictures', 'businesses'));
    }

    public function campaign_activate(Request $request)
    {
        $product = Product::where('unique_id', $request->unique_id)->first();
        $product->status = "active";
        $product->save();
        return redirect()->route('admin_product')->with('status', 'Product berhasil di aktivasi.');
    }

    public function campaign_deactivate(Request $request)
    {
        $product = Product::where('unique_id', $request->unique_id)->first();
        $product->status = "non active";
        $product->save();
        return redirect()->route('admin_product')->with('status', 'Product berhasil di non aktifkan.');
    }

    public function campaign_update(Request $request)
    {

        $product = Product::where('unique_id', $request->unique_id)->first();
        $business = Business::where('id', $request->owner)->first();
        
        $product->name = $request->name;
        $product->business_id = $request->owner;
        $product->user_id = $business->user_id;
        $product->price = $request->price;
        $product->category = $request->category;
        
        $product->status = $request->status;
        $product->description = $request->description;

        $product->save();

        
        return redirect()->route('admin_product')->with('status', 'Product berhasil diedit.');
    }

    public function campaign_delete(Product $product, Request $request)
    {

        Product::where('unique_id', $request->unique_id)->delete();

        return redirect()->route('admin_product')->with('danger', 'Product berhasil didelete.');
    }

    public function toArray($request)
{
    return [
        'product' => ProductResource::collection($this->product),
    ];
}
}

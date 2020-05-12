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
        $campaign->unit = $request->unit;
        $campaign->product_initial_price = $request->product_initial_price;
        $campaign->product_tiering_price_1 = $request->product_tiering_price_1;
        $campaign->product_tiering_quota_1 = $request->product_tiering_quota_1;
        $campaign->product_tiering_price_2 = $request->product_tiering_price_2;
        $campaign->product_tiering_quota_2 = $request->product_tiering_quota_2;
        $campaign->product_tiering_price_3 = $request->product_tiering_price_3;
        $campaign->product_tiering_quota_3 = $request->product_tiering_quota_3;
        $campaign->product_tiering_max = $request->product_tiering_max;
        $campaign->start_at = $request->start_at;
        $campaign->end_at = $request->end_at;

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
               
                $file_name_custom_bp = $request->picture_file->getClientOriginalName();
        // SAVING PROFILE PICTURE FILES
                $path_bp = $request->file('picture_file')->storeAs('public/campaigns', $file_name_custom_bp);
                

                $picture = new Picture;
                $picture->user_id = $product->user_id;
                $picture->product_id = $product->id;
                $picture->category = 'campaign picture';
                $picture->name = $file_name_custom_bp;
                $picture->save();
                $campaign->image = "storage/campaigns/".$file_name_custom_bp;

            }else{
                return redirect()->route('admin_campaign')->with('error', 'File Gambar Product Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah product!');
                
            }
        }

        $campaign->save();
        
        return redirect()->route('admin_campaign')->with('status', 'Campaign berhasil dibuat.');
    }

    public function campaign_edit(Campaign $campaign, Request $request)
    {

        // return $request->unique_id;
        $businesses = Business::All();
        $products = Product::All();
        $campaign = Campaign::where('unique_id', $request->unique_id)->first();
        // return $campaign;
        
        return view('admins.campaigns.edit', compact('campaign','businesses', 'products'));
    }

    public function campaign_activate(Request $request)
    {
        $campaign = Campaign::where('unique_id', $request->unique_id)->first();
        $campaign->status = "active";
        $campaign->save();
        return redirect()->route('admin_campaign')->with('status', 'Campaign berhasil di aktivasi.');
    }

    public function campaign_deactivate(Request $request)
    {
        $campaign = Campaign::where('unique_id', $request->unique_id)->first();
        $campaign->status = "non active";
        $campaign->save();
        return redirect()->route('admin_campaign')->with('status', 'Campaign berhasil di non aktifkan.');
    }

    public function campaign_update(Request $request)
    {
        $product = Product::where('unique_id', $request->product_id)->first();
        $campaign = Campaign::where('unique_id', $request->unique_id)->first();

        $campaign->product_id = $product->id;
        $campaign->user_id = $product->user["id"];
        $campaign->business_id = $product->business["id"];
        $campaign->title = $request->title;
        $campaign->status = $request->status;
        $campaign->unit = $request->unit;
        $campaign->product_initial_price = $request->product_initial_price;
        $campaign->product_tiering_price_1 = $request->product_tiering_price_1;
        $campaign->product_tiering_quota_1 = $request->product_tiering_quota_1;
        $campaign->product_tiering_price_2 = $request->product_tiering_price_2;
        $campaign->product_tiering_quota_2 = $request->product_tiering_quota_2;
        $campaign->product_tiering_price_3 = $request->product_tiering_price_3;
        $campaign->product_tiering_quota_3 = $request->product_tiering_quota_3;
        $campaign->product_tiering_max = $request->product_tiering_max;

        if($request->start_at != ""){
            
            $campaign->start_at = $request->start_at;
        }

        if($request->end_at != ""){
            $campaign->end_at = $request->end_at;
        }

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
               
                $file_name_custom_bp = $request->picture_file->getClientOriginalName();
        // SAVING PROFILE PICTURE FILES
                $path_bp = $request->file('picture_file')->storeAs('public/campaigns', $file_name_custom_bp);
                

                $picture = new Picture;
                $picture->user_id = $product->user_id;
                $picture->product_id = $product->id;
                $picture->category = 'campaign picture';
                $picture->name = $file_name_custom_bp;
                $picture->save();
                $campaign->image = "storage/campaigns/".$file_name_custom_bp;

            }else{
                return redirect()->route('admin_campaign')->with('error', 'File Gambar Product Anda Bukan Berupa Gambar.', 'Silahkan ulangi tambah product!');
                
            }
        }
        
        $campaign->save();

        return redirect()->route('admin_campaign')->with('status', 'Campaign berhasil diedit.');
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

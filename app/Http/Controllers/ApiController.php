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
use App\Inventory;
use App\InventoryHistory;



use App\Test;
use DB;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Zendesk;

class ApiController extends Controller
{

    public function getTicket()
    {
       // Get all tickets
        $tickets = Zendesk::tickets()->findAll();
        return response()->json($tickets);
        
    }

    public function createTicket()
    {
       /// Create a new ticket
        Zendesk::tickets()->create([
            'subject' => 'Subject',
            'comment' => [
                'body' => 'Ticket content.'
            ],
            'priority' => 'normal'
        ]);
        return "success";
    }

    public function updateTicket()
    {
        // Update multiple tickets
        Zendesk::ticket([123, 456])->update([
            'status' => 'urgent'
        ]);
        return "success";
    }

    public function deleteTicket()
    {
        // Update multiple tickets
        // Delete a ticket
        Zendesk::ticket(123)->delete();
        return "success";
    }

    public function user()
    {
        $users = User::all(); 
        return response()->json($users);
    }

    public function businessSelected(Request $request, $unique_id)
    {
        $business = Business::where('unique_id', $unique_id)->first(); 
        return response()->json($business);
    }

    public function login(Request $request){
        return 'success';
    }


    public function product()
    {
        $products = Product::where('status', 'active')->paginate(50);
        return response()->json($products);
    }

    public function productCategory($id)
    {
         $categories = Category::where('parent', $id)->get();
         $subcategory_ids = array();
        foreach ($categories as $item) {
            array_push($subcategory_ids,$item->id);
            }

        $products = Product::whereIn('category_id', $subcategory_ids)->where('status', 'active')->paginate(50);

        return response()->json($products);
    }

    public function productSearch($search)
    {
        $products = Product::where('name', 'LIKE', "%{$search}%")->where('status', 'active')->paginate(50);

        return response()->json($products);
    }

    public function category()
    {
        $categories = Category::where('parent', '0')->orderBy("id")->get();

        return response()->json($categories);
    }

    public function campaigns()
    {
        $now = Carbon::now();

        $campaigns = Campaign::orderBy('priority','DESC')->with(['product','business'])->where("end_at",">=", $now)->where('status', 'active')->get(); 
        return response()->json($campaigns);
    }

    public function campaignSearch($search)
    {
        $now = Carbon::now();
        $campaigns = Campaign::whereHas('product', function ($query) use($search){
            $query->where('name', 'LIKE', "%{$search}%");
        })->with(['product','business'])->where("end_at",">=", $now)->where('status', 'active')->get();
        return response()->json($campaigns);
    }

    public function campaignCategory($id)
    {
        $now = Carbon::now();
        $subcategory_ids = array();

        if($id == 2){
            //BECAUSE ONLY WHO DOESNT HAVE SUBCATEGORY
            $categories = 2;
            array_push($subcategory_ids,$categories);
        }else{
            $categories = Category::where('parent', $id)->get();
        foreach ($categories as $item) {
            array_push($subcategory_ids,$item->id);
            }
        }
        $campaigns = Campaign::whereHas('product', function ($query) use($id, $subcategory_ids){
            $query->whereIn('category_id', $subcategory_ids);
        })->with(['product', 'business'])->where("end_at",">=", $now)->where('status', 'active')->get();
        return response()->json($campaigns);
    }

    public function campaignsSelectedSupplier($unique_id)
    {
        $now = Carbon::now();

        $campaigns = Campaign::whereHas('business', function ($query) use($unique_id){
            $query->where('unique_id',  $unique_id);
        })->orderBy('priority','DESC')->with(['product','business'])->where("end_at",">=", $now)->where('status', 'active')->get(); 
        return response()->json($campaigns);
    }

    public function campaignSearchSelectedSupplier($search, $unique_id)
    {
        $now = Carbon::now();
        $campaigns = Campaign::whereHas('business', function ($query) use($unique_id){
            $query->where('unique_id',  $unique_id);
        })->whereHas('product', function ($query) use($search){
            $query->where('name', 'LIKE', "%{$search}%");
        })->with(['product', 'business'])->where("end_at",">=", $now)->where('status', 'active')->get();
        return response()->json($campaigns);
    }

    public function campaignCategorySelectedSupplier($id, $unique_id)
    {
        $now = Carbon::now();
        $subcategory_ids = array();

        if($id == 2){
            //BECAUSE ONLY WHO DOESNT HAVE SUBCATEGORY
            $categories = 2;
            array_push($subcategory_ids,$categories);
        }else{
            $categories = Category::where('parent', $id)->get();
        foreach ($categories as $item) {
            array_push($subcategory_ids,$item->id);
            }
        }
        
        $campaigns = Campaign::whereHas('business', function ($query) use($unique_id){
            $query->where('unique_id',  $unique_id);
        })->whereHas('product', function ($query) use($id, $subcategory_ids){
            $query->whereIn('category_id', $subcategory_ids);
        })->with(['product', 'business'])->where("end_at",">=", $now)->where('status', 'active')->get();
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

    public function inventory(Inventory $Inventory, $user_id)
    {   
    $inventory = Inventory::where('user_id', $user_id)->get();
    return response()->json($inventory);
    }

    public function inventoryHistory(InventoryHistory $InventoryHistory, $user_id, $product_id)
    {   
    $inventoryHistory = InventoryHistory::where('user_id', $user_id)->where('inventory_id', $product_id)->orderBy('created_at','DESC')->get();
    return response()->json($inventoryHistory);
    }

    public function inventoryHistoryReport(InventoryHistory $InventoryHistory, $user_id, $product_id)
    {   
    
    $inventoryHistoryReport = InventoryHistory::where('user_id', $user_id)->where('inventory_id', $product_id)->select(
        DB::raw('sum(quantity) as quantity'), 
        DB::raw('sum(amount)/sum(quantity) as average_price'),
        DB::raw('sum(amount) as amount'), 
        DB::raw("recorded_date as date")
        )
        ->groupBy('date')
        ->get();

        $inventory = Inventory::where('id', $product_id)->first();

        $obj_html = (object) array('html' => true);

        $obj = (object) array('role' => 'tooltip', 'type' => "string", 'p' => $obj_html);

        $reportRespond = array (
            array("tanggal","kuantitas", $obj),
        );

        foreach($inventoryHistoryReport as $x => $x_value) {
            $reportRespond[] = array(date('d M y',strtotime($x_value["date"])),intval($x_value["quantity"]), "<div class='chart-tooltip'><b>".date('d M y',strtotime($x_value["date"]))."</b><br/><b>Kuantitas:</b><br/>".number_format(intval($x_value["quantity"]),0,",",".")." ".$inventory->unit."<br/><b>Harga:</b><br/> Rp ".number_format(intval($x_value["average_price"]),0,",",".")."<br/> <b>Total:</b> <br/> Rp ".number_format(intval($x_value["amount"]),0,",",".")."</div>");
            
        }
        return response()->json($reportRespond);
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

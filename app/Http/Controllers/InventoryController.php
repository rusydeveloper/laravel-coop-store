<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\InventoryHistory;
use App\User;
use App\Business;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::orderBy('created_at','DESC')->paginate(50);

        return view('admins.inventory', compact('inventories'));
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
        $date = date_create();
        $unix_timestamp = date_timestamp_get($date);

        
        $user = User::where('id', $request->user_id)->first();

        // return response()->json([
        //     'message' => $user
        // ]);

        $business = Business::where('user_id', $request->user_id)->first();

        //Create inventory
        if($request->inventory_id === "new"){
        $inventory = New Inventory;
        $inventory->unique_id = $unix_timestamp;
        $inventory->business_id = $business->id;
        $inventory->user_id = $user->id;
        $inventory->name = $request->name;
        $inventory->brand = $request->brand;
        $inventory->unit = $request->unit;
        
        $inventory->status = "active";
        $inventory->balance = $request->quantity;
        $inventory->save();
    }else{
        $inventory = Inventory::where('id', $request->inventory_id)->first();

        $inventory->balance = $inventory->balance+$request->quantity;
        $inventory->save();

    }

        //Create inventory history
        $amount = $request->quantity*$request->price;
        
        $inventoryHistory = New InventoryHistory;
        $inventoryHistory->unique_id = $unix_timestamp;
        $inventoryHistory->business_id = $business->id;
        $inventoryHistory->user_id = $user->id;
        $inventoryHistory->inventory_id = $inventory->id;
        $inventoryHistory->status = "success";
        $inventoryHistory->type = "NEW";
        $inventoryHistory->quantity = $request->quantity;
        $inventoryHistory->price = $request->price;
        $inventoryHistory->recorded_date = $request->recorded_date;
        $inventoryHistory->amount = $amount;
        $inventoryHistory->description = "Pembuatan Awal Persediaan";
        $inventoryHistory->save();

        $inventoryList = Inventory::where('user_id', $request->user_id)->get();

        return response()->json([
            'inventory' => $inventory,
            'history' => $inventoryHistory,
            'inventoryList' => $inventoryList,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}

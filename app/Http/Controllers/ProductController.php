<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $user_id = Auth::user()->id;

        $product = Product::where('user_id', $user_id)->first();

        return view('products.index', compact('product'));
    }

    public function create()
    {
        return view('products.create');
    }


    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $product = new Product;
        $product->user_id = $user_id;
        $product->save();

        return redirect()->route('product')->with('sucess', 'Product berhasil dibuat.');
    }


    public function show(Product $product, $unique_id)
    {
        
        $product = Product::where('unique_id', $unique_id)->first();
        return view('products.show', compact('product'));
    }


    public function edit(Product $product)
    {
        $user_id = Auth::user()->id;
        $product = Product::where('user_id', $user_id)->first();
         return view('products.edit', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $user_id = Auth::user()->id;
        $product_id = $request->product_id;

        $product = Product::where('id', $product_id)->first();
        
        $product->name = $request->name;
        $product->save();

         return redirect()->route('product')->with('sucess', 'Product berhasil diedit.');
    }


    public function destroy(Product $product)
    {
         Product::destroy($request->product_id);

        return redirect()->route('product')->with('danger', 'Product berhasil didelete.');
    }
}

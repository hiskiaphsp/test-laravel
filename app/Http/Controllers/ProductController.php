<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SaveProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('pages.products.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.products.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['update_by'] = Auth::user()->name;

        Product::create($validatedData);

        return redirect()->route('product.index')->with('success', 'Produk berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $product = Product::findOrFail($id);
    // return view('pages.products.show', compact('product'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(SaveProductRequest $request,$id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $request->validated();
        $product->update_by = Auth::user()->name;
        $product->update($validatedData);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus');
    }
}

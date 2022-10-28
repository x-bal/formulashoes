<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $title = 'Data Product';
        $products = Product::get();

        return view('product.index', compact('title', 'products'));
    }

    public function create()
    {
        $product = new Product();
        $action = route('products.store');
        $method = 'POST';
        $title = 'Tambah Product';

        return view('product.form', compact('product', 'action', 'method', 'title'));
    }

    public function store(CreateProductRequest $createProductRequest)
    {
        try {
            DB::beginTransaction();

            $attr = $createProductRequest->all();

            $foto = $createProductRequest->file('foto');
            $fotoUrl = $foto->storeAs('products', Str::slug($createProductRequest->nama_product) . '-' . Str::random(6) . '.' . $foto->extension());

            $attr['foto'] = $fotoUrl;

            Product::create($attr);

            DB::commit();

            return redirect()->route('products.index')->with('success', "Product berhasil ditambahkan");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $action = route('products.update', $product->id);
        $method = 'PUT';
        $title = 'Edit Product';

        return view('product.form', compact('product', 'action', 'method', 'title'));
    }

    public function update(UpdateProductRequest $updateProductRequest, Product $product)
    {
        try {
            DB::beginTransaction();
            $attr = $updateProductRequest->all();

            if ($updateProductRequest->file('foto')) {
                Storage::delete($product->foto);
                $foto = $updateProductRequest->file('foto');
                $fotoUrl = $foto->storeAs('products', Str::slug($updateProductRequest->name) . '-' . Str::random(6) . '.' . $foto->extension());
            } else {
                $fotoUrl = $product->foto;
            }

            $attr['foto'] = $fotoUrl;

            $product->update($attr);

            DB::commit();

            return redirect()->route('products.index')->with('success', "Product berhasil diubah");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            Storage::delete($product->foto);
            $product->delete();

            DB::commit();

            return redirect()->route('products.index')->with('success', "Product berhasil didelete");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'quant' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $user = User::find(auth()->user()->id);

            $user->products()->attach($request->product_id, ['qty' => $request->quant]);

            DB::commit();

            return back()->with('success', 'Product berhasil ditambahkan ke cart');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
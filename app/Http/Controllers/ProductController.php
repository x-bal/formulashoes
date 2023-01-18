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
    public function __construct()
    {
    }

    public function index()
    {
        $title = auth()->user()->level == 'Admin' ? 'Data Product' : 'Lest Clean Your Shoes!';
        $products = Product::get();

        if (isUser()) {
            if (auth()->user()->alamat == null && auth()->user()->alamat_lengkap == null) {
                return back();
            }
        }

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
        return view('product.show', compact('product'));
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
                $fotoUrl = $foto->storeAs('products', Str::slug($updateProductRequest->nama_product) . '-' . Str::random(6) . '.' . $foto->extension());
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
            'product_id' => 'required',
            'quant' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $user = User::find(auth()->user()->id);
            $product = Product::find($request->product_id);

            if (count($user->products) == 0) {
                $product->users()->attach($user->id, ['qty' => $request->quant]);
            } else {
                $pivot = DB::table('product_user')->where(['product_id' => $product->id, 'user_id' => $user->id])->first();
                if ($pivot) {
                    $product->users()->syncWithPivotValues($user->id, ['qty' => $pivot->qty + $request->quant]);
                } else {
                    $product->users()->syncWithPivotValues($user->id, ['qty' => $request->quant]);
                }
            }

            DB::commit();

            return back()->with('success', 'Product berhasil ditambahkan ke cart');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function quantity(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = User::find(auth()->user()->id);

            foreach ($user->products as $prod) {
                $qty = $prod->pivot->qty;
                $user->products()->syncWithPivotValues($request->product_id, ['qty' => $qty + $request->quant]);
            }

            DB::commit();

            // return back()->with('success', 'Product berhasil ditambahkan ke cart');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function remove(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = User::find($request->user);
            $user->products()->detach($request->product);

            DB::commit();

            return back()->with('success', 'Product berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

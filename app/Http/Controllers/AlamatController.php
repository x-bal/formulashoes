<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    public function index()
    {
        $title = 'Alamat Pelanggan';
        $alamats = Alamat::get();

        return view('alamat.index', compact('title', 'alamats'));
    }

    public function create()
    {
        $title = 'Tambah Alamat';
        $action = route('alamat.store');
        $method = 'POST';
        $alamat = new Alamat();

        return view('alamat.form', compact('title', 'action', 'method', 'alamat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            Alamat::create(['alamat' => $request->alamat]);

            DB::commit();

            return redirect()->route('alamat.index')->with('success', 'Alamat berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(Alamat $alamat)
    {
        //
    }

    public function edit(Alamat $alamat)
    {
        $title = 'Edit Alamat';
        $action = route('alamat.update', $alamat->id);
        $method = 'PUT';

        return view('alamat.form', compact('title', 'action', 'method', 'alamat'));
    }

    public function update(Request $request, Alamat $alamat)
    {
        $request->validate([
            'alamat' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $alamat->update(['alamat' => $request->alamat]);

            DB::commit();

            return redirect()->route('alamat.index')->with('success', 'Alamat berhasil diupdate');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Alamat $alamat)
    {;

        try {
            DB::beginTransaction();

            $alamat->delete();

            DB::commit();

            return redirect()->route('alamat.index')->with('success', 'Alamat berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

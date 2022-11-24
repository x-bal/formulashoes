<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Alamat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $user = new User();
        $action = route('users.store');
        $method = 'POST';
        $title = 'Tambah User';
        $alamat = Alamat::get();

        return view('user.form', compact('user', 'action', 'method', 'title', 'alamat'));
    }

    public function store(CreateUserRequest $createUserRequest)
    {
        try {
            DB::beginTransaction();

            $attr = $createUserRequest->all();

            $foto = $createUserRequest->file('foto');
            $fotoUrl = $foto->storeAs('users', Str::slug($createUserRequest->name) . '-' . Str::random(6) . '.' . $foto->extension());

            $attr['password'] = bcrypt($createUserRequest->password);
            $attr['foto'] = $fotoUrl;

            if (request('alamat') != 'custom') {
                $attr['alamat'] = request('alamat');
                $attr['nama_gedung'] = request('nama_gedung');
                $attr['no_kamar'] = request('no_kamar');
                $attr['alamat_lengkap'] = null;
            } else {
                $attr['alamat'] = null;
                $attr['nama_gedung'] = null;
                $attr['no_kamar'] = null;
                $attr['alamat_lengkap'] = request('alamat_lengkap');
            }

            User::create($attr);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $action = route('users.update', $user->id);
        $method = 'PUT';
        $title = 'Update User';
        $alamat = Alamat::get();

        return view('user.form', compact('user', 'action', 'method', 'title', 'alamat'));
    }

    public function update(UpdateUserRequest $updateUserRequest, User $user)
    {
        try {
            DB::beginTransaction();

            $attr = $updateUserRequest->all();

            if ($updateUserRequest->file('foto')) {
                $user->foto != null ? Storage::delete($user->foto) : '';
                $foto = $updateUserRequest->file('foto');
                $fotoUrl = $foto->storeAs('users', Str::slug($updateUserRequest->name) . '-' . Str::random(6) . '.' . $foto->extension());
            } else {
                $fotoUrl = $user->foto;
            }

            if (request('alamat') != 'custom') {
                $attr['alamat'] = request('alamat');
                $attr['nama_gedung'] = request('nama_gedung');
                $attr['no_kamar'] = request('no_kamar');
                $attr['alamat_lengkap'] = null;
            } else {
                $attr['alamat'] = null;
                $attr['nama_gedung'] = null;
                $attr['no_kamar'] = null;
                $attr['alamat_lengkap'] = request('alamat_lengkap');
            }

            $attr['password'] = $updateUserRequest->password ? bcrypt($updateUserRequest->password) : $user->password;
            $attr['foto'] = $fotoUrl;

            $user->update($attr);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            // Storage::delete($user->foto);
            $user->delete();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'User berhasil didelete');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function cart()
    {
        $title = 'My Cart';
        $user = User::find(auth()->user()->id);

        return view('dashboard.mycart', compact('title', 'user'));
    }

    public function profile()
    {
        $title = 'My Profile';
        $user = User::find(auth()->user()->id);

        return view('dashboard.profile', compact('title', 'user'));
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

            $attr['password'] = $updateUserRequest->password ? bcrypt($updateUserRequest->password) : $user->password;
            $attr['foto'] = $fotoUrl;

            $user->update($attr);

            DB::commit();

            return back()->with('success', 'Profile berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

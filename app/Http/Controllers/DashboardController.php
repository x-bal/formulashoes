<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Alamat;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $month = Carbon::now('Asia/Jakarta')->format('m');

        if (auth()->user()->level == 'User') {
            $order = Order::where('user_id', auth()->user()->id)->whereMonth('created_at', $month)->where('status_laundry', 'Selesai')->count();
            $cart = User::find(auth()->user()->id)->products()->count();
        } else {
            $order = Order::whereMonth('created_at', $month)->where('status_laundry', 'Selesai')->count();
            $cart = Order::whereMonth('created_at', $month)->where('status_laundry', 'Selesai')->sum('total_price');
        }

        return view('dashboard.index', compact('order', 'cart'));
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
        $alamat = Alamat::get();
        $user = User::find(auth()->user()->id);

        return view('dashboard.profile', compact('title', 'user', 'alamat'));
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
                $attr['alamat'] = 'custom';
                $attr['nama_gedung'] = null;
                $attr['no_kamar'] = null;
                $attr['alamat_lengkap'] = request('alamat_lengkap');
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

    public function history(Request $request)
    {
        $title = 'My History';
        if (auth()->user()->alamat == null && auth()->user()->alamat_lengkap == null) {
            return back();
        }

        if ($request->from && $request->to) {
            $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
            $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d 00:00:00');

            $orders = Order::where('user_id', auth()->user()->id)->where('created_at', '>=', $from)->where('created_at', '<', $to)->whereIn('status_laundry', ['Selesai', 'Gagal'])->get();
        } else {
            $orders = Order::where('user_id', auth()->user()->id)->whereIn('status_laundry', ['Selesai', 'Gagal'])->latest()->get();
        }

        return view('dashboard.history', compact('title', 'orders'));
    }
}

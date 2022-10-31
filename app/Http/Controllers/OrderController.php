<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (isAdmin()) {
            $title = 'List Order';
            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');

            $orders = Order::whereDate('created_at', $date)->latest()->get();
        } else {
            $title = 'My Order';

            if ($request->from && $request->to) {
                $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
                $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d 00:00:00');

                $orders = Order::where('user_id', auth()->user()->id)->where('created_at', '>=', $from)->where('created_at', '<', $to)->get();
            } else {
                $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $orders = Order::where('user_id', auth()->user()->id)->whereDate('created_at', $date)->orderBy('no_urut')->get();
            }
        }

        return view('order.index', compact('title', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'product_id' => 'required|array',
            'qty' => 'required|array',
            'foto' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            DB::beginTransaction();
            $user = User::find($request->user_id);
            $total = 0;

            foreach ($request->product_id as $key => $product) {
                $total += Product::find($product)->harga * $request->qty[$key];

                $pivot_data = ['qty' => 0];

                if ($product == $request->product_id[$key]) $pivot_data = ['qty' => $request->qty[$key]];

                $data_to_sync[$product] = $pivot_data;
            }

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('orders/foto', date('dmYHis') . rand(100, 999) . '.' . $foto->extension());

            $attr = [
                'user_id' => $user->id,
                'no_order' => 'FMS' . date('dmy') . rand(100, 999),
                'total_price' => $total,
                'payment_status' => 1,
                'status_laundry' => 'Booked',
                'foto' => $fotoUrl
            ];

            $order = Order::create($attr);

            $order->products()->sync($data_to_sync);
            $user->products()->detach($request->product_id);

            DB::commit();

            return redirect()->route('orders.show', $order->no_order);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function show(Order $order)
    {
        $snapToken = $order->snap_token;

        if (empty($snapToken)) {
            $user = User::find(auth()->user()->id);

            $snapToken =  app(\App\Http\Controllers\Midtrans\MidtransController::class)->getSnapToken($order, $user);

            $order->snap_token = $snapToken;
            $order->save();
        }

        return view('order.show', compact('order', 'snapToken'));
    }

    public function status(Order $order)
    {
        try {
            DB::beginTransaction();

            $order->update(['payment_status' => request('status')]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => route('mycart')
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function statuslaundry(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::where('no_order', $request->no_order)->first();

            $order->update(['status_laundry' => $request->status_laundry]);

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Status laundry berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}

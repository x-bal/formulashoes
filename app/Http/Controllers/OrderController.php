<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (isAdmin()) {
            $title = 'List Order';

            if ($request->from && $request->to) {
                $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
                $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d 00:00:00');

                $orders = Order::where('created_at', '>=', $from)->where('created_at', '<', $to)->get();
            } else {
                $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');

                $orders = Order::whereDate('created_at', $date)->latest()->get();
            }
        } else {
            if (auth()->user()->alamat == null) {
                return back();
            }

            $title = 'My Order';

            if ($request->from && $request->to) {
                $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
                $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d 00:00:00');

                $orders = Order::where('user_id', auth()->user()->id)->where('created_at', '>=', $from)->where('created_at', '<', $to)->where('status_laundry', '!=', 'Selesai')->get();
            } else {
                $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                $orders = Order::where('user_id', auth()->user()->id)->where('status_laundry', '!=', 'Selesai')->whereDate('created_at', $date)->orderBy('no_urut')->get();
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

    public function nourut(Request $request)
    {
        try {
            DB::beginTransaction();
            $date = Carbon::now('Asia/Jakarta')->format('Y-m-d');

            $total = Order::where('user_id', $request->user_id)->whereDate('created_at', $date)->count();

            $order = Order::where('no_order', $request->id)->first();


            if ($request->nourut == 0 && $request->nourut > $total) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No urut tidak valid'
                ]);
            } else {
                $order->update(['no_urut' => $request->nourut]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'No urut berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function export(Request $request)
    {
        if ($request->from && $request->to) {
            $from = Carbon::parse($request->from)->format('Y-m-d 00:00:00');
            $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d 00:00:00');

            $orders = Order::where('created_at', '>=', $from)->where('created_at', '<', $to)->get();
        }

        return Excel::download(new OrderExport($orders), 'List Data Order.xlsx');
    }
}

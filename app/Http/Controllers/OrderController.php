<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function index()
    {
        $title = 'My Order';
        $orders = Order::where('user_id', auth()->user()->id)->latest()->get();

        return view('order.index', compact('title', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'product_id' => 'required|array',
            'qty' => 'required|array'
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

            $attr = [
                'user_id' => $user->id,
                'no_order' => 'FMS' . date('dmy') . rand(100, 999),
                'total_price' => $total,
                'payment_status' => 1,
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
}

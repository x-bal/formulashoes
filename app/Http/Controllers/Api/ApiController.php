<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function tapping(Request $request)
    {
        if ($request->iddev != '' && $request->uid != '') {
            $device = Device::where('id_device', $request->iddev)->first();

            if ($device) {
                $uid = User::where('uid', $request->uid)->first();

                if ($uid) {
                    $order = Order::where(['user_id' => $uid->id, 'status_laundry' => 'Booked'])->first();

                    if ($order) {
                        $cek = Order::where(['user_id' => $uid->id, 'status_laundry' => 'Booked', 'payment_status' => 2])->where('no_urut', '>', 0)->orderBy('no_urut', 'ASC')->first();

                        if ($cek) {
                            $balance = $order->products()->sum('qty');
                            $waktu = 10 * $balance;
                            $keterangan = $order->status_laundry;

                            $order->update(['device_id' => $device->id]);

                            return response()->json([
                                'status' => 'success',
                                'nama' => $uid->name,
                                'waktu' => $waktu,
                                'keterangan' => $keterangan,
                                'balance' => $balance
                            ]);
                        } else {
                            return response()->json([
                                'status' => 'failed',
                                'message' => 'No urut tidak valid',
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status' => 'failed',
                            'message' => 'Silahkan Order',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Uid tidak terdaftar',
                        'uid' => $request->uid
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Device tidak ditemukan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Salah Parameter'
            ]);
        }
    }

    public function upload(Request $request)
    {
        if ($request->iddev != '' && $request->uid != '') {
            $device = Device::where('id_device', $request->iddev)->first();

            if ($device) {
                $uid = User::where('uid', $request->uid)->first();

                if ($uid) {
                    try {
                        DB::beginTransaction();
                        $order = Order::where(['user_id' => $uid->id, 'status_laundry' => 'Booked'])->orderBy('no_urut', 'ASC')->first();

                        if ($request->file('image') != null) {
                            $image = $request->file('image');
                            $imageUrl = $image->storeAs('orders/images', date('dmYHis') . rand(100, 999) . '.' . $image->extension());
                        } else {
                            $imageUrl = null;
                        }

                        $order->update(['after_laundry' => $imageUrl, 'status_laundry' => 'Sedang Diproses']);

                        DB::commit();

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Image berhasil diupload'
                        ]);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'failed',
                            'message' => $th->getMessage()
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Uid tidak terdaftar',
                        'uid' => $request->uid
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Device tidak ditemukan'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Salah Parameter'
            ]);
        }
    }

    public function notification(Request $request)
    {
        try {
            $notification_body = json_decode($request->getContent(), true);
            $invoice = $notification_body['order_id'];
            $transaction_id = $notification_body['transaction_id'];
            $status_code = $notification_body['status_code'];
            $order = Order::where('no_order', $invoice)->first();
            if (!$order)
                return ['code' => 0, 'messgae' => 'Terjadi kesalahan | Pembayaran tidak valid'];
            switch ($status_code) {
                case '200':
                    $order->payment_status = 2;
                    break;
                case '201':
                    $order->payment_status = 1;
                    break;
                case '202':
                    $order->payment_status = 4;
                    break;
            }
            $order->save();
            return response('Ok', 200)->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response('Error', 404)->header('Content-Type', 'text/plain');
        }
    }
}

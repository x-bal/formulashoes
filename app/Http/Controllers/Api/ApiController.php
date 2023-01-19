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
                        $cek = Order::where(['user_id' => $uid->id, 'status_laundry' => 'Booked'])->where('no_urut', '!=', 0)->orderBy('no_urut', 'ASC')->first();

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
}

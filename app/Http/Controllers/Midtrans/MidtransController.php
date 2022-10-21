<?php

namespace App\Http\Controllers\Midtrans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        $this->_configureMidtrans();
    }

    public function _configureMidtrans()
    {
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    public function getSnapToken($order, $customer)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->no_order,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->telp ?? '-',
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}

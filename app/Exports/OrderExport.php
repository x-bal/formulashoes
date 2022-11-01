<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    private $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('order.export', [
            'orders' => $this->orders
        ]);
    }
}

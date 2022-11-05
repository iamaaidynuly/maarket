<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
    protected $user;
    protected $from;
    protected $to;

    public function __construct($user, $from, $to)
    {
        $this->user = $user;
        $this->from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
        $this->to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
    }


    public function view(): View
    {
        $orders = Order::where('user_id', $this->user)->whereBetween('created_at', [$this->from, $this->to])->get();

        return view('exports.user', [
            'orders'    =>  $orders,
        ]);
    }
}

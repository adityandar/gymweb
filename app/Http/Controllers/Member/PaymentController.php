<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function history(): View
    {
        $orders = auth()->user()->orders()
            ->with('plan', 'payment')
            ->latest()
            ->get();

        return view('member.payment-history', compact('orders'));
    }
}

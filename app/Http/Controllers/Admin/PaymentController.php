<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user', 'plan', 'payment', 'proof')
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('orders'));
    }
}

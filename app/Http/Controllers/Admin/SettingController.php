<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $paymentMode = SystemSetting::paymentMode();
        return view('admin.settings.index', compact('paymentMode'));
    }

    public function updatePaymentMode(Request $request): RedirectResponse
    {
        $request->validate(['payment_mode' => 'required|in:automatic,manual']);

        $setting = SystemSetting::firstOrCreate([]);
        $setting->update(['payment_mode' => $request->payment_mode]);

        return redirect()->route('admin.settings.index')->with('success', 'Payment mode updated.');
    }
}

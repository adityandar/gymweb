<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentWebhookController extends Controller
{
    public function __invoke(Request $request, PaymentService $paymentService): Response
    {
        $payload = $request->all();
        $paymentService->handleWebhook($payload);

        return response('OK', 200);
    }
}

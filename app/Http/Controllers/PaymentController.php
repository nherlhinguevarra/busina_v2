<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayMongoService;

class PaymentController extends Controller
{
    protected $payMongoService;

    public function __construct(PayMongoService $payMongoService)
    {
        $this->payMongoService = $payMongoService;
    }

    public function index()
    {
        $payments = $this->payMongoService->getPayments();
        $payouts = $this->payMongoService->getPayouts();

        return view('payments', compact('payments', 'payouts'));
    }
}

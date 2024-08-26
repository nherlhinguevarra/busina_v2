<!-- resources/views/payments/index.blade.php -->
@extends('layouts.main')

@section('title', 'Application Details')

@section('title-details')
<div class="title-details">
    <h1>Application Details</h1>
</div>
@endsection

@section('content')
    <div class="container">
        <h1>Payments</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment['attributes']['payment_method'] ?? 'N/A' }}</td>
                        <td>{{ number_format($payment['attributes']['amount'] / 100, 2) }} PHP</td>
                        <td>{{ \Carbon\Carbon::parse($payment['attributes']['created_at'])->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


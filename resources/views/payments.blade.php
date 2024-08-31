<!-- resources/views/payments/index.blade.php -->
@extends('layouts.main')

@section('title', 'Payments')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/pending-applications.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<div class="table-container">
    <div class="heading">
        <h1 class="page-title">Payments</h1>
    </div>
        <table class="table">
            <thead>
                <tr>
                    <th class="th-class">Reference Code</th>
                    <th class="th-class">Amount</th>
                    <th class="th-class">Date Created</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach($payments as $payment)
                    <tr>
                        <td class="td-class">{{ $payment['id'] }}</td> <!-- Display payment ID as reference number -->
                        <td class="td-class">{{ number_format($payment['attributes']['amount'] / 100, 2) }} PHP</td>
                        <td class="td-class">{{ \Carbon\Carbon::parse($payment['attributes']['created_at'])->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Payouts Table -->
        <h2>Payouts</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Payout ID</th>
                    <th>Amount</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payouts as $payout)
                    <tr>
                        <td>{{ $payout['id'] }}</td>
                        <td>{{ number_format($payout['attributes']['amount'] / 100, 2) }} PHP</td>
                        <td>{{ \Carbon\Carbon::parse($payout['attributes']['created_at'])->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


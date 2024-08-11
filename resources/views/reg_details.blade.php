@extends('layouts.main1')

@section('title', 'Transaction Details')

@section('title-details')
<div class="title=details">
    <h1>Registration Details</h1>
</div>
@endsection

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/details.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<!-- Owner Information -->
<h2 class="section-title">Vehicle Owner Information</h2>
<div class="owner-info">
    <ul>
        <li>
            <span>Full Name:</span> 
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->fname }} {{ $transaction->vehicle->vehicle_owner->mname }} {{ $transaction->vehicle->vehicle_owner->lname }}</li>
        <li>
            <span>Contact No:</span> 
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->contact_no }}</span>
        </li>
        <li>
            <span>Employee ID:</span> 
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->emp_id }}</span>
        </li>
        <li>
            <span>Student ID:</span>
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->std_id }}</span>
        </li>
        <li>
            <span>Driver License No:</span>
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->driver_license_no }}</span>
        </li>
        <li>
            <span>Applicant Type:</span>
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->applicant_type->type ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Created At:</span>
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->created_at }}</span>
        </li>
    </ul>
    <ul class="qr-code">
        <li>QR Code:</li>
        <li>
            @if($transaction->qr_code_base64)
                <img src="data:image/png;base64,{{ $transaction->qr_code_base64 }}" alt="QR Code" class="code">
            @else
                <p>No QR code available.</p>
            @endif
        </li>
    </ul>
</div>
@endsection

@section('content-3')
    <!-- Vehicle Information -->
    <h2>Vehicle Information</h2>
    <ul>
        <li>Model Color: {{ $transaction->vehicle->model_color }}</li>
        <li>Plate No: {{ $transaction->vehicle->plate_no }}</li>
        <li>Expiry Date: {{ $transaction->vehicle->expiry_date }}</li>
        <li>Copy of Driver License: {{ $transaction->vehicle->copy_driver_license }}</li>
        <li>Copy of COR: {{ $transaction->vehicle->copy_cor }}</li>
        <li>Copy of School ID: {{ $transaction->vehicle->copy_school_id }}</li>
        <li>OR No: {{ $transaction->vehicle->or_no }}</li>
        <li>CR No: {{ $transaction->vehicle->cr_no }}</li>
        <li>Copy of OR/CR: {{ $transaction->vehicle->copy_or_cr }}</li>
        <li>Vehicle Type: {{ $transaction->vehicle->vehicle_type->type ?? 'Unknown' }}</li>
    </ul>
@endsection

@section('content-2')
    <!-- Transactions -->
    <h3>Transaction Information</h3>
    <ul>
        <li>Reference No: {{ $transaction->reference_no }}</li>
        <li>Issued Date: {{ $transaction->issued_date }}</li>
        <li>Claiming Status: {{ $transaction->claiming_status->status ?? 'Unknown' }}</li>
    </ul>
@endsection

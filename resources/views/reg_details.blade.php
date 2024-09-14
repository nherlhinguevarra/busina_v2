@extends('layouts.main')

@section('title', 'Transaction Details')

@section('title-details')
<div class="title-details">
    <h1>Registration Details</h1>
</div>
@endsection

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('storage/css/details.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script> -->
    @vite(['storage/app/public/css/details.css', 'storage/app/public/js/app.js'])
</head>

<!-- Owner Information -->
<h2 class="section-title">Vehicle Owner Information</h2>
<div class="owner-info">
    <ul>
        <li>
            <span>Registration No. :</span> 
            <span class="deets">{{ $transaction->registration_no }}</span>
        </li>
        <li>
            <span>Registered To:</span> 
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->fname }} {{ $transaction->vehicle->vehicle_owner->mname }} {{ $transaction->vehicle->vehicle_owner->lname }}
        </li>
        <li>
            <span>Owner Type:</span>
            <span class="deets">{{ $transaction->vehicle->vehicle_owner->applicant_type->type ?? 'Unknown' }}</span>
        </li>
    </ul>
    <ul>
        <li>
            <span>Reference No:</span> 
            <span class="deets">{{ $transaction->reference_no }}</span>
        </li>
        <li>
            <span>Issued Date:</span>
            <span class="deets">{{ $transaction->issued_date }}</span>
        </li>
        <li>
            <span>Claiming Status:</span>
            <span class="deets">{{ $transaction->claiming_status->status ?? 'Unknown' }}</span>
        </li>
    </ul>
</div>
@endsection

@section('content-2')
<h2 class="section-title">Vehicle Information</h2>
<div class="owner-info">
    <ul>
        <li>
            <span>Plate No:</span>
            <span class="deets">{{ $transaction->vehicle->plate_no }}</span>
        </li>
        <li>
            <span>Model Color:</span>
            <span class="deets">{{ $transaction->vehicle->model_color }}</span>
        </li>
        <li>
            <span>Vehicle Type:</span>
            <span class="deets">{{ $transaction->vehicle->vehicle_type->type ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Expiry Date:</span>
            <span class="deets">{{ $transaction->vehicle->expiry_date }}</span>
        </li>
    </ul>
    <ul>
        <li>
            <span>OR No:</span>
            <span class="deets">{{ $transaction->vehicle->or_no }}</span>
        </li>
        <li>
            <span>CR No:</span>
            <span class="deets">{{ $transaction->vehicle->cr_no }}</span>
        </li>
        <li>
            <span>Reference No:</span>
            <span class="deets">{{ $transaction->reference_no }}</span>
        </li>
    </ul>
</div>
<div class="owner-info">
    <ul>
        <li>
            <span>Copy of Driver License:</span>
            <span class="deets">{{ $transaction->vehicle->copy_driver_license }}</span>
        </li>
        <li>
            <span>Copy of COR:</span>
            <span class="deets">{{ $transaction->vehicle->copy_cor }}</span>
        </li>
        <li>
            <span>Copy of School ID:</span>
            <span class="deets">{{ $transaction->vehicle->copy_school_id }}</span>
        </li>
        <li>
            <span>Copy of OR/CR:</span>
            <span class="deets">{{ $transaction->vehicle->copy_or_cr }}</span>
        </li>
    </ul>
</div>
@endsection

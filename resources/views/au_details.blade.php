@extends('layouts.main')

@section('title', 'User Details')

@section('title-details')
<div class="title-details">
    <h1>User Details</h1>
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

<h2 class="section-title">Owner Information</h2>
<div class="owner-info">
    <ul>
        <li>
            <span>Name:</span> 
            <span class="deets">{{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</span>
        </li>
        <li>
            <span>Email:</span> 
            <span class="deets">{{ $userEmail }}</span>
        </li>
        <li>
            <span>Contact No:</span>
            <span class="deets">{{ $item->contact_no }}</span>
        </li>
        <li>
            <span>Employee ID:</span> 
            <span class="deets">{{ $item->emp_id  ?? 'N/A' }}</span>
        </li>
        <li>
            <span>Student ID:</span>
            <span class="deets">{{ $item->std_id  ?? 'N/A' }}</span>
        </li>
        <li>
            <span>Applicant Type:</span>
            <span class="deets">{{ $item->applicant_type->type ?? 'Unknown' }}</span>
        </li>
    </ul>
    <ul class="right">
        <li>QR Code:</li>
        <li>
            @if ($item->qr_code)
                <img src="data:image/png;base64,{{ base64_encode($item->qr_code) }}" alt="QR Code" class="code">
            @else
                <p>No QR Code</p>
            @endif
        </li>
    </ul>
</div>
@endsection

@section('content-2')
<h2 class="section-title">Vehicle Information</h2>
<div class="vehicle">
    @foreach($sortedVehicles as $index => $vehicle)
        <div class="owner-info">
        <h3 class="veh-no">Vehicle 
            <span class="num">#{{ $index + 1 }}</span>
        </h3>
            <ul>
                <li>
                    <span>Plate No:</span> 
                    <span class="deets">{{ $vehicle->plate_no }}</span>
                </li>
                <li>
                    <span>Vehicle Type:</span> 
                    <span class="deets">{{ $vehicle->vehicle_type->type ?? 'Unknown' }}</span>
                </li>
            </ul>
            <ul>
                @if($vehicle->transaction->isNotEmpty())
                    @foreach($vehicle->transaction as $transactionIndex => $transaction)
                        <li>
                            <span>Registration No. :</span> 
                            <span class="deets">{{ $transaction->registration_no ?? 'Unknown' }}</span>
                        </li>
                        <li>
                            <span>Issued Date:</span> 
                            <span class="deets">{{ $transaction->created_at->format('Y-m-d') ?? 'Unknown' }}</span>
                        </li>
                    @endforeach
                @else
                    <li>
                        <span>Registration No:</span> 
                        <span class="deets">No registration found</span>
                    </li>
                @endif
            </ul>
        </div>
</div>
@endforeach
@endsection



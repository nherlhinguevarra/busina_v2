@extends('layouts.main')

@section('title', 'Application Details')

@section('title-details')
<div class="title=details">
    <h1>Application Details</h1>
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
<h2 class="section-title">Owner Information</h2>
<div class="owner-info">
    <ul>
        <li>
            <span>Full Name:</span>
            <span class="deets">{{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</span>
        </li>
        <li>
            <span>Contact No:</span> 
            <span class="deets">{{ $item->contact_no }}</span>
        </li>
        <li>
            <span>Employee ID:</span> 
            <span class="deets">{{ $item->emp_id }}</span>
        </li>
        <li>
            <span>Student ID:</span> 
            <span class="deets">{{ $item->std_id }}</span>
        </li>
        <li>
            <span>Driver License No:</span>
            <span class="deets">{{ $item->driver_license_no }}</span>
        </li>
        <li>
            <span>Applicant Type:</span> 
            <span class="deets">{{ $item->applicant_type->type ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Created At:</span> 
            <span class="deets">{{ $item->created_at }}</span>
        </li>
    </ul>
    <ul class="qr-code">
        <li>QR Code:</li>
        <li>
            @if($item->qr_code_base64)
                <img src="data:image/png;base64,{{ $item->qr_code_base64 }}" alt="QR Code" class="code">
            @else
                <p>No QR code available.</p>
            @endif
        </li>
    </ul>
</div>
@endsection

@section('content-2')
<h2 class="section-title">Vehicle Information</h2>
@foreach($item->vehicle as $vehicle)
    @foreach($vehicle->transaction as $transaction)
    <div class="owner-info">
    <ul>
        <li>
            <span>Model and Color:</span> 
            <span class="deets">{{ $vehicle->model_color }}</span>
        </li>
        <li>
            <span>Plate No:</span> 
            <span class="deets">{{ $vehicle->plate_no }}</span>
        </li>
        <li>
            <span>Expiry Date:</span> 
            <span class="deets">{{ $vehicle->expiry_date }}</span>
        </li>
        <li>
            <span>Copy of Driver License:</span> 
            <span class="deets">{{ $vehicle->copy_driver_license }}</span>
        </li>
        <li>
            <span>Copy of COR:</span> 
            <span class="deets">{{ $vehicle->copy_cor }}</span>
        </li>
        <li>
            <span>Copy of School ID:</span> 
            <span class="deets">{{ $vehicle->copy_school_id }}</span>
        </li>
        <li>
            <span>OR No:</span> 
            <span class="deets">{{ $vehicle->or_no }}</span>
        </li>
        <li>
            <span>CR No:</span> 
            <span class="deets">{{ $vehicle->cr_no }}</span>
        </li>
        <li>
            <span>Copy of OR/CR:</span>
            <span class="deets">{{ $vehicle->copy_or_cr }}</span>
        </li>
        <li>
            <span>Vehicle Type:</span>
            <span class="deets">{{ $vehicle->vehicle_type->type ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Reference No:</span>
            <span class="deets">{{ $transaction->reference_no }}</span>
        </li>
    </ul>
    </div>
    @endforeach
@endforeach
@endsection

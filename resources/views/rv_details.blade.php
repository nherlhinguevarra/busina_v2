@extends('layouts.main')

@section('title', 'Violation Details')

@section('title-details')
<div class="title-details">
    <h1>Violation Details</h1>
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

<!-- Violation Information -->
<h2 class="section-title">Violation Information</h2>
<div class="owner-info">
    <ul>
        <li>
            <span>Plate No:</span>
            <span class="deets">{{ $violation->plate_no }}</span>
        </li>
        <li>
            <span>Violation Name:</span>
            <span class="deets">{{ $violation->violation_type->violation_name ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Reported By:</span>
            <span class="deets">{{ $violation->authorized_user->fname }} {{ $violation->authorized_user->mname }} {{ $violation->authorized_user->lname }}</span>
        </li>
        <li>
            <span>Created At:</span>
            <span class="deets"{{ $violation->created_at }}</span>
        </li>
        <li>
            <span>Remarks:</span>
            <span class="deets">{{ $violation->remarks }}</span>
        </li>
        <li>
            <span>Location:</span>
            <span class="deets"{{ $violation->vehicle->location ?? 'Unknown' }}</span>
        </li>        
    </ul>
    <ul>
        <h2 class="section-title">Proof Image</h2>
        @if ($violation->proof_image)
            <img src="data:image/jpeg;base64,{{ base64_encode($violation->proof_image) }}" alt="Proof Image" style="width: 500px; height: auto;">
        @else
            <p>No proof image available.</p>
        @endif
    </ul>
</div>
@endsection

@extends('layouts.main')

@section('title', 'Violation Details')

@section('content')
    <h1>Violation Details</h1>

    <!-- Violation Information -->
    <h2>Violation Information</h2>
    <ul>
        <li>Plate No: {{ $violation->plate_no }}</li>
        <li>Violation Name: {{ $violation->violation_type->violation_name ?? 'Unknown' }}</li>
        <li>Reported By: {{ $violation->authorized_user->fname }} {{ $violation->authorized_user->mname }} {{ $violation->authorized_user->lname }}</li>
        <li>Created At: {{ $violation->created_at }}</li>
        <li>Remarks: {{ $violation->remarks }}</li>
        <li>Location: {{ $violation->vehicle->location ?? 'Unknown' }}</li>        
    </ul>
    </ul>

    <!-- Proof Image -->
    <h2>Proof Image</h2>
    @if ($violation->proof_image)
        <img src="data:image/jpeg;base64,{{ base64_encode($violation->proof_image) }}" alt="Proof Image" style="width: 500px; height: auto;">
    @else
        <p>No proof image available.</p>
    @endif
@endsection

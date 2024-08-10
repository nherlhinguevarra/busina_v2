@extends('layouts.main')

@section('title', 'Transaction Details')

@section('content')
    <h1>Transaction Details</h1>

    <!-- Owner Information -->
    <h2>Owner Information</h2>
    <ul>
        <li>Full Name: {{ $transaction->vehicle->vehicle_owner->fname }} {{ $transaction->vehicle->vehicle_owner->mname }} {{ $transaction->vehicle->vehicle_owner->lname }}</li>
        <li>Contact No: {{ $transaction->vehicle->vehicle_owner->contact_no }}</li>
        <li>QR Code: {{ $transaction->vehicle->vehicle_owner->qr_code }}</li>
        <li>Employee ID: {{ $transaction->vehicle->vehicle_owner->emp_id }}</li>
        <li>Student ID: {{ $transaction->vehicle->vehicle_owner->std_id }}</li>
        <li>Driver License No: {{ $transaction->vehicle->vehicle_owner->driver_license_no }}</li>
        <li>Applicant Type: {{ $transaction->vehicle->vehicle_owner->applicant_type->type ?? 'Unknown' }}</li>
        <li>Created At: {{ $transaction->vehicle->vehicle_owner->created_at }}</li>
    </ul>

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

    <!-- Transactions -->
    <h3>Transaction Information</h3>
    <ul>
        <li>Reference No: {{ $transaction->reference_no }}</li>
        <li>Issued Date: {{ $transaction->issued_date }}</li>
        <li>Claiming Status: {{ $transaction->claiming_status->status ?? 'Unknown' }}</li>
    </ul>
@endsection

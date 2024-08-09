@extends('layouts.main')

@section('title', 'Application Details')

@section('content')
    <!-- pa_details.blade.php -->

<h1>Vehicle Owner Details</h1>

<h2>Owner Information</h2>
<ul>
    <li>Full Name: {{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</li>
    <li>Contact No: {{ $item->contact_no }}</li>
    <li>QR Code: {{ $item->qr_code }}</li>
    <li>Employee ID: {{ $item->emp_id }}</li>
    <li>Student ID: {{ $item->std_id }}</li>
    <li>Driver License No: {{ $item->driver_license_no }}</li>
    <li>Applicant Type: {{ $item->applicant_type->type ?? 'Unknown' }}</li>
    <li>Created At: {{ $item->created_at }}</li>
</ul>

<h2>Vehicle Information</h2>
@foreach($item->vehicle as $vehicle)
    <ul>
        <li>Model Color: {{ $vehicle->model_color }}</li>
        <li>Plate No: {{ $vehicle->plate_no }}</li>
        <li>Expiry Date: {{ $vehicle->expiry_date }}</li>
        <li>Copy of Driver License: {{ $vehicle->copy_driver_license }}</li>
        <li>Copy of COR: {{ $vehicle->copy_cor }}</li>
        <li>Copy of School ID: {{ $vehicle->copy_school_id }}</li>
        <li>OR No: {{ $vehicle->or_no }}</li>
        <li>CR No: {{ $vehicle->cr_no }}</li>
        <li>Copy of OR/CR: {{ $vehicle->copy_or_cr }}</li>
        <li>Vehicle Type: {{ $vehicle->vehicle_type->type ?? 'Unknown' }}</li>
    </ul>

    <h3>Transactions</h3>
    @foreach($vehicle->transaction as $transaction)
        <ul>
            <li>Reference No: {{ $transaction->reference_no }}</li>
        </ul>
    @endforeach
@endforeach

@endsection
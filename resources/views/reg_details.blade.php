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
    @vite(['resources/css/details.css', 'resources/js/app.js'])
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
        <li>
            <span>Claiming Status:</span>
            <span class="deets">{{ $transaction->claiming_status->status ?? 'Unknown' }}</span>
        </li>
    </ul>
    <ul>
        <li>
            <span>Copy of Driver License:</span>
            <button type="button" class="view-btn" onclick="openModal('licenseModal')">View</button>
        </li>
        <li>
            <span>Copy of OR/CR:</span>
            <button type="button" class="view-btn" onclick="openModal('orcrModal')">View</button>
        </li>
        <li>
            <span>Copy of School ID:</span>
            <button type="button" class="view-btn" onclick="openModal('schoolIdModal')">View</button>
        </li>
        <li>
            <span>Copy of COR:</span>
            <button type="button" class="view-btn" onclick="openModal('corModal')">View</button>
        </li>
    </ul>
</div>

<div id="licenseModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('licenseModal')">&times;</span>
        <h5>Driver License</h5>
        <img src="{{ $transaction->vehicle->copy_driver_license }}" alt="Driver License" class="modal-img">
        <a href="{{ $transaction->vehicle->copy_driver_license }}" download class="blue-btn">Download</a>
    </div>
</div>

<!-- Modal for OR/CR -->
<div id="orcrModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('orcrModal')">&times;</span>
        <h5>OR/CR</h5>
        <img src="{{ $transaction->vehicle->copy_or_cr }}" alt="OR/CR" class="modal-img">
        <a href="{{ $transaction->vehicle->copy_or_cr }}" download class="blue-btn">Download</a>
    </div>
</div>

<!-- Modal for School ID -->
<div id="schoolIdModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('schoolIdModal')">&times;</span>
        <h5>School ID</h5>
        <img src="{{ $transaction->vehicle->copy_school_id }}" alt="School ID" class="modal-img">
        <a href="{{ $transaction->vehicle->copy_school_id }}" download class="blue-btn">Download</a>
    </div>
</div>

<!-- Modal for COR -->
<div id="corModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('corModal')">&times;</span>
        <h5>COR</h5>
        <img src="{{ $transaction->vehicle->copy_cor }}" alt="COR" class="modal-img">
        <a href="{{ $transaction->vehicle->copy_cor }}" download class="blue-btn">Download</a>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Close modal when clicking outside of the modal content
    window.onclick = function(event) {
        const modals = document.getElementsByClassName('modal');
        for (let i = 0; i < modals.length; i++) {
            if (event.target == modals[i]) {
                modals[i].style.display = "none";
            }
        }
    }
</script>

@endsection

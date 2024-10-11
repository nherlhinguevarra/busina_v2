@extends('layouts.main')

@section('title', 'Application Details')

@section('title-details')
<div class="title-details">
    <h1>Application Details</h1>
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
    </ul>
    <ul>
        <li>
            <span>Driver License No:</span>
            <span class="deets">{{ $item->driver_license_no }}</span>
        </li>
        <li>
            <span>Applicant Type:</span> 
            <span class="deets">{{ $item->applicant_type->type ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Application Date:</span> 
            <span class="deets">{{ $item->created_at }}</span>
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
            <span>Plate No:</span> 
            <span class="deets">{{ $vehicle->plate_no }}</span>
        </li>
        <li>
            <span>Model and Color:</span> 
            <span class="deets">{{ $vehicle->model_color }}</span>
        </li>
        <li>
            <span>Vehicle Type:</span>
            <span class="deets">{{ $vehicle->vehicle_type->type ?? 'Unknown' }}</span>
        </li>
        <li>
            <span>Expiry Date:</span> 
            <span class="deets">{{ $vehicle->expiry_date }}</span>
        </li>
    </ul>
    <ul>
        <li>
            <span>OR No:</span> 
            <span class="deets">{{ $vehicle->or_no }}</span>
        </li>
        <li>
            <span>CR No:</span> 
            <span class="deets">{{ $vehicle->cr_no }}</span>
        </li>
        <li>
            <span>Reference No:</span>
            <span class="deets">{{ $transaction->reference_no }}</span>
        </li>
    </ul>
    </div>
    <form id="documentApprovalForm" action="{{ route('save.document.approval', ['vehicleOwnerId' => $vehicleOwnerId]) }}" method="POST">
    @csrf
    <div class="owner-info">
        <ul>
            <li>
                <span>Copy of Driver License:</span>
                <button type="button" class="view-btn" onclick="openModal('licenseModal')">View</button>
                <label>
                    <input type="radio" name="status_license" value="approved" class="status-radio"> Approved
                </label>
                <label>
                    <input type="radio" name="status_license" value="reupload" class="status-radio"> Reupload
                </label>
            </li>
            <li>
                <span>Copy of OR/CR:</span>
                <button type="button" class="view-btn" onclick="openModal('orcrModal')">View</button>
                <label>
                    <input type="radio" name="status_orcr" value="approved" class="status-radio"> Approved
                </label>
                <label>
                    <input type="radio" name="status_orcr" value="reupload" class="status-radio"> Reupload
                </label>
            </li>
            <li>
                <span>Copy of School ID:</span>
                <button type="button" class="view-btn" onclick="openModal('schoolIdModal')">View</button>
                <label>
                    <input type="radio" name="status_schoolid" value="approved" class="status-radio"> Approved
                </label>
                <label>
                    <input type="radio" name="status_schoolid" value="reupload" class="status-radio"> Reupload
                </label>
            </li>
            <li>
                <span>Copy of COR:</span>
                <button type="button" class="view-btn" onclick="openModal('corModal')">View</button>
                <label>
                    <input type="radio" name="status_cor" value="approved" class="status-radio"> Approved
                </label>
                <label>
                    <input type="radio" name="status_cor" value="reupload" class="status-radio"> Reupload
                </label>
            </li>
        </ul>
    </div>
    <button type="submit" class="save-btn">Save</button>
</form>


    <div id="licenseModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('licenseModal')">&times;</span>
            <h5>Driver License</h5>
            <img src="{{ $vehicle->copy_driver_license }}" alt="Driver License" class="modal-img">
            <a href="{{ $vehicle->copy_driver_license }}" download class="download-btn">Download</a>
        </div>
    </div>

    <!-- Modal for OR/CR -->
    <div id="orcrModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('orcrModal')">&times;</span>
            <h5>OR/CR</h5>
            <img src="{{ $vehicle->copy_or_cr }}" alt="OR/CR" class="modal-img">
            <a href="{{ $vehicle->copy_or_cr }}" download class="download-btn">Download</a>
        </div>
    </div>

    <!-- Modal for School ID -->
    <div id="schoolIdModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('schoolIdModal')">&times;</span>
            <h5>School ID</h5>
            <img src="{{ $vehicle->copy_school_id }}" alt="School ID" class="modal-img">
            <a href="{{ $vehicle->copy_school_id }}" download class="download-btn">Download</a>
        </div>
    </div>

    <!-- Modal for COR -->
    <div id="corModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('corModal')">&times;</span>
            <h5>COR</h5>
            <img src="{{ $vehicle->copy_cor }}" alt="COR" class="modal-img">
            <a href="{{ $vehicle->copy_cor }}" download class="download-btn">Download</a>
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

    @endforeach
@endforeach
@endsection

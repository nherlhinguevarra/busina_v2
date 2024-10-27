@extends('layouts.main1')

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
    @vite(['resources/css/details.css', 'resources/css/app.css', 'resources/js/app.js'])
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
            <span>Date Issued:</span>
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
        <li>
        <div class="status-container">
            <label class="status-label">STATUS:</label>

            <!-- Dropdown for selecting status -->
            <select id="status-dropdown" style="height: 30px" class="status-input form-select {{ $transaction->claiming_status->status === 'To claim' ? 'text-gray' : ($transaction->claiming_status->status === 'Claimed' ? 'text-green' : '') }}" onchange="enableSaveButton()">
                <option value="2" {{ $transaction->claiming_status->status === 'To claim' ? 'selected' : '' }}>To claim</option>
                <option value="3" {{ $transaction->claiming_status->status === 'Claimed' ? 'selected' : '' }}>Claimed</option>
            </select>

            <!-- Save Button (hidden by default) -->
            <button id="save-button" style="font-size: 14px;"class="btn-save" onclick="showConfirmation()" disabled>Save</button>
        </div>
        </li>
    </ul>
</div>
<div class="buttons">
    <a class="blue-btn" href="{{ url('/registered_vehicles') }}">BACK</a>
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

<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('confirmationModal')">&times;</span>
        <h5>Confirm Status Update</h5>
        <p>Are you sure you want to update the claiming status?</p>
        <div class="modal-buttons">
            <button onclick="closeModal('confirmationModal')" class="gray-btn">Cancel</button>
            <button onclick="saveStatus()" class="blue-btn">Yes</button>
        </div>
    </div>
</div>

<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('successModal')">&times;</span>
        <h5>Success!</h5>
        <p>Claiming status has been updated successfully.</p>
        <div class="modal-buttons">
            <button onclick="handleSuccessAndReload()" class="blue-btn">OK</button>
        </div>
    </div>
</div>

<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('errorModal')">&times;</span>
        <h5>Error</h5>
        <p>There was an error updating the status. Please try again.</p>
        <div class="modal-buttons">
            <button onclick="closeModal('errorModal')" class="blue-btn">OK</button>
        </div>
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

    function enableSaveButton() {
        const saveButton = document.getElementById('save-button');
        const dropdown = document.getElementById('status-dropdown');
        const currentValue = dropdown.value;
        const initialStatus = '{{ $transaction->claiming_status_id }}';
        
        // Enable save button only if the selected value is different from the current status
        saveButton.disabled = currentValue === initialStatus;
    }

    function showConfirmation() {
        openModal('confirmationModal');
    }

    function saveStatus() {
        const statusDropdown = document.getElementById('status-dropdown');
        const selectedStatus = statusDropdown.value;

        fetch('/update-claiming-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                transaction: {{ $transaction->id }},
                claiming_status_id: selectedStatus
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            closeModal('confirmationModal');
            if (data.success) {
                openModal('successModal');
                document.getElementById('save-button').disabled = true;

                if (selectedStatus === '2') {
                    statusDropdown.classList.add('text-gray');
                    statusDropdown.classList.remove('text-green');
                } else if (selectedStatus === '3') {
                    statusDropdown.classList.add('text-green');
                    statusDropdown.classList.remove('text-gray');
                }
            } else {
                openModal('errorModal');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            closeModal('confirmationModal');
            openModal('errorModal');
        });
    }
    async function handleSuccessAndReload() {
        closeModal('successModal');
        
        // Show loading state if needed
        document.body.style.cursor = 'wait';
        
        try {
            // Reload the current page data
            const response = await fetch(window.location.href);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            // Reload the page
            window.location.reload();
        } catch (error) {
            console.error('Error reloading:', error);
            document.body.style.cursor = 'default';
            // Optionally show an error message
            openModal('errorModal');
        }
    }



</script>

@endsection

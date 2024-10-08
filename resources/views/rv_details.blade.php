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
    @vite(['storage/app/public/css/details.css', 'storage/app/public/js/app.js'])

    <style>
        .click_files {
            align-items: center;
            justify-content: center;
            border: 2px dashed rgba(0, 0, 0, 1);
            border-radius: 4px;
            padding: 30px 20px 20px 20px;
            text-align: center;
            color: #999;
            cursor: pointer;
            background-color: white;
            margin-top: 0.3rem;
        }
        .click_files img {
            width: 100px;
            margin-right: 10px;
        }
        .photo {
            text-align: center;
            padding: 15px 0px 0px 0px;
        }
        .save_not_btn {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .save_not_btn .done {
            font-family: 'Poppins';
            background-color: #FFAD60;
            color: white;
            padding: 8px 16px; 
            border: none; 
            border-radius: 4px; 
            margin-right: 8px;
            width: 100px;
        }
        .done:hover {
            background-color: #FFD09B;
            color: white;
        }
        .save_not_btn .nav-link {
            text-decoration: none;
            font-family: 'Poppins';
            padding: 8px 16px; 
            border: none; 
            border-radius: 4px; 
            margin-right: 8px;
            width: 75px;
            background-color: #5077A5; 
            color: white;
            font-size: 14px;
            text-align: center;
            font-weight: 200;
        }
        .save_not_btn .nav-link:hover {
            background-color: rgba(53, 192, 247, 0.3);
            color: #09b3e4;
        }
        .docu {
            width: 100%;
            margin-left: 150px;
        }
        .edit {
            font-family: 'Poppins';
            font-size: 14px;
            background-color: #5077A5; 
            color: white; 
            padding: 8px 16px; 
            border: none; 
            border-radius: 4px; 
            margin-right: 8px;
            width: 100px;
            text-align: center;
            margin-left: 150px;
            margin-top: 20px;
            font-weight: 400;
        }
        .edit:hover {
            background-color: rgba(53, 192, 247, 0.3);
            color: #09b3e4;
        }
        .save {
            font-family: 'Poppins';
            font-size: 14px;
            background-color: #FFAD60;
            color: white;
            padding: 8px 16px; 
            border: none; 
            border-radius: 4px; 
            margin-right: 8px;
            width: 100px;
            text-align: center;
            margin-left: 135px;
            margin-top: 20px;
            font-weight: 400;
        }
        .save:hover {
            background-color: #FFD09B;
            color: white;
        }
        #save-button:disabled {
            cursor: not-allowed;        /* 'not-allowed' cursor */
            color: #b0b0b0;
            background-color:#f2f2f2;
        }
        .status-container {
            display: flex;
            align-items: center;
            background-color: #F0F0F0; /* Light grey background */
            padding: 8px;
            border-radius: 5px;
            font-family: 'Poppins';
            width: 330px;
        }

        .status-label {
            font-weight: bold;
            font-size: 14px;
            color: #566a7f; /* Dark navy color */
            margin-right: 15px;
            margin-left: 20px;
        }

        .status-input {
            font-family: 'Poppins';
            border: 1px solid #CCC;
            padding: 5px;
            border-radius: 4px;
            width: 200px; /* Adjust the width as needed */
            height: 24px;
            font-weight: 600;
            color: #566a7f;
        }
        .text-green {
            color: green;
        }
    </style>
</head>

<!-- Displaying Violation Information -->
<div class="sec-title">
    <h2 class="section-title">Violation Information</h2>
    <h2 class="section-title">Proof Image</h2>
</div>
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
            <span class="deets">{{ $violation->created_at }}</span>
        </li>
        <li>
            <span>Location:</span>
            <span class="deets">{{ $violation->vehicle->location ?? 'Unknown' }}</span>
        </li>        
    </ul>

    <ul>
        @if (!empty($violation->settle_violation->proof_image))
            <img src="data:image/jpeg;base64,{{ base64_encode(Crypt::decrypt($violation->settle_violation->proof_image)) }}" alt="Proof Image" style="width: 300px; height: 500px;">
        @else
            <p style="font-size: 14px; color:#566a7f;">No proof image available.</p>
        @endif
    </ul>
    
</div>

@endsection

@section('content-2')
<div class="sec-title">
    <h2 class="section-title">Document</h2>
</div>

<div class="owner-info">
    <ul>
    @if (empty($violation->settle_violation->document))
    <form action="{{ route('settle_violation.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="violation_id" value="{{ $violation->id }}">
        
        <div class="click_files" id="click-files">
            <img src="{{ Vite::asset('storage/app/public/images/upload 1.png') }}" alt="Upload icon" id="upload-icon">
            <div class="file-label">
                <label for="files">Click to Attach Document</label>
            </div>
            <input type="file" id="files" name="document" accept="image/*" style="display: none;" required>
        </div>

        <div class="save_not_btn">
            <a class="nav-link" href="{{ url('/reported_violations') }}">BACK</a>
            <button type="submit" id="submit" class="done">SAVE</button>
        </div>
    </form>
    @else
        <!-- Display uploaded document -->
        <div class="docu">
            <img src="data:image/jpeg;base64,{{ base64_encode(Crypt::decrypt($violation->settle_violation->document)) }}" alt="Uploaded Document" style="width: 350px; height: 550px;" id="uploaded-document">
        </div>

        <!-- Form for Updating the Document -->
        <form id="edit-form" action="{{ route('settle_violation.store') }}" method="POST" enctype="multipart/form-data">
        <button type="button" id="edit-button" class="edit">EDIT</button>
            @csrf
            <!-- Hidden Violation ID and File Input -->
            <input type="hidden" name="violation_id" value="{{ $violation->id }}">
            <input type="file" id="new-document" name="document" accept="image/jpeg,image/png" style="display:none;">
            
            <!-- Save Button (Initially disabled) -->
            <button type="submit" id="save-button" class="save" disabled>SAVE</button>
        </form>
    @endif
    </ul>
    <ul>
        <div class="status-container">
            <label class="status-label">STATUS:</label>
            <a class="status-input {{ $violation->remarks === 'Settled' ? 'text-green' : ($violation->remarks === 'Not Been Settled' ? 'text-gray' : '') }}">
                {{ $violation->remarks }}
            </a>
        </div>
    </ul>
</div>

<script>
    // Make the entire div clickable to trigger file selection
    document.getElementById('click-files')?.addEventListener('click', function() {
        document.getElementById('files').click(); // Trigger the hidden file input
    });

    // Replace the "upload 1.png" with the selected image
    document.getElementById('files')?.addEventListener('change', function(event) {
        const file = event.target.files[0]; // Get the selected file
        const uploadIcon = document.getElementById('upload-icon');
        
        if (file) {
            // Create an object URL to display the image preview
            uploadIcon.src = URL.createObjectURL(file);
            uploadIcon.style.width = '350px';  // Adjust the width of the preview
            uploadIcon.style.height = '550px'; // Adjust the height of the preview
            
            uploadIcon.onload = function() {
                URL.revokeObjectURL(uploadIcon.src); // Free memory after loading
            };
        }
    });

    // Trigger the file input when the "Edit Document" button is clicked
    document.getElementById('edit-button').addEventListener('click', function() {
        document.getElementById('new-document').click(); // Open file selection dialog
    });

    // Handle file selection and enable the Save button
    document.getElementById('new-document').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const uploadedDocument = document.getElementById('uploaded-document');
            uploadedDocument.src = URL.createObjectURL(file); // Update image preview

            // Release the memory after loading the new preview image
            uploadedDocument.onload = function() {
                URL.revokeObjectURL(uploadedDocument.src);
            };

            // Enable the Save button after selecting a new document
            document.getElementById('save-button').disabled = false;
        }
    });
</script>

@endsection
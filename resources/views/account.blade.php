@extends('layouts.main1')

@section('title', 'Account Details')

@section('title-details')
<div class="account-details">
    <h1>Account Details</h1>
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
    
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ url()->previous() }}" class="btn btn-back">Back</a>
    </div>

    <div class="profile-info">
        <h2>Profile Information</h2>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Full Name:</strong> {{ $user->authorized_user->fname }} {{ $user->authorized_user->mname }} {{ $user->authorized_user->lname }}</p>
        <p><strong>Employee Number:</strong> {{ $user->authorized_user->employee->emp_no }}</p>
        <p><strong>Created At:</strong> {{ $user->created_at->format('F d, Y') }}</p>
    </div>
@endsection

@section('content-2')
    <div class="update-profile">
        <h2>Update Profile</h2>
        <form action="{{ route('updateProfile') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="{{ old('fname', $user->authorized_user->fname) }}" required>
                @error('fname')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mname">Middle Name:</label>
                <input type="text" id="mname" name="mname" value="{{ old('mname', $user->authorized_user->mname) }}">
                @error('mname')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="{{ old('lname', $user->authorized_user->lname) }}" required>
                @error('lname')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>

    <div class="change-password">
        <h2>Change Password</h2>
        <form action="{{ route('changePassword') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
                @error('current_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                @error('new_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password:</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>
            
            <button type="submit" class="btn">Change Password</button>
        </form>
    </div>
</div>
@endsection


@extends('layouts.main')

@section('title', 'Account Details')

@section('title-details')
<div class="title-details">
    <h1>Account Details</h1>
</div>
@endsection

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="{{ asset('storage/css/details.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script> -->
    @vite(['resources/css/details.css', 'resources/css/app.css', 'resources/js/app.js', 'resources/js/new_pass_toggle.js'])
</head>

<div class="sec-title">
    <h2 class="section-title">Profile Information</h2>
    <h2 class="section-title">Change Password</h2>
</div>

<div class="owner-info">
    <ul>
        <li>
            <span>Email:</span>
            <span class="deets">{{ $user->email }}</span>
        </li>
        <li>
            <span>Full Name:</span>
            <span class="deets">{{ $user->authorized_user->fname }} {{ $user->authorized_user->mname }} {{ $user->authorized_user->lname }}</span>
        </li>
        <li>
            <span>Employee Number:</span>
            <span class="deets">{{ $user->authorized_user->employee->emp_no }}</span>
        </li>
        <li>
            <span>Account Created At:</span>
            <span class="deets">{{ $user->created_at->format('F d, Y') }}</span>
        </li>
    </ul>
    <ul>
        <form action="{{ route('changePassword') }}" method="POST">
            @csrf
            @method('PUT')
            
            <li>
                <span>Current Password:</span>
                <input class="deets" style="text-align: left; font-size: 14px;" type="password" id="current_password" name="current_password" required>
                <i class="fas fa-eye-slash eye-icon" aria-hidden="true" onclick="togglePassword('current_password')"></i>
                @error('current_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </li>
            
            <li>
                <span>New Password:</span>
                <input class="deets" style="text-align: left; font-size: 14px;" type="password" id="new_password" name="new_password" required>
                <i class="fas fa-eye-slash eye-icon" aria-hidden="true" onclick="togglePassword('new_password')"></i>
                @error('new_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </li>
            
            <li>
                <span>Confirm New Password:</span>
                <input class="deets" style="text-align: left; font-size: 14px;" type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                <i class="fas fa-eye-slash eye-icon" aria-hidden="true" onclick="togglePassword('new_password_confirmation')"></i>
            </li>
            
            <button type="submit" class="btn-save">Change</button>
        </form>
    </ul>
</div>
@endsection

@section('content-2')
<!-- <div class="sec-title">
    <h2 class="section-title">Update Profile</h2>
</div>

<div class="owner-info">
    <ul>  
        <form action="{{ route('updateProfile') }}" method="POST">
            @csrf
            @method('PUT') 
                <li>     
                    <span>Email:</span>
                    <input class="deets" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </li>
                
                <li>
                    <span>First Name:</span>
                    <input class="deets" type="text" id="fname" name="fname" value="{{ old('fname', $user->authorized_user->fname) }}" required>
                    @error('fname')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </li>

                <li>
                    <span>Middle Name:</span>
                    <input class="deets" type="text" id="mname" name="mname" value="{{ old('mname', $user->authorized_user->mname) }}">
                    @error('mname')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </li>
            
                <li>
                    <span>Last Name:</span>
                    <input class="deets" type="text" id="lname" name="lname" value="{{ old('lname', $user->authorized_user->lname) }}" required>
                    @error('lname')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </li>
                
                <button type="submit" class="btn">Update Profile</button>
       </form>
    </ul>
 -->

<!-- <div class="sec-title">
    <h2 class="section-title">Change Password</h2>
</div> -->

<!-- <div class="owner-info">
    
</div> -->
@endsection

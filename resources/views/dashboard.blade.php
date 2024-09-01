@extends('layouts.main1')

@section('title', 'Dashboard')

@section('header', 'Dashboard Header')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/app1.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="cont">
        <div class="box">
            <div class="row">
                <span class="stat-num">{{ $pendingApplications }}</span>
                <span class="stat-label">Pending Applications To Be Reviewed</span>
            </div>      
        </div>
        <div class="box">
            <div class="row">
                    <span class="stat-num">{{ $registeredVehicles }}</span>
                    <span class="stat-label">Registered Vehicles This Month</span>       
            </div>     
        </div>
        <div class="box">
            <div class="row">
                <span class="stat-num">{{ $violationsToBeReviewed }}</span>
                <span class="stat-label">Violations To Be Reviewed</span>
            </div>
        </div>
        <div class="box">
            <div class="row">
                <span class="stat-num">{{ $reportedViolationsThisMonth }}</span>
                <span class="stat-label">Reported Violations This Month</span>
            </div>
        </div>
        <div class="box">Column 3 (twice the size)</div>
    </div>
    <div class="cont-2">
        <div class="box-2">
            <h1 class="page-title">Pending Sticker and Card Pickup</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th class="th-class">Full Name</th>
                        <th class="th-class">Registration No.</th>
                        <th class="th-class">Date Issued</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach($pendingPickups as $transaction)
                        <tr>
                            <td class="td-class">
                                {{ $transaction->vehicle->vehicle_owner->fname }} 
                                {{ $transaction->vehicle->vehicle_owner->mname }} 
                                {{ $transaction->vehicle->vehicle_owner->lname }}
                            </td>
                            <td class="td-class">{{ $transaction->registration_no }}</td>
                            <td class="td-class">{{ $transaction->issued_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                <div>
                    Showing {{ $pendingPickups->firstItem() }} to {{ $pendingPickups->lastItem() }} of {{ $pendingPickups->total() }} entries
                </div>
            </div>
        </div>
        <div class="box-2">
            <h1 class="page-title">Unsettled Violations</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th class="th-class">Plate No.</th>
                        <th class="th-class">Violation</th>
                        <th class="th-class">Date Issued</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                        @foreach($unsettledViolations as $violation)
                        <tr>
                            <td class="td-class">{{ $violation->vehicle->plate_no }}</td>
                            <td class="td-class">{{ $violation->violation_type->violation_name }}</td>
                            <td class="td-class">{{ $violation->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                <div>
                    Showing {{ $unsettledViolations->firstItem() }} to {{ $unsettledViolations->lastItem() }} of {{ $unsettledViolations->total() }} entries
                </div>
            </div>
        </div>
    </div>
</body>



@endsection
@extends('layouts.main')

@section('title', 'All Users')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('storage/css/pending-applications.css') }}"> -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    @vite(['resources/css/pending-applications.css', 'resources/js/app.js'])
</head>

<div class="table-container">
    <div class="heading">
        <h1 class="page-title">All Users</h1>
        <div>
            <form action="{{ route('all_users') }}" method="GET" style="display: inline;">
                <button type="submit" name="export" value="csv" class="buttons">
                    Export as CSV
                </button>
            </form>
            <form action="{{ route('exportAllUserDetailsToCSV') }}" method="GET" style="display: inline;">
                <button type="submit" class="buttons">Export All Details to CSV</button>
            </form>
        </div>
    </div>

    <!-- Search and Filter Inputs -->
    <div style="display: flex; gap: 8px;">
        <input type="text" id="searchInput" placeholder="Search by name or applicant type" class="search-input">

        <select id="applicantFilter" class="filter-select">
            <option value="">Applicant Type</option>
            <option value="1">Student</option>
            <option value="2">BU-personnel</option>
            <option value="3">Non-Personnel</option>
            <option value="4">VIP</option>
        </select>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="th-class">Full Name</th>
                <th class="th-class">Email</th>
                <th class="th-class">Type</th>
                <th class="th-class">Registration No/s.</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach ($data as $row)
                <tr style="cursor: pointer;" onclick="window.location='{{ route('au_details', ['id' => $row->id]) }}'">
                    <td class="td-class">{{ $row->fname . ' ' . $row->mname . ' ' . $row->lname }}</td>
                    <td class="td-class">{{ $row->users->email ?? 'No email' }}</td>
                    <td class="td-class">
                        <span style="
                            color: {{ 
                                match($row->applicant_type->type) {
                                    'Student' => '#FCFAEE',
                                    'BU-personnel' => '#F4F6FF',
                                    'Non-Personnel' => '#09b3e4',
                                    'VIP' => '#F5F5F7',
                                    default => 'black'
                                }
                            }};
                            background-color: {{ 
                                match($row->applicant_type->type) {
                                    'Student' => '#FFAD60',
                                    'BU-personnel' => '#040044',
                                    'Non-Personnel' => '#D1E9F6',
                                    'VIP' => '#808080',
                                    default => 'black'
                                }
                            }};
                            padding: 4px 8px;
                            border-radius: 4px;
                            display: inline-block;
                            font-weight: bold;
                            font-size: 11px;
                        ">{{ $row->applicant_type->type ?? 'Unknown' }}</td>
                    <td class="td-class">
                        @php
                            $registrationNumbers = [];
                            foreach ($row->vehicle as $vehicle) {
                                foreach ($vehicle->transaction as $transaction) {
                                    if (!empty($transaction->registration_no)) {
                                        $registrationNumbers[] = $transaction->registration_no;
                                    }
                                }
                            }
                            echo implode(', ', $registrationNumbers);
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        <div>
            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
        </div>
        <div class="page-btns"> 
            @if($data->onFirstPage())
                <button class="page-btn" disabled>&laquo; Previous</button>
            @else
                <a href="{{ $data->previousPageUrl() }}">&laquo; Previous</a>
            @endif

            @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                @if ($page == $data->currentPage())
                    <button class="pg-active" disabled>{{ $page }}</button>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}">Next &raquo;</a>
            @else
                <button class="page-btn" disabled>Next &raquo;</button>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', filterTable);
    document.getElementById('applicantFilter').addEventListener('change', filterTable);

    function filterTable() {
        let searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        let applicantValue = document.getElementById('applicantFilter').value;
        
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let fullName = row.cells[0].textContent.toLowerCase();
            let applicantType = row.cells[2].textContent.toLowerCase();
        
            let matchesSearch = fullName.includes(searchValue) || applicantType.includes(searchValue);
            let matchesApplicant = applicantValue === '' ||
                (applicantValue === '1' && applicantType.includes('student')) ||
                (applicantValue === '2' && (applicantType.includes('bu-personnel') || applicantType.includes('bu personnel'))) ||
                (applicantValue === '3' && (applicantType.includes('non-personnel') || applicantType.includes('non personnel'))) ||
                (applicantValue === '4' && applicantType.includes('vip'));
            
            if (matchesSearch && matchesApplicant) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection

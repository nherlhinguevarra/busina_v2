@extends('layouts.main')

@section('title', 'Registered Vehicles')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('storage/css/pending-applications.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script> -->
    @vite(['resources/css/pending-applications.css', 'resources/js/app.js'])
</head>

<div class="table-container">
    <div class="heading">
        <h1 class="page-title">Registered Vehicles</h1>
        <div>
            <form action="{{ route('registered_vehicles') }}" method="GET" style="display: inline;">
                <button type="submit" name="export" value="csv" class="buttons">
                    Export as CSV
                </button>
            </form>
            <form action="{{ route('exportAllRegDetailsToCSV') }}" method="GET" style="display: inline;">
                <button type="submit" class="buttons">Export All Details to CSV</button>
            </form>
        </div>
    </div>
    <!-- Search and Filter Inputs -->
    <div style="display: flex; gap: 8px;">
        <input type="text" id="searchInput" placeholder="Search by registration no or plate no" class="search-input">
        
        <!-- Year Filter -->
        <select id="yearFilter" class="filter-select">
            <option value="">Select Year</option>
            @foreach(range(date('Y'), 2000) as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
        
        <!-- Month Filter -->
        <select id="monthFilter" class="filter-select">
            <option value="">Select Month</option>
            @foreach(range(1, 12) as $month)
                <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
            @endforeach
        </select>
        
        <!-- Day Filter -->
        <select id="dayFilter" class="filter-select">
            <option value="">Select Day</option>
            @foreach(range(1, 31) as $day)
                <option value="{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}">{{ $day }}</option>
            @endforeach
        </select>

        <!-- Claiming Status Filter -->
        <select id="claimingStatusFilter" class="filter-select">
            <option value="">Status</option>
            <option value="2">To Claim</option>
            <option value="3">Claimed</option>
        </select>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="th-class">Registration No</th>
                <th class="th-class">Plate No</th>
                <th class="th-class">Date Issued</th>
                <th class="th-class">Claiming Status</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach ($data as $row)
                        <tr style="cursor: pointer;" onclick="window.location='{{ route('reg_details', ['id' => $row->id]) }}'">
                            <td class="td-class">{{ $row->registration_no }}</td>
                            <td class="td-class">{{ $row->vehicle->plate_no }}</td>
                            <td class="td-class">{{ $row->issued_date }}</td>
                            <td class="td-class">
                                <span style="
                                    color: {{
                                        match($row->claiming_status->status) {
                                            'To Claim' => '#797501',
                                            'Claimed' => '#097901',
                                        }
                                    }};
                                    background-color: {{ 
                                        match($row->claiming_status->status) {
                                            'To Claim' => '#FAFFB8',
                                            'Claimed' => '#B9FFB8'
                                        }
                                    }};
                                    padding: 4px 8px;
                                    border-radius: 4px;
                                    display: inline-block;
                                    font-weight: bold;
                                    font-size: 11px;
                                ">{{ $row->claiming_status->status ?? 'Unknown' }}</td>
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
    document.getElementById('yearFilter').addEventListener('change', filterTable);
    document.getElementById('monthFilter').addEventListener('change', filterTable);
    document.getElementById('dayFilter').addEventListener('change', filterTable);
    document.getElementById('claimingStatusFilter').addEventListener('change', filterTable);

    function filterTable() {
        let searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        let yearValue = document.getElementById('yearFilter').value;
        let monthValue = document.getElementById('monthFilter').value;
        let dayValue = document.getElementById('dayFilter').value;
        let claimingStatusValue = document.getElementById('claimingStatusFilter').value;
        
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let registrationNo = row.cells[0].textContent.toLowerCase();
            let plateNo = row.cells[1].textContent.toLowerCase();
            let dateIssued = row.cells[2].textContent;
            let claimingStatus = row.cells[3].textContent;
            
            let dateParts = dateIssued.split(' ')[0].split('-');
            let year = dateParts[0];
            let month = dateParts[1];
            let day = dateParts[2];
            
            let matchesSearch = registrationNo.includes(searchValue) || plateNo.includes(searchValue);
            let matchesYear = yearValue === '' || year === yearValue;
            let matchesMonth = monthValue === '' || month === monthValue;
            let matchesDay = dayValue === '' || day === dayValue;
            let matchesClaimingStatus = claimingStatusValue === '' || 
                (claimingStatusValue === '2' && claimingStatus.trim() === 'To Claim') ||
                (claimingStatusValue === '3' && claimingStatus.trim() === 'Claimed');
            
            if (matchesSearch && matchesYear && matchesMonth && matchesDay && matchesClaimingStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

</script>
@endsection
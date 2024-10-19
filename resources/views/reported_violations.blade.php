@extends('layouts.main')

@section('title', 'Reported Violations')

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
        <h1 class="page-title">Reported Violations</h1>
        <div>
            <form action="{{ route('reported_violations') }}" method="GET" style="display: inline;">
                <button type="submit" name="export" value="csv" class="buttons">
                    Export as CSV
                </button>
            </form>
            <form action="{{ route('exportAllVioDetailsToCSV') }}" method="GET" style="display: inline;">
                <button type="submit" class="buttons">Export All Violations to CSV</button>
            </form>
        </div>
    </div>
    <!-- Search and Filter Inputs -->
    <div style="margin-bottom: 16px; display: flex; gap: 8px;">
        <input type="text" id="searchInput" placeholder="Search by plate no or violation type" class="search-input">
        
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
    </div>

    <table class="table">
        <thead>
            <tr>
                <th class="th-class">Plate No</th>
                <th class="th-class">Violation Type</th>
                <th class="th-class">Created At</th>
                <th class="th-class">Remarks</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach ($data as $row)
                <tr style="cursor: pointer;" onclick="window.location='{{ route('rv_details', ['id' => $row->id]) }}'">
                    <td class="td-class">{{ $row->plate_no }}</td>
                    <td class="td-class">{{ $row->violation_type->violation_name ?? 'Unknown' }}</td>
                    <td class="td-class">{{ $row->created_at }}</td>
                    <td class="td-class">{{ $row->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        <div>
            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', filterTable);
    document.getElementById('yearFilter').addEventListener('change', filterTable);
    document.getElementById('monthFilter').addEventListener('change', filterTable);
    document.getElementById('dayFilter').addEventListener('change', filterTable);

    function filterTable() {
        let searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        let yearValue = document.getElementById('yearFilter').value;
        let monthValue = document.getElementById('monthFilter').value;
        let dayValue = document.getElementById('dayFilter').value;
        
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let plateNo = row.cells[0].textContent.toLowerCase();
            let violationType = row.cells[1].textContent.toLowerCase();
            let dateCreated = row.cells[2].textContent;
            
            let dateParts = dateCreated.split(' ')[0].split('-');
            let year = dateParts[0];
            let month = dateParts[1];
            let day = dateParts[2];
            
            let matchesSearch = plateNo.includes(searchValue) || violationType.includes(searchValue);
            let matchesYear = yearValue === '' || year === yearValue;
            let matchesMonth = monthValue === '' || month === monthValue;
            let matchesDay = dayValue === '' || day === dayValue;
            
            if (matchesSearch && matchesYear && matchesMonth && matchesDay) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection

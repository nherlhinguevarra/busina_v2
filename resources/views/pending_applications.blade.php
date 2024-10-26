@extends('layouts.main')

@section('title', 'Vehicle Owners')

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

<div id="notification" class="notification-box hidden">
    <span class="message"></span>
    <button class="close-btn" onclick="closeNotification()" style="color: #347928;">×</button>
</div>

<div class="table-container">
    <div class="heading">
        <h1 class="page-title">Pending Applications</h1>
        <div>
            <form action="{{ route('pending_applications') }}" method="GET" style="display: inline;">
                <button type="submit" name="export" value="csv" class="buttons">
                    Export as CSV
                </button>
            </form>
            <form action="{{ route('exportAllAppDetailsToCSV') }}" method="GET" style="display: inline;">
                <button type="submit" class="buttons">Export All Details to CSV</button>
            </form>
        </div>
    </div>
    <!-- Search and Filter Inputs -->
    <div style="display: flex; gap: 8px;">
        <input type="text" id="searchInput" placeholder="Search by name or applicant type" class="search-input">
        
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

        <select id="applicantFilter" class="filter-select">
            <option value="">Applicant</option>
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
                <th class="th-class">Applicant Type</th>
                <th class="th-class">Date and Time Submitted</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach ($data as $row)
                <tr style="cursor: pointer;" onclick="window.location='{{ route('pa_details', ['id' => $row->id]) }}'">
                    <td class="td-class">{{ $row->fname . ' ' . $row->mname . ' ' . $row->lname }}</td>
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
                    <td class="td-class">{{ $row->created_at }}</td>
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
    // Function to show the notification
    function showNotification(message) {
        const notification = document.getElementById('notification');
        notification.querySelector('.message').textContent = message;
        notification.classList.remove('hidden');
        
        // Slide the notification in
        setTimeout(function() {
            notification.classList.add('slide-in');
        }, 100); // Small delay for better effect
        
        // Automatically hide the notification after 5 seconds
        setTimeout(function() {
            closeNotification();
        }, 5000);
    }

    // Function to close the notification manually
    function closeNotification() {
        const notification = document.getElementById('notification');
        
        // Slide the notification out
        notification.classList.remove('slide-in');
        notification.classList.add('slide-out');
        
        // After the slide-out animation, hide the notification
        setTimeout(function() {
            notification.classList.add('hidden');
            notification.classList.remove('slide-out'); // Reset for future use
        }, 500); // Match the transition time
    }

    // Check for session messages (if you are using Laravel's session flash)
    @if (session('success'))
        showNotification('{{ session('success') }}');
    @endif

    // Add event listeners to filters
    document.getElementById('searchInput').addEventListener('keyup', filterTable);
    document.getElementById('yearFilter').addEventListener('change', filterTable);
    document.getElementById('monthFilter').addEventListener('change', filterTable);
    document.getElementById('dayFilter').addEventListener('change', filterTable);
    document.getElementById('applicantFilter').addEventListener('change', filterTable);

    function filterTable() {
        let searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        let yearValue = document.getElementById('yearFilter').value;
        let monthValue = document.getElementById('monthFilter').value;
        let dayValue = document.getElementById('dayFilter').value;
        let applicantValue = document.getElementById('applicantFilter').value;
        
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let fullName = row.cells[0].textContent.toLowerCase();
            let applicantType = row.cells[1].textContent.toLowerCase();
            let dateSubmitted = row.cells[2].textContent;
            
            let dateParts = dateSubmitted.split(' ')[0].split('-');
            let year = dateParts[0];
            let month = dateParts[1];
            let day = dateParts[2];
            
            let matchesSearch = fullName.includes(searchValue) || applicantType.includes(searchValue);
            let matchesYear = yearValue === '' || year === yearValue;
            let matchesMonth = monthValue === '' || month === monthValue;
            let matchesDay = dayValue === '' || day === dayValue;
            let matchesApplicant = applicantValue === '' ||
                (applicantValue === '1' && applicantType.includes('student')) ||
                (applicantValue === '2' && (applicantType.includes('bu-personnel') || applicantType.includes('bu personnel'))) ||
                (applicantValue === '3' && (applicantType.includes('non-personnel') || applicantType.includes('non personnel'))) ||
                (applicantValue === '4' && applicantType.includes('vip'));
            
            if (matchesSearch && matchesYear && matchesMonth && matchesDay && matchesApplicant) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
}
</script>

@endsection
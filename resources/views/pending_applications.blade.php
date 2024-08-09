@extends('layouts.main')

@section('title', 'Vehicle Owners')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('storage/css/pending-applications.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<div class="container" style="margin: 20px auto; padding: 16px; max-width: 1200px;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 16px;">Pending Applications</h1>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Full Name</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Applicant Type</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Date and Time Submitted</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr style="cursor: pointer;" onclick="window.location='{{ route('pa_details', ['id' => $row->id]) }}'">
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $row->fname . ' ' . $row->mname . ' ' . $row->lname }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $row->applicant_type->type ?? 'Unknown' }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $row->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
    <form action="{{ route('pending_applications') }}" method="GET" style="margin-top: 16px;">
        <button type="submit" name="export" value="csv" style="background-color: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px;">
            Export as CSV
        </button>
    </form>
    <form action="{{ route('exportAllDetailsToCSV') }}" method="GET">
        <button type="submit" style="background-color: #007bff; color: white; padding: 8px 16px; border: none; border-radius: 4px;">Export All Details to CSV</button>
    </form>
</div>
@endsection

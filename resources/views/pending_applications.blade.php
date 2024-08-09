@extends('layouts.main')

@section('title', 'Pending Applications')

@section('content')
<div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Data Table</h1>

        <table class="table-auto w-full border-collapse border border-gray-200 mb-4">
            <thead>
                <tr>
                    <th class="border border-gray-200 px-4 py-2">Column 1</th>
                    <th class="border border-gray-200 px-4 py-2">Column 2</th>
                    <th class="border border-gray-200 px-4 py-2">Column 3</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr class="hover:bg-gray-100 cursor-pointer" onclick="window.location='{{ route('details', ['id' => $row->id]) }}'">
                        <td class="border border-gray-200 px-4 py-2">{{ $row->column1 }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $row->column2 }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $row->column3 }}</td>
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Details -->
        <div class="flex justify-between items-center">
            <div>
                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
            </div>
            <div>
                {{ $data->links() }}
            </div>
        </div>

        <!-- Export Button -->
        <form action="{{ route('data-table') }}" method="GET">
            <button type="submit" name="export" value="csv" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Export as CSV
            </button>
        </form>
    </div>
@endsection
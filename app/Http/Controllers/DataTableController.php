<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function index(Request $request)
    {
        // Fetching data with pagination
        $perPage = 10;
        $data = Vehicle::paginate($perPage); // Replace YourModel with your actual model

        // Check if the request is for a CSV export
        if ($request->query('export') === 'csv') {
            return $this->exportToCSV($data);
        }

        return view('data-table', compact('data'));
    }

    private function exportToCSV($data)
    {
        $csvFileName = 'data-export.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$csvFileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            // Add headers
            fputcsv($handle, ['Column1', 'Column2', 'Column3']); // Add your actual column names

            // Add rows
            foreach ($data as $row) {
                fputcsv($handle, [$row->column1, $row->column2, $row->column3]); // Replace with your actual column names
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}

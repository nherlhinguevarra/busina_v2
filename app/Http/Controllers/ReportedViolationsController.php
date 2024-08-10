<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\ViolationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportedViolationsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        // Fetch violations with related violation type
        $data = Violation::with('violation_type')->paginate($perPage);

        if ($request->query('export') === 'csv') {
            return $this->exportToCSV($data);
        }

        return view('reported_violations', compact('data'));
    }

    private function exportToCSV($data)
    {
        $csvFileName = 'reported_violations.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$csvFileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, [
                'Plate No', 'Violation Name', 'Created At', 'Remarks'
            ]);

            foreach ($data as $violation) {
                // Write each row of violation details to the CSV
                fputcsv($handle, [
                    $violation->plate_no,
                    $violation->violation_type->violation_name ?? 'Unknown',
                    $violation->created_at,
                    $violation->remarks
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportAllDetailsToCSV()
    {
        // Fetch all violations with related violation_type and authorized_user
        $violations = Violation::with([
            'violation_type', // Load violation type
            'authorized_user', // Load the authorized user who reported the violation
            'vehicle' // Load related vehicle information
        ])->get();

        $csvFileName = 'reported_violations_details.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$csvFileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($violations) {
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, [
                'Plate No', 'Violation Name', 'Created At', 'Remarks',
                'Location', 'Reported By (Full Name)'
            ]);

            foreach ($violations as $violation) {
                // Write each row of violation details to the CSV
                fputcsv($handle, [
                    $violation->vehicle->plate_no,
                    $violation->violation_type->violation_name ?? 'Unknown',
                    $violation->created_at,
                    $violation->remarks,
                    $violation->vehicle->location ?? 'Unknown',
                    $violation->authorized_user->fname . ' ' . $violation->authorized_user->mname . ' ' . $violation->authorized_user->lname
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function showDetails($id)
    {
        // Fetch the violation details with related data
        $violation = Violation::with([
            'vehicle',
            'violation_type',
            'authorized_user',
            'settle_violation'
        ])->findOrFail($id);

        return view('rv_details', compact('violation'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Vehicle_owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AllUsersController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        // Fetch data with necessary relationships
        $data = Vehicle_owner::with(['users', 'applicant_type', 'vehicle.transaction'])
            ->paginate($perPage);

        if ($request->query('export') === 'csv') {
            return $this->exportToCSV($data);
        }

        return view('all_users', compact('data'));
    }

    private function exportToCSV($data)
    {
        $csvFileName = 'all_users_data.csv';
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
                'Full Name', 'Email', 'Applicant Type', 
                'Registration No', 'Issued Date'
            ]);

            foreach ($data as $row) {
                // Fetch the user associated with the vehicle_owner_id
                $userEmail = $row->users ? $row->users->email : 'Unknown';
                
                foreach ($row->vehicle as $vehicle) {
                    foreach ($vehicle->transaction as $transaction) {
                        fputcsv($handle, [
                            $row->fname . ' ' . $row->mname . ' ' . $row->lname,
                            $userEmail,
                            $row->applicant_type->type ?? 'Unknown',
                            $transaction->registration_no ?? 'Unknown',
                            $transaction->issued_date ?? 'Unknown'
                        ]);
                    }
                }
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportAllDetailsToCSV()
    {
        $owners = Vehicle_owner::with([
            'users',
            'applicant_type',
            'vehicle.transaction'
        ])->get();

        $csvFileName = 'all_users_details.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$csvFileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($owners) {
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, [
                'Full Name', 'Email', 'Applicant Type', 
                'Registration No', 'Issued Date', 
                'Contact No', 'Employee ID', 'Student ID', 'QR Code'
            ]);

            foreach ($owners as $owner) {
                // Fetch the user associated with the vehicle_owner_id
                $userEmail = $owner->users ? $owner->users->email : 'Unknown';
                
                foreach ($owner->vehicle as $vehicle) {
                    foreach ($vehicle->transaction as $transaction) {
                        fputcsv($handle, [
                            $owner->fname . ' ' . $owner->mname . ' ' . $owner->lname,
                            $userEmail,
                            $owner->applicant_type->type ?? 'Unknown',
                            $transaction->registration_no ?? 'Unknown',
                            $transaction->issued_date ?? 'Unknown',
                            $owner->contact_no ?? 'Unknown',
                            $owner->emp_id ?? 'Unknown',
                            $owner->std_id ?? 'Unknown',
                            base64_encode($owner->qr_code) ?? 'Unknown'
                        ]);
                    }
                }
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function showDetails($id)
    {
        // Load vehicle_owner with related user, applicant_type, vehicles, and transactions
        $item = Vehicle_owner::with([
            'users',
            'applicant_type',
            'vehicle.transaction'
        ])->findOrFail($id);

        $sortedVehicles = $item->vehicle->sortBy('created_at');

        $userEmail = $item->users ? $item->users->email : 'Unknown';

        return view('au_details', compact('item', 'userEmail', 'sortedVehicles'));
    }
}

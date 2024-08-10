<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Vehicle_owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RegisteredVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        // Fetch transactions with related claiming status and vehicle
        $data = Transaction::with(['claiming_status', 'vehicle'])
                    ->paginate($perPage);

        if ($request->query('export') === 'csv') {
            return $this->exportToCSV($data);
        }

        return view('registered_vehicles', compact('data'));
    }


    private function exportToCSV($data)
    {
        $csvFileName = 'vehicle-owner-data.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$csvFileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Registration No', 'Plate No', 'Issued Date', 'Claiming Status']);
            foreach ($data as $row) {
                    $registrationNo = $row->registration_no;
                    $plateNo = $row->vehicle->plate_no;
                    $issuedDate = $row->issued_date;
                    $claimingStatus = $row->claiming_status->status ?? 'Unknown';
                    fputcsv($handle, [$registrationNo, $plateNo, $issuedDate, $claimingStatus]);
                    
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportAllDetailsToCSV()
    {
        $owners = Vehicle_owner::with([
            'applicant_type',
            'vehicle.vehicle_type',
            'vehicle.transaction.claiming_status'
        ])->get();

        $csvFileName = 'vehicle_owner_details.csv';
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
                'Full Name', 'Registration No', 'Plate No', 'Issued Date', 'Claiming Status', 
                'Contact No', 'QR Code', 'Employee ID', 'Student ID', 'Driver License No', 
                'Applicant Type', 'Created At', 'Model Color', 'Expiry Date', 
                'Copy of Driver License', 'Copy of COR', 'Copy of School ID', 
                'OR No', 'CR No', 'Copy of OR/CR', 'Vehicle Type', 'Reference No'
            ]);

            foreach ($owners as $owner) {
                foreach ($owner->vehicle as $vehicle) {
                    foreach ($vehicle->transaction as $transaction) {
                        // Write each row of owner and vehicle details to the CSV
                        fputcsv($handle, [
                            $owner->fname . ' ' . $owner->mname . ' ' . $owner->lname,
                            $transaction->registration_no,
                            $vehicle->plate_no,
                            $transaction->issued_date,
                            $transaction->claiming_status->status ?? 'Unknown',
                            $owner->contact_no,
                            $owner->qr_code,
                            $owner->emp_id,
                            $owner->std_id,
                            $owner->driver_license_no,
                            $owner->applicant_type->type ?? 'Unknown',
                            $owner->created_at,
                            $vehicle->model_color,
                            $vehicle->expiry_date,
                            $vehicle->copy_driver_license,
                            $vehicle->copy_cor,
                            $vehicle->copy_school_id,
                            $vehicle->or_no,
                            $vehicle->cr_no,
                            $vehicle->copy_or_cr,
                            $vehicle->vehicle_type->type ?? 'Unknown',
                            $transaction->reference_no
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
        // Load transaction with related vehicle_owner, vehicle, and claiming_status
        $transaction = Transaction::with([
            'vehicle.vehicle_owner', // Load vehicle owner
            'vehicle.vehicle_type', // Load vehicle type
            'claiming_status' // Load claiming status
        ])->findOrFail($id);

        return view('reg_details', ['transaction' => $transaction]);
    }

}

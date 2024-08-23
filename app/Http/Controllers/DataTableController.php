<?php

namespace App\Http\Controllers;

use App\Models\Vehicle_owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class DataTableController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $data = Vehicle_owner::with(['applicant_type', 'vehicle'])
            ->whereHas('vehicle', function ($query) {
                $query->whereHas('transaction', function ($subQuery) {
                    $subQuery->where('claiming_status_id', 1); //adjust to 0
                });
            })
            ->paginate($perPage);

            foreach ($data as $row) {
                $applicantType = $row->applicant_type->type ?? 'Unknown';
        
                switch ($applicantType) {
                    case 'BU-personnel':
                        $row->color = 'blue';
                        break;
                    case 'Non-personnel':
                        $row->color = 'green';
                        break;
                    case 'Student':
                        $row->color = 'orange';
                        break;
                    case 'VIP':
                        $row->color = 'gray';
                        break;
                    default:
                        $row->color = 'black';
                        break;
                }
            }

        if ($request->query('export') === 'csv') {
            return $this->exportToCSV($data);
        }

        return view('pending_applications', compact('data'));
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
            fputcsv($handle, ['Full Name', 'Applicant Type', 'Created At']);
            foreach ($data as $row) {
                $fullName = $row->fname . ' ' . $row->mname . ' ' . $row->lname;
                $applicantType = $row->applicant_type->type ?? 'Unknown';  // Fetch type from related model
                fputcsv($handle, [$fullName, $applicantType, $row->created_at]);
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
            'vehicle.transaction'
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
                'Full Name', 'Contact No', 'QR Code', 'Employee ID', 
                'Student ID', 'Driver License No', 'Applicant Type', 
                'Created At', 'Model Color', 'Plate No', 'Expiry Date', 
                'Copy of Driver License', 'Copy of COR', 'Copy of School ID', 
                'OR No', 'CR No', 'Copy of OR/CR', 'Vehicle Type', 
                'Reference No'
            ]);

            foreach ($owners as $owner) {
                foreach ($owner->vehicle as $vehicle) {
                    // Write each row of owner and vehicle details to the CSV
                    foreach ($vehicle->transaction as $transaction) {
                        fputcsv($handle, [
                            $owner->fname . ' ' . $owner->mname . ' ' . $owner->lname,
                            $owner->contact_no,
                            $owner->qr_code,
                            $owner->emp_id,
                            $owner->std_id,
                            $owner->driver_license_no,
                            $owner->applicant_type->type ?? 'Unknown',
                            $owner->created_at,
                            $vehicle->model_color,
                            $vehicle->plate_no,
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
        // Load vehicle_owner with related vehicle, applicant_type, and transactions
        $item = Vehicle_owner::with([
            'applicant_type',  // Load applicant type details
            'vehicle.vehicle_type', // Load vehicles and their types
            'vehicle.transaction'  // Load transactions related to vehicles
        ])->findOrFail($id);

        $item->qr_code_base64 = base64_encode($item->qr_code);

        return view('pa_details', compact('item'));
    }

}

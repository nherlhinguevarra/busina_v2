<?php

namespace App\Http\Controllers;

use AllDocsApprovedMail;
use App\Mail\AllDocsApprovedMail as MailAllDocsApprovedMail;
use App\Models\Vehicle_owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentReuploadMail;
use App\Mail\AllDocumentsApprovedMail;
use App\Models\Users;
use App\Mail\DocsReuploadMail;
use App\Models\Vehicle;

class DataTableController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $data = Vehicle_owner::with(['applicant_type', 'vehicle'])
            ->whereHas('vehicle', function ($query) {
                $query->whereHas('transaction', function ($subQuery) {
                    $subQuery->where('claiming_status_id', 1); //1-pending, 2-to claim
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

    public function exportAllAppDetailsToCSV()
    {
        $owners = Vehicle_owner::with([
            'applicant_type', 
            'vehicle.vehicle_type', 
            'vehicle.transaction'
        ])->get();

        $csvFileName = 'pending_applications.csv';
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
            'vehicle.transaction',  // Load transactions related to vehicles
            'users'
        ])->findOrFail($id);

        $vehicleOwnerId = $item->id;  // Store the vehicle owner ID for the form

        foreach ($item->vehicle as $vehicle) {
            try {
                $vehicle->copy_driver_license = $vehicle->copy_driver_license ? Crypt::decrypt($vehicle->copy_driver_license) : null;
                $vehicle->copy_cor = $vehicle->copy_cor ? Crypt::decrypt($vehicle->copy_cor) : null;
                $vehicle->copy_school_id = $vehicle->copy_school_id ? Crypt::decrypt($vehicle->copy_school_id) : null;
                $vehicle->copy_or_cr = $vehicle->copy_or_cr ? Crypt::decrypt($vehicle->copy_or_cr) : null;
            } catch (\Exception $e) {
                // Handle decryption errors (e.g., when the data is not encrypted or invalid)
                $vehicle->copy_driver_license = 'Decryption error';
                $vehicle->copy_cor = 'Decryption error';
                $vehicle->copy_school_id = 'Decryption error';
                $vehicle->copy_or_cr = 'Decryption error';
            }
        }

        $item->qr_code_base64 = base64_encode($item->qr_code);

        return view('pa_details', compact('item', 'vehicleOwnerId'));
    }

    public function saveDocumentApproval(Request $request, $vehicleOwnerId)
{
    // Fetch vehicle owner and the related user and vehicle information
    $vehicleOwner = Vehicle_owner::find($vehicleOwnerId);
    $user = $vehicleOwner->users; // Fetch user associated with vehicle_owner
    
    // Get the first vehicle related to the vehicle owner
    $vehicle = $vehicleOwner->vehicle->first();
    
    if ($vehicle) {
        // Get the first transaction related to this vehicle
        $transaction = $vehicle->transaction->first(); // Ensure it's a single model
        
        // Track files that need reupload
        $filesToReupload = [];
        
        // Check each file status
        if ($request->input('status_license') === 'reupload') {
            $filesToReupload[] = 'Copy of Driver License';
        }
        if ($request->input('status_orcr') === 'reupload') {
            $filesToReupload[] = 'Copy of OR/CR';
        }
        if ($request->input('status_schoolid') === 'reupload') {
            $filesToReupload[] = 'Copy of School ID';
        }
        if ($request->input('status_cor') === 'reupload') {
            $filesToReupload[] = 'Copy of COR';
        }
        
        // Check if there are files to be reuploaded
        if (count($filesToReupload) > 0) {
            // Send an email to notify the user to reupload specific files
            Mail::to($user->email)->send(new DocsReuploadMail($filesToReupload, $user));
            return redirect()->route('pending_applications')->with('success', 'Registration remarks sent to applicant via email');
        
        } else {
            // All files are approved, send notification about next steps
            // Get the plate_no from the first vehicle, assuming it exists
            $plateNo = $vehicle->plate_no;

            // Send email notifying that all docs are approved
            Mail::to($user->email)->send(new MailAllDocsApprovedMail($user, $plateNo));
        
            // If the transaction exists, update the claiming_status_id to 2 (approved status)
            if ($transaction) {
                // Make sure we're dealing with a single transaction model
                $transaction->claiming_status_id = 2;
                $transaction->issued_date = now()->toDateString();
                $transaction->save(); // Save the transaction model
                return redirect()->route('pending_applications')->with('success', 'Registration remarks sent to applicant via email');
            } else {
                // Handle the case where no transaction is found
                return redirect()->back()->with('error', 'No transaction found for the vehicle.');
            }
        }
    } else {
        return redirect()->back()->with('error', 'No vehicle found for this owner.');
    }
    
    return redirect()->back()->with('success', 'Document statuses saved successfully.');
}



}

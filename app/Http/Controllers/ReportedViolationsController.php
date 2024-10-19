<?php

namespace App\Http\Controllers;

use App\Mail\ViolationSettled;
use App\Models\Settle_violation;
use App\Models\Violation;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class ReportedViolationsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 15;

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

    public function exportAllVioDetailsToCSV()
    {
        // Fetch all violations with related violation_type and authorized_user
        $violations = Violation::with([
            'violation_type', // Load violation type
            'authorized_user', // Load the authorized user who reported the violation
            'vehicle' // Load related vehicle information
        ])->get();

        $csvFileName = 'reported_violations.csv';
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
        // Fetch the violation details with related data, including settle_violation
        $violation = Violation::with([
            'vehicle',
            'violation_type',
            'authorized_user',
            'settle_violation' // Load settle_violation relationship
        ])->findOrFail($id);

        // Initialize the proofImage variable
        $proofImage = null;

        // Check if a related settle_violation exists
        $settleViolation = $violation->settle_violation;
        if ($settleViolation && $settleViolation->document) {
            try {
                // Decrypt the document from the database
                $decryptedContent = Crypt::decrypt($settleViolation->document);

                // Convert the decrypted content to a base64 image string for displaying
                $base64Image = base64_encode($decryptedContent);
                $proofImage = 'data:image/jpeg;base64,' . $base64Image; // Adjust the MIME type if needed
            } catch (\Exception $e) {
                FacadesLog::error('Error decrypting document: ' . $e->getMessage());
            }
        }

        return view('rv_details', compact('proofImage', 'settleViolation', 'violation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'violation_id' => 'required|exists:violation,id',
            'document' => 'required|file'
        ]);

        // Check if the violation already has an entry in the settle_violations table
        $settleViolation = Settle_violation::firstOrNew(['violation_id' => $request->violation_id]);

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $settleViolation->document = Crypt::encrypt(file_get_contents($document->getRealPath()));
        }

        $violation = Violation::find($request->violation_id);
    
        if (!empty($settleViolation->document)) {
            $violation->remarks = 'Settled';
        } else {
            $violation->remarks = 'Not been settled';
        }

        $violation->save();
        // Save the record (either a new record or update existing)
        $settleViolation->save();

        $violation = Violation::find($request->violation_id);
    
        if (!empty($settleViolation->document)) {
            $violation->remarks = 'Settled';
        } else {
            $violation->remarks = 'Not been settled';
        }

        $violation->save();

        $vehicle = $violation->vehicle;
        $vehicle_owner = $vehicle->vehicle_owner;
        $users = $vehicle_owner->users;

        if ($users) {
            // Send email notification
            Mail::to($users->email)->send(new ViolationSettled($violation));
        }
        
        return redirect()->back()->with('success', 'Document uploaded/updated successfully.');
    }


    

}

<?php

namespace App\Http\Controllers;

use App\Models\Settle_violation;
use App\Models\SettleViolation;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SettleViolationController extends Controller
{
    /**
     * Store the uploaded image as an encrypted file in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'violation_id' => 'required|exists:violation,id',
            'photo' => 'nullable|image|max:2048', // Ensure photo is an image and not too large (max 2MB)
        ]);

        // Find the violation record to ensure it exists
        $violation = Violation::findOrFail($request->input('violation_id'));

        // If an image is uploaded, encrypt and store it
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoData = file_get_contents($photo);
            $encryptedPhoto = Crypt::encrypt($photoData); // Encrypt the image content

            // Create a new SettleViolation record and save the encrypted image
            $settleViolation = new Settle_violation();
            $settleViolation->violation_id = $violation->id;
            $settleViolation->document = $encryptedPhoto; // Store the encrypted image
            $settleViolation->save();
        }

        return redirect()->back()->with('success', 'Payment receipt uploaded and encrypted successfully.');
    }

    /**
     * Display the specified violation's details including the decrypted image.
     *
     * @param int $violation_id
     * @return \Illuminate\View\View
     */
    public function show($violation_id)
    {
        // Fetch the violation record with related settle_violation data
        $violation = Violation::with(['settle_violation', 'authorized_user', 'violation_type', 'vehicle'])
                                ->findOrFail($violation_id);

        // Check if there is a related SettleViolation record and decrypt the image
        $proofImage = null;
        if ($violation->settle_violation && $violation->settle_violation->document) {
            $encryptedImage = $violation->settle_violation->document;
            $proofImage = Crypt::decrypt($encryptedImage); // Decrypt the image for display
        }

        // Return the view with violation details and the decrypted image
        return view('rv_details', compact('violation', 'proofImage'));
    }
}

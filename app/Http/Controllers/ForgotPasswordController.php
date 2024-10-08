<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('forgot_pass');
    }

    public function sendResetCode(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'emp_no' => 'required|exists:employee,emp_no',
        ]);

        if ($validator->fails()) {
            return redirect()->route('password.request')
                            ->withErrors($validator)
                            ->withInput();
        }

        // Fetch employee details using Query Builder
        $employee = DB::table('employee')->where('emp_no', $request->emp_no)->first();

        // Check if employee exists
        if (!$employee) {
            return redirect()->route('password.request')
                            ->with('error', 'Employee not found.')
                            ->withInput();
        }
        
        // Fetch associated authorized_user record using emp_id
        $authorizedUser = DB::table('authorized_user')->where('emp_id', $employee->id)->first();

        // Check if authorized_user exists
        if (!$authorizedUser) {
            return redirect()->route('password.request')
                            ->with('error', 'User information not found for this employee.')
                            ->withInput();
        }

        // Fetch associated users record using authorized_user_id
        $user = DB::table('users')->where('authorized_user_id', $authorizedUser->id)->first();

        // Check if users exists
        if (!$user) {
            return redirect()->route('password.request')
                            ->with('error', 'Login information not found for this user.')
                            ->withInput();
        }

        // Check if user_type is allowed to reset the password
        if ($authorizedUser->user_type != 1) {
            return redirect()->route('password.request')
                            ->with('error', 'You are not authorized to reset the password on this site, maybe you are on the wrong site.')
                            ->withInput();
        }

        // Check if there is an existing reset request
        $existingReset = DB::table('password_resets')
                        ->where('emp_no', $request->emp_no)
                        ->where('expiration', '>', now())
                        ->where('used_reset_token', 0)
                        ->first();

        if ($existingReset) {
            // Notify user that reset URL is still valid
            return redirect()->route('password.request')
                            ->with('error', 'Your requested URL hasn\'t expired yet, you can still use it to reset your password.')
                            ->withInput();
        }

        // Generate a unique reset token
        $resetToken = Str::random(60);

        // Store the new token in the password_resets table
        DB::table('password_resets')->insert([
            'emp_no' => $request->emp_no,
            'users_id' => $user->id,
            'reset_token' => $resetToken,
            'expiration' => now()->addMinutes(10), // Set expiration to 10 minutes
            'used_reset_token' => 0
        ]);

        // Generate reset link using the named route with emp_no parameter
        $resetLink = route('reset_new_pass', ['emp_no' => $request->emp_no, 't' => urlencode($resetToken)]);

        // Send reset link via email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'businabicoluniversity@gmail.com'; // Your Gmail address
            $mail->Password   = 'jpic klzq vxkd cwwc';        // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('businabicoluniversity@gmail.com', 'BUsina');
            $mail->addAddress($user->email);  // Add recipient email

            // Content
            $mail->isHTML(true); // Set to true if sending HTML email
            $mail->Subject = 'Reset Password Link from BUsina';
            $mail->Body    = "
            <html>
            <head>
                <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css'>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; font-weight: 500;'>
                <div style='background-color: white; border-radius: 10px; width: 100%; max-width: 600px; margin: 20px auto; text-align: left;'>
                    <div style='background-color: #161a39; align-items: center; text-align: center; padding: 20px;'>
                        <h3 style='color: white; font-size: 20px;'>Please reset your password</h3>
                    </div>
                    <div style='padding: 40px;'>
                        <p style='margin: 10px 0; color: #666666; font-size: 14px;'>Hello <span style='font-weight: 600;'>{$authorizedUser->fname} {$authorizedUser->lname}</span>,</p>
                        <p style='margin: 10px 0; color: #666666; font-size: 14px;'>We have received a request to reset your password. If you did not initiate this request, please disregard this email.</p>
                        <p style='margin: 10px 0; color: #666666; font-size: 14px;'>To reset your password, click on the button below:</p>
                        <div style='margin: 20px 0; text-align: center;'>
                            <a href='{$resetLink}' style='background-color: #161a39; border: none; color: white; padding: 10px 30px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease;'>Reset Password</a>
                        </div>
                        <p style='margin: 10px 0; color: #666666; font-size: 14px;'>If the button above does not work, you can ignore this email, and your password will remain unchanged.</p>
                        <p style='margin: 10px 0; color: #666666; font-size: 14px;'>If you have any questions or need further assistance, please don't hesitate to contact us at <a href='mailto:businabicoluniversity@gmail.com' style='color: #161a39; text-decoration: none;'>busina@gmail.com</a>.</p>
                        <p style='margin: 10px 0; color: #666666; font-size: 14px;'>Best regards,<br><span style='font-weight: 600;'>Bicol University BUsina</span></p>
                    </div>
                    <div style='background-color: #161a39; padding: 20px 20px 5px 20px;'>
                        <div style='color: #f4f4f4; font-size: 12px;'>
                            <p><span style='font-size: 14px; font-weight: 600;'>Contact</span></p>
                            <p>businabicoluniversity@gmail.com</p>
                            <p>Legazpi City, Albay, Philippines 13°08′39″N 123°43′26″E</p>
                        </div>
                        <div style='text-align: center;'>
                            <p style='color: #f4f4f4; font-size: 14px;'>Company © All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();

            // Set session variable to authorize access to reset_code_pass.php
            session(['reset_authorized' => true]);

            $success = "Reset link sent to your email.";
            // Redirect user to pass_emailed.blade.php
            return redirect()->route('pass_emailed')->with('success', $success);
        } catch (Exception $e) {
            return redirect()->route('password.request')
                            ->with('error', "Failed to send reset link. Mailer Error: {$mail->ErrorInfo}")
                            ->withInput();
        }
    }
}

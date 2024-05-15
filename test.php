Test

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function sendOTP(Request $request)
    {
        $phoneNumber = $request->phone_number;
        $society = $request->society;

        // Implement your OTP sending logic here
        $otpNumber = mt_rand(100000, 999999);
        $otpMessage = "$otpNumber is your OTP for Ledger365 application activation. OTP is valid for 10 minutes. Regards Ledger365";

        // Send OTP via API
        $response = Http::post('https://api.kaleyra.io/v1/HXIN1746283851IN/messages', [
            'to' => '91' . $phoneNumber,
            'body' => $otpMessage,
            'sender' => 'CHSSOL',
            'type' => 'OTP',
            'template_id' => '1207165970065772446',
        ], [
            'api-key' => 'A08e886bcdd174b84ff55d1e1ecc1a780'
        ]);

        if ($response->successful()) {
            // Save OTP to the database
            // Example: WebOTP::create(['phone_number' => $phoneNumber, 'otp' => $otpNumber, 'society_guid' => $society]);

            // Return success response
            return response()->json(['success' => true]);
        } else {
            // Return error response
            return response()->json(['error' => 'Failed to send OTP'], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $phoneNumber = $request->phone_number;
        $otp = $request->otp;
        $society = $request->society;

        // Verify OTP logic
        // Example: $isValidOTP = WebOTP::where('phone_number', $phoneNumber)->where('otp', $otp)->exists();

        // if ($isValidOTP) {
        //     // Perform login or registration logic
        //     return response()->json(['success' => true]);
        // } else {
        //     return response()->json(['error' => 'Invalid OTP'], 422);
        // }
    }
}






// app/Http/Controllers/Auth/OTPController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OTPController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|exists:users,phone_number',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->save();

        // Send OTP to user's phone number
        $this->sendOtpViaSms($user->phone_number, $otp);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|exists:users,phone_number',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::where('phone_number', $request->phone_number)
                    ->where('otp', $request->otp)
                    ->first();

        if ($user) {
            // Log the user in
            Auth::login($user);

            // Clear the OTP
            $user->otp = null;
            $user->save();

            return response()->json(['message' => 'Logged in successfully']);
        } else {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }
    }

    private function sendOtpViaSms($phone_number, $otp)
    {
        $message = $otp . " is your OTP for Ledger365 application activation. OTP is valid for 10 minutes. Regards Ledger365";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.kaleyra.io/v1/HXIN1746283851IN/messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query([
                'to' => '91' . $phone_number,
                'body' => $message,
                'sender' => 'CHSSOL',
                'type' => 'OTP',
                'template_id' => '1207165970065772446',
            ]),
            CURLOPT_HTTPHEADER => array(
                "api-key: A08e886bcdd174b84ff55d1e1ecc1a780",
                "cache-control: no-cache",
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // Handle error
            // You can log the error or handle it as required
            throw new \Exception("cURL Error #:" . $err);
        }

        // Optionally, handle the response if needed
        return $response;
    }
}

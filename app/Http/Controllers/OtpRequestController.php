<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OtpVerification;

class OtpRequestController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('otprequest.index', compact('users'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|exists:users,phone',
        ]);

        $user = User::where('phone', $request->phone)->first();
        $otp = rand(100000, 999999);

        $otpVerification = new OtpVerification([
            'user_id' => $user->id,
            'otp' => $otp,
        ]);

        $otpVerification->save();

        $response = $this->sendOtpViaSms($user->phone, $otp);

        // return response()->json(['message' => 'OTP sent successfully', 'response' => $response]);

        return redirect()->route('otp.verify', ['userId' => $user->id])->with('success', 'OTP sent successfully.');

        // return redirect()->route('roles.index')->with('success', 'OTP sent successfully.');
    }

    private function sendOtpViaSms($phone, $otp)
    {
        $message = $otp . " is your OTP for Ledger365 application activation. OTP is valid for 10 minutes. Regards Ledger365";
    
        $curl = curl_init();
    
        $url = "https://api.kaleyra.io/v1/HXIN1746283851IN/messages";
        $to = '91' . $phone;
        $body = $message;
        $sender = 'CHSSOL';
        $type = 'OTP';
        $template_id = '1207165970065772446';
    
        $data = [
            'to' => $to,
            'body' => $body,
            'sender' => $sender,
            'type' => $type,
            'template_id' => $template_id,
        ];
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                "api-key: A08e886bcdd174b84ff55d1e1ecc1a780",
                "cache-control: no-cache",
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        // Log the request payload
        error_log("Request Payload: " . json_encode($data));
    
        if ($err) {
            // Log cURL error
            error_log("cURL Error: " . $err);
            throw new \Exception("cURL Error #:" . $err);
        }
    
        // Log the response
        error_log("API Response: " . $response);
    
        return $response;
    }

    public function showVerificationForm($userId)
    {
        return view('otprequest.verify', compact('userId'));
    }

    public function verifyOtp(Request $request, $userId)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $otpVerification = OtpVerification::where('user_id', $userId)
            ->where('otp', $request->otp)
            ->first();

        if ($otpVerification) {
            // OTP is valid
            // Perform further actions like logging in the user, etc.
            return redirect()->route('dashboard')->with('success', 'OTP verified successfully.');
        } else {
            // Invalid OTP
            return back()->with('error', 'Invalid OTP. Please try again.');
        }
    }

}

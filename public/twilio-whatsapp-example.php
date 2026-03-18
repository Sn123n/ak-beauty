<?php
/**
 * Example: Send WhatsApp OTP via Twilio
 * 
 * NOTE: This is just an example. In production, integrate this into your Laravel controller.
 * You'll need to install Twilio SDK: composer require twilio/sdk
 */

// Example function to send WhatsApp OTP
function sendWhatsAppOtp($to, $name, $otp) {
    
    // Your Twilio credentials (store these in .env file in production)
    $accountSid = 'YOUR_TWILIO_ACCOUNT_SID';
    $authToken = 'YOUR_TWILIO_AUTH_TOKEN';
    $fromNumber = 'whatsapp:+14155238886'; // Twilio Sandbox number for testing
    
    // Format phone number
    $to = strpos($to, 'whatsapp:') === 0 ? $to : 'whatsapp:' . $to;
    
    // Create OTP message
    $message = "Hello {$name},\n\n";
    $message .= "Your AK BEAUTY STORE verification code is: {$otp}\n\n";
    $message .= "This code will expire in 5 minutes.\n\n";
    $message .= "If you didn't request this code, please ignore this message.\n\n";
    $message .= "Thank you,\nAK BEAUTY STORE Team";
    
    // Twilio API endpoint
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json";
    
    // Prepare data
    $data = [
        'From' => $fromNumber,
        'To' => $to,
        'Body' => $message
    ];
    
    // Send request using cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "{$accountSid}:{$authToken}");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if ($httpCode == 201) {
        return [
            'success' => true,
            'message' => 'OTP sent successfully',
            'sid' => $result['sid'] ?? null
        ];
    } else {
        return [
            'success' => false,
            'message' => $result['message'] ?? 'Failed to send OTP',
            'error' => $result
        ];
    }
}

// Example usage:
// $result = sendWhatsAppOtp('+919876543210', 'John Doe', '12345');
// echo json_encode($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Backend Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .code-block {
            background: #2a2a3a;
            color: #49b8e4;
            padding: 20px;
            border-radius: 5px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        h1 { color: #2a2a3a; }
        h2 { color: #333; margin-top: 30px; }
    </style>
</head>
<body>
    <h1>📱 Laravel Backend Integration Example</h1>
    
    <div class="info-box">
        <strong>To integrate in Laravel:</strong><br>
        1. Install Twilio SDK: <code>composer require twilio/sdk</code><br>
        2. Add credentials to <code>.env</code> file<br>
        3. Add method to <code>OtpController.php</code><br>
        4. Create route in <code>routes/web.php</code> or <code>routes/api.php</code>
    </div>

    <h2>1. Add to .env file:</h2>
    <div class="code-block">
TWILIO_ACCOUNT_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886
    </div>

    <h2>2. Add method to OtpController.php:</h2>
    <div class="code-block">
public function sendWhatsAppOtp(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone' => 'required|string',
        'name' => 'required|string',
    ]);
    
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    
    // Generate OTP
    $otp = rand(10000, 99999);
    $expiresAt = now()->addMinutes(5);
    
    // Store in session
    session()->put('otp', $otp);
    session()->put('otp_expires_at', $expiresAt);
    
    // Send via Twilio
    $accountSid = env('TWILIO_ACCOUNT_SID');
    $authToken = env('TWILIO_AUTH_TOKEN');
    $fromNumber = env('TWILIO_WHATSAPP_FROM', 'whatsapp:+14155238886');
    
    $to = strpos($request->phone, 'whatsapp:') === 0 
        ? $request->phone 
        : 'whatsapp:' . $request->phone;
    
    $message = "Hello {$request->name},\n\n";
    $message .= "Your AK BEAUTY STORE verification code is: {$otp}\n\n";
    $message .= "This code will expire in 5 minutes.\n\n";
    $message .= "If you didn't request this code, please ignore this message.\n\n";
    $message .= "Thank you,\nAK BEAUTY STORE Team";
    
    try {
        $client = new \Twilio\Rest\Client($accountSid, $authToken);
        
        $message = $client->messages->create(
            $to,
            [
                'from' => $fromNumber,
                'body' => $message
            ]
        );
        
        return response()->json([
            'code' => 200,
            'message' => 'WhatsApp OTP sent successfully',
            'sid' => $message->sid
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'code' => 400,
            'message' => 'Failed to send OTP: ' . $e->getMessage()
        ], 400);
    }
}
    </div>

    <h2>3. Add route:</h2>
    <div class="code-block">
Route::post('/send-whatsapp-otp', [OtpController::class, 'sendWhatsAppOtp']);
    </div>

    <div class="info-box" style="margin-top: 30px;">
        <strong>Testing:</strong><br>
        Use the HTML test page at: <code>whatsapp-otp-test.html</code> or use Postman/curl to test the API endpoint.
    </div>
</body>
</html>

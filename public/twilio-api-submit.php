<?php
/**
 * Script to Submit WhatsApp Template to Twilio via API
 * 
 * Usage:
 * 1. Fill in your Twilio credentials below
 * 2. Update the logo URL to your publicly accessible HTTPS URL
 * 3. Run: php twilio-api-submit.php
 * 
 * Or use curl command shown at the bottom
 */

// ============================================
// CONFIGURATION - Fill these values
// ============================================
$accountSid = 'YOUR_TWILIO_ACCOUNT_SID';
$authToken = 'YOUR_TWILIO_AUTH_TOKEN';
$logoUrl = 'https://your-domain.com/client_assets/images/logo-3.png'; // Must be HTTPS and publicly accessible

// ============================================
// Template Configuration
// ============================================
$templateData = [
    "name" => "ak_beauty_otp_verification",
    "category" => "UTILITY",
    "language" => "en_US",
    "components" => [
        [
            "type" => "HEADER",
            "format" => "IMAGE",
            "example" => [
                "header_handle" => [$logoUrl]
            ]
        ],
        [
            "type" => "BODY",
            "text" => "Hello {{1}},\n\nYour verification code for AK BEAUTY STORE is:\n\n*{{2}}*\n\nThis code will expire in 5 minutes.\nPlease do not share this code with anyone.\n\n🔒 *Security Notice*\nFor your security, never share this code. AK BEAUTY STORE will never ask for your verification code via phone or email.\n\n⏱️ Valid for 5 minutes only",
            "example" => [
                "body_text" => [
                    ["John Doe", "47261"]
                ]
            ]
        ],
        [
            "type" => "FOOTER",
            "text" => "AK BEAUTY STORE"
        ]
    ]
];

// ============================================
// Submit to Twilio
// ============================================
function submitTemplate($accountSid, $authToken, $templateData) {
    $url = "https://content.twilio.com/v1/Content";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($accountSid . ':' . $authToken)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($templateData));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return [
            'success' => false,
            'error' => $error
        ];
    }
    
    $result = json_decode($response, true);
    
    if ($httpCode >= 200 && $httpCode < 300) {
        return [
            'success' => true,
            'data' => $result,
            'contentSid' => $result['sid'] ?? null
        ];
    } else {
        return [
            'success' => false,
            'httpCode' => $httpCode,
            'error' => $result
        ];
    }
}

// ============================================
// Execute (if running via command line)
// ============================================
if (php_sapi_name() === 'cli') {
    echo "===========================================\n";
    echo "Twilio WhatsApp Template Submission\n";
    echo "===========================================\n\n";
    
    if ($accountSid === 'YOUR_TWILIO_ACCOUNT_SID') {
        echo "❌ ERROR: Please update your Twilio credentials in the script!\n";
        echo "Edit twilio-api-submit.php and fill in:\n";
        echo "  - \$accountSid\n";
        echo "  - \$authToken\n";
        echo "  - \$logoUrl\n\n";
        exit(1);
    }
    
    echo "Submitting template...\n\n";
    $result = submitTemplate($accountSid, $authToken, $templateData);
    
    if ($result['success']) {
        echo "✅ SUCCESS!\n\n";
        echo "Template submitted successfully!\n";
        echo "Content SID: " . ($result['contentSid'] ?? 'N/A') . "\n";
        echo "\nTemplate Status: PENDING (waiting for approval)\n";
        echo "Check status in Twilio Console: https://console.twilio.com/\n";
    } else {
        echo "❌ ERROR!\n\n";
        echo "Failed to submit template.\n";
        if (isset($result['httpCode'])) {
            echo "HTTP Code: " . $result['httpCode'] . "\n";
        }
        echo "Error: " . json_encode($result['error'], JSON_PRETTY_PRINT) . "\n";
    }
} else {
    // If accessed via browser, show info
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Twilio Template Submission</title>
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
                font-family: monospace;
                font-size: 13px;
                margin: 15px 0;
            }
            .info-box {
                background: #e7f3ff;
                border-left: 4px solid #2196F3;
                padding: 15px;
                border-radius: 5px;
                margin: 20px 0;
            }
            h1 { color: #2a2a3a; }
        </style>
    </head>
    <body>
        <h1>Twilio WhatsApp Template Submission</h1>
        <div class="info-box">
            <strong>Note:</strong> This script should be run from command line (CLI) for security reasons.<br>
            Update credentials in the PHP file before running.
        </div>
        
        <h2>To submit via command line:</h2>
        <div class="code-block">
php twilio-api-submit.php
        </div>
        
        <h2>Or use curl command:</h2>
        <div class="code-block">
curl -X POST https://content.twilio.com/v1/Content \
  -u YOUR_ACCOUNT_SID:YOUR_AUTH_TOKEN \
  -H "Content-Type: application/json" \
  -d @twilio-template-submission.json
        </div>
        
        <div class="info-box">
            <strong>Recommended:</strong> Use Twilio Console (web interface) for easier template submission and management.
        </div>
    </body>
    </html>
    <?php
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your OTP Code</title>
  <style>
    body { margin:0; padding:0; background-color:#f4f6f8; }
    table { border-collapse:collapse; }
    img { border:0; display:block; }
    a { color:#49b8e4; text-decoration:none; }
    @media only screen and (max-width:600px){
      .container { width:100% !important; }
      .stack { display:block !important; width:100% !important; }
      .center { text-align:center !important; }
      .hide-mobile { display:none !important; }
    }
  </style>
</head>
<body style="margin:0; padding:24px; background-color:#f4f6f8; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.08);">

          <!-- Header -->
          <tr>
            <td style="padding:20px 24px; background:#2a2a3a; color:#ffffff; text-align:center;">
              <img src="{{ asset('client_assets/images/logo-3.png') }}" alt="AK BEAUTY STORE" width="140" style="display:block; margin:auto;">
            </td>
          </tr>

          <!-- Main content -->
          <tr>
            <td style="padding:32px 24px; text-align:center;">
              <h1 style="font-size:22px; color:#111; margin:0 0 10px 0;">Your Verification Code</h1>
              <p style="font-size:15px; color:#555; margin:0 0 24px 0; line-height:1.6;">
                Dear {{ $name ?? 'User' }},<br>
                Please use the verification code below to complete your login/registration process.
              </p>

              <!-- OTP Code Box -->
              <div style="display:inline-block; padding:20px 40px; border:2px dashed #49b8e4; border-radius:8px; background-color:#f0faff; font-size:32px; letter-spacing:8px; font-weight:bold; color:#2a2a3a; margin:20px 0;">
                {{ $otp }}
              </div>

              <p style="font-size:14px; color:#777; margin:24px 0 32px 0; line-height:1.6;">
                This code will expire in <strong>5 minutes</strong>.<br>
                If you didn't request this code, you can safely ignore this email.
              </p>

              <div style="background-color:#f9f9f9; border-radius:6px; padding:16px; margin:24px 0; text-align:left;">
                <p style="font-size:13px; color:#555; margin:0; line-height:1.6;">
                  <strong>Security Tip:</strong> Never share this code with anyone. AK BEAUTY STORE will never ask for your verification code.
                </p>
              </div>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:20px 24px; background-color:#2a2a3a; font-size:13px; color:#fff; text-align:center;">
              <div style="margin-bottom:8px; font-size:12px; color:#999;">© 2025, AK BEAUTY STORE</div>
              <div>
                <a href="javascript:void(0);" style="margin:0 8px; color:#49b8e4;">Contact Us</a> |
                <a href="javascript:void(0);" style="margin:0 8px; color:#49b8e4;">Terms & Conditions</a> |
                <a href="javascript:void(0);" style="margin:0 8px; color:#49b8e4;">Privacy Policy</a>
              </div>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>

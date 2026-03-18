# 📱 Twilio WhatsApp Template Submission Guide
## AK BEAUTY STORE - OTP Verification Template

### Step 1: Prepare Your Assets

1. **Company Logo**
   - Logo path: `/client_assets/images/logo-3.png`
   - Requirements:
     - Format: PNG or JPG
     - Size: Recommended 640x640px (square)
     - Max file size: 5MB
     - Must be publicly accessible via HTTPS URL
   - Upload logo to a publicly accessible location or your server
   - Note the full HTTPS URL (e.g., `https://akbeauty.com/client_assets/images/logo-3.png`)

### Step 2: Preview the Template

1. Open `whatsapp-otp-template-preview.html` in your browser
2. Double-click the phone mockup to see submission details
3. Review the design and make any adjustments

### Step 3: Submit to Twilio

#### Option A: Using Twilio Console (Recommended)

1. **Login to Twilio Console**
   - Go to: https://console.twilio.com/
   - Navigate to: Messaging → Content Templates → WhatsApp Templates

2. **Create New Template**
   - Click "Create Template"
   - Fill in the following:

   **Template Name:**
   ```
   ak_beauty_otp_verification
   ```

   **Category:**
   ```
   UTILITY
   ```

   **Language:**
   ```
   English (US) - en_US
   ```

3. **Add Header (Image)**
   - Select "Header" component
   - Choose "Image" format
   - Enter your logo URL:
     ```
     https://your-domain.com/client_assets/images/logo-3.png
     ```

4. **Add Body Text**
   ```
   Hello {{1}},

   Your verification code for AK BEAUTY STORE is:

   *{{2}}*

   This code will expire in 5 minutes.
   Please do not share this code with anyone.

   🔒 *Security Notice*
   For your security, never share this code. AK BEAUTY STORE will never ask for your verification code via phone or email.

   ⏱️ Valid for 5 minutes only
   ```

   **Variables:**
   - `{{1}}` = Customer Name (Text)
   - `{{2}}` = OTP Code (Text)

   **Example Values:**
   - Variable 1: `John Doe`
   - Variable 2: `47261`

5. **Add Footer (Optional)**
   ```
   AK BEAUTY STORE
   ```

6. **Submit for Approval**
   - Review all components
   - Click "Submit for Approval"
   - Wait for Meta/Twilio approval (usually 24-48 hours)

#### Option B: Using Twilio API

1. **Get Your Credentials**
   - Account SID: From Twilio Console
   - Auth Token: From Twilio Console
   - WhatsApp Business Account ID: From Twilio Console

2. **Use the JSON File**
   - Open `twilio-template-submission.json`
   - Update the logo URL with your actual HTTPS URL
   - Use this JSON to create template via API

   **API Endpoint:**
   ```
   POST https://content.twilio.com/v1/Content
   ```

   **Headers:**
   ```
   Authorization: Basic {Base64(AccountSid:AuthToken)}
   Content-Type: application/json
   ```

   **Body:** (Use content from `twilio-template-submission.json`)

### Step 4: Template Approval Process

1. **Pending Status**: Template submitted, waiting for review
2. **Approved**: Template is ready to use
3. **Rejected**: You'll receive feedback, make changes and resubmit

**Common Rejection Reasons:**
- Logo not accessible via HTTPS
- Template violates WhatsApp Business Policy
- Variables not properly formatted
- Content too promotional (should be UTILITY category)

### Step 5: After Approval - Implementation

Once approved, you can use the template in your Laravel code:

```php
$client = new \Twilio\Rest\Client($accountSid, $authToken);

$message = $client->messages->create(
    $to, // whatsapp:+919876543210
    [
        'from' => $from, // whatsapp:+14155238886
        'contentSid' => 'your_template_content_sid',
        'contentVariables' => json_encode([
            '1' => $customerName,
            '2' => $otpCode
        ])
    ]
);
```

### Important Notes

⚠️ **Before Submission:**
- Ensure logo is publicly accessible via HTTPS
- Test the logo URL in browser
- Verify template text follows WhatsApp policies
- Check all variables are properly formatted

✅ **Best Practices:**
- Keep message concise and clear
- Use clear security messaging
- Include expiry information
- Professional and friendly tone

### Template Variables Reference

- `{{1}}` - Customer Name (e.g., "John Doe")
- `{{2}}` - OTP Code (e.g., "47261" - 5 digits)

### Support

If template is rejected:
1. Check Twilio console for rejection reason
2. Review WhatsApp Business Policy: https://www.whatsapp.com/legal/business-policy
3. Make necessary adjustments
4. Resubmit

---

**Template Preview:** Open `whatsapp-otp-template-preview.html` in browser
**JSON Template:** Use `twilio-template-submission.json` for API submission

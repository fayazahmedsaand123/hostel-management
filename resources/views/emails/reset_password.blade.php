<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Portal — Password Reset</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            padding: 30px 20px;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #1a237e, #0d6efd);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .email-header .icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
        }
        .email-header h1 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .email-header p {
            opacity: 0.85;
            font-size: 14px;
        }

        /* Body */
        .email-body {
            padding: 40px 35px;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            color: #1a237e;
            margin-bottom: 15px;
        }
        .message {
            font-size: 15px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        /* Reset Button */
        .btn-wrapper {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-reset {
            display: inline-block;
            background: linear-gradient(135deg, #1a237e, #0d6efd);
            color: white !important;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Warning Box */
        .warning-box {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        .warning-box p {
            font-size: 13px;
            color: #555;
            margin: 3px 0;
        }
        .warning-box strong {
            color: #e65100;
        }

        /* URL box */
        .url-box {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 25px;
            word-break: break-all;
            font-size: 12px;
            color: #666;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #eee;
            margin: 25px 0;
        }

        /* Footer */
        .email-footer {
            background: #1a237e;
            padding: 25px 30px;
            text-align: center;
        }
        .email-footer p {
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            margin: 3px 0;
        }
        .email-footer .footer-brand {
            color: #ffc107;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">

        {{-- Header --}}
        <div class="email-header">
            <div class="icon-circle">🏨</div>
            <h1>HMS Portal</h1>
            <p>Hostel Management System — Hyderabad</p>
        </div>

        {{-- Body --}}
        <div class="email-body">

            <div class="greeting">
                Hello, {{ $userName }}!
            </div>

            <div class="message">
                We received a request to reset your password for your <strong>HMS Portal</strong> account.
                Click the button below to create a new password.
            </div>

            {{-- Reset Button --}}
            <div class="btn-wrapper">
                <a href="{{ $resetUrl }}" class="btn-reset">
                    🔐 Reset My Password
                </a>
            </div>

            {{-- Warning Box --}}
            <div class="warning-box">
                <p>⏰ <strong>This link expires in 60 minutes.</strong></p>
                <p>🔒 If you did not request this, please ignore this email.</p>
                <p>✅ Your password will not change until you click the link.</p>
            </div>

            {{-- Manual URL --}}
            <p style="font-size:13px; color:#888; margin-bottom:8px;">
                If the button doesn't work, copy and paste this link:
            </p>
            <div class="url-box">
                {{ $resetUrl }}
            </div>

            <hr class="divider">

            <p style="font-size:13px; color:#888; text-align:center;">
                This email was sent from <strong>HMS Portal</strong>.<br>
                Please do not reply to this email.
            </p>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <div class="footer-brand">🏨 HMS Portal</div>
            <p>Hostel Management System</p>
            <p>Hyderabad, Sindh, Pakistan</p>
            <p style="margin-top:10px; font-size:11px; opacity:0.6;">
                © {{ date('Y') }} HMS Portal. All rights reserved.
            </p>
        </div>

    </div>
</body>
</html>
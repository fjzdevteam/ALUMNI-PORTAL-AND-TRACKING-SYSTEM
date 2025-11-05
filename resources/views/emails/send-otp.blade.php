<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f9fafb; font-family: 'Inter', Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="max-width: 500px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="padding: 32px 40px; text-align: center;">
                            <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 16px;">
                                Password Reset Request
                            </h1>

                            <p style="font-size: 15px; color: #374151; margin-bottom: 24px;">
                                We received a request to reset your password. Please use the following one-time passcode
                                (OTP) to verify your identity.
                            </p>

                            <div
                                style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #2563eb; margin: 20px 0;">
                                {{ $otp }}
                            </div>

                            <p style="font-size: 14px; color: #6b7280; margin-bottom: 32px;">
                                This code will expire in <strong>1 minute</strong>. If you didn’t request a password
                                reset, please ignore this message.
                            </p>

                            <p
                                style="font-size: 13px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 16px; margin-top: 24px;">
                                &copy; {{ date('Y') }} Pamantasan ng Lungsod ng Pasig. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

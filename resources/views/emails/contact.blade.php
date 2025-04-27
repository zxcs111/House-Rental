<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f7f9fc;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f9fc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; box-shadow: 0 6px 12px rgba(0,0,0,0.08); overflow: hidden;">
                    <!-- Logo Header -->
                    <tr>
                        <td style="background-color: #ffffff; padding: 30px 20px; text-align: center;">
                            <img src="{{ asset('user-template/images/logo.png') }}" alt="Stay Haven Logo" style="max-width: 150px; height: auto; display: block; margin: 0 auto;">
                            <h2 style="font-size: 20px; color: #1e3a8a; margin: 15px 0 0; font-weight: 600;">New Contact Message</h2>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 12px 0; font-size: 15px; color: #1e3a8a;">
                                        <strong style="display: inline-block; width: 100px;">Name:</strong> {{ $data['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; font-size: 15px; color: #1e3a8a;">
                                        <strong style="display: inline-block; width: 100px;">Email:</strong> 
                                        <a href="mailto:{{ $data['email'] }}" style="color: #3b82f6; text-decoration: none;">{{ $data['email'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; font-size: 15px; color: #1e3a8a;">
                                        <strong style="display: inline-block; width: 100px;">Subject:</strong> {{ $data['subject'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 0; font-size: 15px; color: #1e3a8a;">
                                        <strong style="display: inline-block; width: 100px;">Message:</strong>
                                        <div style="margin-top: 10px; padding: 20px; background-color: #f1f5f9; border-radius: 8px; font-size: 14px; color: #1e3a8a; line-height: 1.8;">
                                            {{ $data['message'] }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 20px 0;">
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f1f5f9; padding: 20px 40px; text-align: center;">
                            <p style="margin: 0; font-size: 13px; color: #475569;">
                                Sent via the <a href="{{ url('/') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Stay Haven</a> contact form
                            </p>
                            <p style="margin: 10px 0 0; font-size: 13px; color: #475569;">
                                Stay Haven | Lapu-Lapu City, Cebu, Philippines<br>
                                <a href="tel:+639955142653" style="color: #3b82f6; text-decoration: none;">+63 995 5142 653</a> | 
                                <a href="mailto:johnlloydjustiniane13@gmail.com" style="color: #3b82f6; text-decoration: none;">johnlloydjustiniane13@gmail.com</a>
                            </p>
                            <p style="margin: 15px 0 0; font-size: 12px; color: #94a3b8;">
                                © {{ date('Y') }} Stay Haven. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
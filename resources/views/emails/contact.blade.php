<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #ffffff; padding: 30px 20px; text-align: center;">
                            <h1 style="font-size: 28px; margin: 0; font-weight: 700; font-family: 'Poppins', Arial, sans-serif;">
                                <span style="color: #000000;">STAY</span><span style="color: #01d28e;">HAVEN</span>
                            </h1>
                            <h2 style="font-size: 18px; color: #333333; margin: 10px 0 0; font-weight: 600;">New Contact Message</h2>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #333333;">
                                        <strong style="display: inline-block; width: 100px; color: #000000;">Name:</strong> {{ $data['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #333333;">
                                        <strong style="display: inline-block; width: 100px; color: #000000;">Email:</strong> 
                                        <a href="mailto:{{ $data['email'] }}" style="color: #0000ff; text-decoration: none;">{{ $data['email'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #333333;">
                                        <strong style="display: inline-block; width: 100px; color: #000000;">Subject:</strong> {{ $data['subject'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 14px; color: #333333;">
                                        <strong style="display: inline-block; width: 100px; color: #000000;">Message:</strong>
                                        <div style="margin-top: 10px; padding: 15px; background-color: #f9fafb; border-radius: 6px; font-size: 14px; color: #333333; line-height: 1.7;">
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
                            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 40px; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #4b5563;">
                                Sent via the <a href="{{ url('/') }}" style="color: #01d28e; text-decoration: none; font-weight: 500;">Stay Haven</a> contact form
                            </p>
                            <p style="margin: 8px 0 0; font-size: 12px; color: #4b5563;">
                                Stay Haven | Lapu-Lapu City, Cebu, Philippines<br>
                                <a href="tel:+639955142653" style="color: #01d28e; text-decoration: none;">+63 995 5142 653</a> | 
                                <a href="mailto:johnlloydjustiniane13@gmail.com" style="color: #01d28e; text-decoration: none;">johnlloydjustiniane13@gmail.com</a>
                            </p>
                            <p style="margin: 12px 0 0; font-size: 11px; color: #6b7280;">
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
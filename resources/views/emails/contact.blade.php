<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Message</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #3085d6; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 24px; color: #ffffff; font-weight: 500;">Stay Haven</h1>
                            <p style="margin: 5px 0 0; font-size: 14px; color: #e6f0fa;">New Contact Message</p>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="font-size: 20px; color: #3085d6; margin: 0 0 20px;">Message Details</h2>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 10px 0; font-size: 16px;">
                                        <strong style="color: #333333;">Name:</strong> {{ $data['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 16px;">
                                        <strong style="color: #333333;">Email:</strong> <a href="mailto:{{ $data['email'] }}" style="color: #3085d6; text-decoration: none;">{{ $data['email'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 16px;">
                                        <strong style="color: #333333;">Subject:</strong> {{ $data['subject'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; font-size: 16px;">
                                        <strong style="color: #333333;">Message:</strong>
                                        <div style="margin-top: 10px; padding: 15px; background-color: #f8fafc; border-radius: 8px; font-size: 14px; color: #333333;">
                                            {{ $data['message'] }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 12px; color: #64748b;">
                                This message was sent via the <a href="{{ url('/') }}" style="color: #3085d6; text-decoration: none;">Stay Haven</a> contact form.
                            </p>
                            <p style="margin: 10px 0 0; font-size: 12px; color: #64748b;">
                                Stay Haven | Lapu-Lapu City, Cebu, Philippines<br>
                                <a href="tel:+639955142653" style="color: #3085d6; text-decoration: none;">+63 995 5142 653</a> | 
                                <a href="mailto:johnlloydjustiniane13@gmail.com" style="color: #3085d6; text-decoration: none;">johnlloydjustiniane13@gmail.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
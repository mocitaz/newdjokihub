<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DjokiHub Notification</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0; padding: 0; width: 100%; height: 100%; background-color: #f1f5f9; font-family: 'Plus Jakarta Sans', Helvetica, Arial, sans-serif;
        }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f1f5f9; padding: 40px 0; }
        .main-container {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 50px -10px rgba(15, 23, 42, 0.1);
            border: 1px solid #e2e8f0;
        }
        .header {
            padding: 40px 40px 20px;
            text-align: center;
            background: linear-gradient(to bottom, #ffffff, #f8fafc);
        }
        .content { padding: 0 40px 40px; }
        .footer {
            background-color: #f8fafc;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px dashed #e2e8f0;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: #1e293b;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 14px;
            font-size: 14px;
            transition: all 0.2s;
            margin-top: 24px;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.2);
        }
        .btn:hover { background: #0f172a; transform: translateY(-1px); }
        
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 24px;
            margin: 24px 0;
            text-align: left;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 12px;
        }
        .info-item:last-child { margin-bottom: 0; border-bottom: none; padding-bottom: 0; }
        .info-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }
        .info-value {
            color: #0f172a;
            font-weight: 600;
            text-align: right;
        }
        
        h1 { margin: 0 0 12px; color: #0f172a; font-size: 24px; letter-spacing: -0.03em; font-weight: 800; }
        p { margin: 0 0 16px; color: #475569; font-size: 15px; line-height: 1.6; }
        .highlight-text { font-size: 13px; color: #64748b; line-height: 1.6; background: #fff; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 24px; }
        
        .footer-logo { opacity: 0.7; transition: opacity 0.2s; }
        .footer-logo:hover { opacity: 1; }
    </style>
</head>
<body>
    <center class="wrapper">
        <table class="main-container" cellspacing="0" cellpadding="0">
            <!-- HEADER -->
            <tr>
                <td class="header">
                    <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="DjokiHub" width="130" style="height: auto; border: 0;">
                </td>
            </tr>

            <!-- CONTENT -->
            <tr>
                <td class="content">
                    @yield('content')
                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td class="footer">
                    <p style="color: #94a3b8; font-size: 11px; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600;">Powered By</p>
                    <!-- Teknalogi Logo Smaller -->
                    <img src="{{ $message->embed(public_path('images/teknalogi.png')) }}" alt="Teknalogi" width="70" class="footer-logo" style="height: auto; border: 0;">
                    
                    <p style="color: #cbd5e1; font-size: 11px; margin-top: 24px;">
                        &copy; {{ date('Y') }} DjokiHub Ecosystem.<br>
                        Building Future Tech.
                    </p>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>

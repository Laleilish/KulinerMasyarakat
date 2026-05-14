<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi</title>
    <style>
        body {
            font-family: 'Plus Jakarta Sans';
            background-color: #FDF4E7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(4, 8, 24, 0.10);
        }
        .header {
            padding: 30px 20px;
        }

        .header img{
            height: 60px;
        }
        .content {
            padding: 0 30px;
            text-align: center;
        }
        .greeting {
            font-size: 18px;
            color: #040818;
            margin-bottom: 20px;
        }
        .otp-box {
            background-color: #FDF4E7;
            border: 2px dashed #960913;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 42px;
            font-weight: bold;
            color: #960913;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .message {
            color: #5D6E86;
            font-size: 14px;
            line-height: 1.6;
            margin: 20px 0;
        }
        .warning {
            background-color: #FFF3CD;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
        .warning p {
            margin: 0;
            color: #040818;
            font-size: 14px;
        }
        .footer {
            background-color: #F8F9FA;
            padding: 20px;
            text-align: center;
            color: #5D6E86;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://res.cloudinary.com/dg5cordxc/image/upload/v1778740460/icon-kumar_mld0e7.png" alt="KUMAR">
        </div>

        <div class="content">
            <p class="greeting">Halo, <strong>{{ $userName }}</strong>!</p>

            <p class="message">
                Kami menerima permintaan login ke akun KUMAR Anda.
                Gunakan kode OTP berikut untuk melanjutkan:
            </p>

            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <p class="message">
                Kode OTP ini akan <strong>kadaluarsa dalam 10 menit</strong>.
            </p>

            <div class="warning">
                <p><strong> Waspada </strong></p>
                <p>Jangan bagikan kode ini kepada siapa pun, termasuk pihak KUMAR!</p>
                <p>KUMAR tidak akan pernah meminta kode OTP Anda Jika Anda tidak melakukan login, abaikan email ini</p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} KUMAR. All rights reserved.</p>
            <p>Email otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>

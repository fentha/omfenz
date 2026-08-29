<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menunggu Pembayaran - Omfenz Digital</title>
    <link rel="icon" type="image/png" href="{{ url('assets/brand/omfenz-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
        }
        .pending-box {
            background: #fff;
            border-radius: 16px;
            padding: 40px 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .icon-pending {
            font-size: 60px;
            color: #f6ad55;
            margin-bottom: 20px;
        }
        .btn-access {
            background: linear-gradient(135deg, #f6ad55 0%, #dd6b20 100%);
            color: white;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 800;
            font-size: 1.1rem;
            border: none;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .btn-access:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(221, 107, 32, 0.3);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="pending-box">
            <div class="icon-pending">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
            </div>
            <h1 class="fw-bold mb-3">Menunggu Pembayaran!</h1>
            <p class="mb-4">Order ID Anda: <strong>#{{ $order->id }}</strong></p>
            
            <div class="alert alert-warning text-start" role="alert">
                <strong>Perhatian:</strong> Pembayaran Anda belum kami terima atau masih dalam proses. Silakan selesaikan pembayaran Anda atau tunggu beberapa saat jika Anda sudah membayar.
            </div>

            @if($order->payment_url)
            <a href="{{ $order->payment_url }}" class="btn-access w-100">
                LANJUTKAN KE HALAMAN PEMBAYARAN
            </a>
            @endif

            <div class="mt-4 pt-4 border-top">
                <p class="text-muted small">Jika Anda sudah membayar dan status belum berubah, atau ada kendala lain, silakan hubungi CS kami.</p>
                <a href="https://wa.me/6285113655806" class="btn btn-outline-warning btn-sm rounded-pill px-4" style="color: #dd6b20; border-color: #dd6b20;">
                    Hubungi CS via WhatsApp
                </a>
            </div>
        </div>
    </div>
</body>
</html>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil - Omfenz Digital</title>
    <link rel="icon" type="image/png" href="{{ url('assets/brand/omfenz-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">

    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2123472395268686');
        fbq('track', 'PageView');
        fbq('track', 'Purchase', {value: 49000, currency: 'IDR'});
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=2123472395268686&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
        }
        .success-box {
            background: #fff;
            border-radius: 16px;
            padding: 40px 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }
        .icon-success {
            font-size: 60px;
            color: #38a169;
            margin-bottom: 20px;
        }
        .btn-access {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
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
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-box">
            <div class="icon-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <h1 class="fw-bold mb-3">Pembayaran Berhasil!</h1>
            <p class="mb-4">Terima kasih atas pembelian Anda. Order ID Anda: <strong>#{{ request()->order_id }}</strong></p>
            
            <div class="alert alert-info text-start" role="alert">
                <strong>Penting:</strong> Akses Google Drive Anda bisa langsung dibuka dengan mengklik tombol di bawah ini. Harap segera mendownload/menyimpan aksesnya.
            </div>

            <a href="https://drive.google.com/drive/folders/1w9EHs2jMM8jMypicDPVYL1tNHpfomMOZ" target="_blank" class="btn-access w-100">
                BUKA AKSES GOOGLE DRIVE SEKARANG
            </a>

            <div class="mt-4 pt-4 border-top">
                <p class="text-muted small">Jika Anda mengalami kendala atau link tidak bisa dibuka, silakan hubungi CS kami.</p>
                <a href="https://wa.me/6285113655806" class="btn btn-outline-success btn-sm rounded-pill px-4">
                    Hubungi CS via WhatsApp
                </a>
            </div>
        </div>
    </div>
</body>
</html>

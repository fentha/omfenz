<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            color: #333333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #FF6B6B;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Terima Kasih, {{ $order->name }}!</h2>
            <p>Pembayaran Anda Telah Berhasil Dikonfirmasi.</p>
        </div>
        
        <p>Halo <strong>{{ $order->name }}</strong>,</p>
        <p>Terima kasih telah membeli <strong>Paket 99.000++ Lembar Aktivitas Anak</strong>. Kami sangat senang bisa menjadi bagian dari proses belajar dan bermain anak Anda.</p>
        
        <p>Detail Pesanan Anda:</p>
        <ul>
            <li><strong>Order ID:</strong> #{{ $order->id }}</li>
            <li><strong>Total Bayar:</strong> Rp {{ number_format($order->amount, 0, ',', '.') }}</li>
            <li><strong>Status:</strong> Lunas</li>
        </ul>

        <p>Sesuai janji kami, berikut adalah tombol untuk langsung mengakses dan mengunduh seluruh materi dari Google Drive kami:</p>
        
        <div style="text-align: center;">
            <a href="https://drive.google.com/drive/folders/1w9EHs2jMM8jMypicDPVYL1tNHpfomMOZ" class="btn">Buka Akses Google Drive Sekarang</a>
        </div>

        <p style="margin-top: 25px;"><strong>Tips:</strong><br>Anda tidak perlu mendownload semua file sekaligus agar memori HP/Laptop tidak penuh. Cukup buka link di atas dan download file yang ingin dicetak hari ini saja.</p>

        <p>Jika ada pertanyaan atau kendala akses, silakan balas email ini atau hubungi CS kami via WhatsApp di 0851-1365-5806.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Omfenz Digital. Hak cipta dilindungi.</p>
        </div>
    </div>
</body>
</html>

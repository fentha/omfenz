<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontak Kami - Omfenz Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; color: #2d3748; }
        .page-header { background: linear-gradient(135deg, #0ea5e9, #2563eb); color: white; padding: 40px 20px; text-align: center; }
        .content-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-top: -30px; margin-bottom: 50px; text-align: center;}
        .contact-item { margin-bottom: 30px; }
        .contact-icon { font-size: 32px; color: #2563eb; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1 class="fw-bold">Hubungi Kami</h1>
    </div>
    <div class="container">
        <div class="content-box">
            <p class="mb-5 text-muted">Jika Anda memiliki pertanyaan seputar produk kami atau membutuhkan bantuan teknis terkait pesanan Anda, jangan ragu untuk menghubungi kami melalui saluran di bawah ini.</p>
            
            <div class="row">
                <div class="col-md-4 contact-item">
                    <div class="contact-icon">✉️</div>
                    <h5 class="fw-bold">Email</h5>
                    <p><a href="mailto:info@omfenz.com" class="text-decoration-none">info@omfenz.com</a></p>
                </div>
                <div class="col-md-4 contact-item">
                    <div class="contact-icon">📱</div>
                    <h5 class="fw-bold">WhatsApp / Telepon</h5>
                    <p><a href="https://wa.me/6285113655806" class="text-decoration-none">0851-1365-5806</a><br><small class="text-muted">(Jam Kerja: 08.00 - 17.00 WIB)</small></p>
                </div>
                <div class="col-md-4 contact-item">
                    <div class="contact-icon">📍</div>
                    <h5 class="fw-bold">Alamat Usaha</h5>
                    <p>Omfenz Digital<br>Perum Gejawan Indah J/153<br>Balecatur, Gamping, Sleman</p>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 rounded-pill">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>

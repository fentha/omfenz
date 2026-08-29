<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Omfenz Digital</title>
    <meta name="description" content="Gudangnya Aset Digital & Edukasi Premium. Beli 1x, Akses Selamanya!">

    <link rel="icon" type="image/png" href="{{ url('assets/brand/omfenz-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f4f6f9;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #14213d;
        }

        .biolink-wrapper {
            max-width: 600px;
            min-height: 100vh;
            margin: 0 auto;
            padding: 48px 20px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-logo-wrap {
            width: 148px;
            height: 148px;
            border-radius: 50%;
            background: #ffffff;
            border: 6px solid #ffffff;
            box-shadow: 0 16px 38px rgba(15, 23, 42, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            overflow: hidden;
        }

        .profile-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .brand-title {
            font-weight: 900;
            letter-spacing: 0;
            margin-bottom: 8px;
        }

        .brand-description {
            max-width: 430px;
            margin: 0 auto;
            color: #64748b;
            line-height: 1.6;
            font-size: 15px;
        }

        .link-list {
            margin-top: 34px;
        }

        .bio-link {
            width: 100%;
            min-height: 64px;
            border-radius: 18px;
            padding: 17px 20px;
            font-weight: 850;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-align: center;
            color: #ffffff;
            background: linear-gradient(135deg, #0ea5e9, #2563eb 52%, #8b5cf6);
            box-shadow: 0 16px 34px rgba(37, 99, 235, .28);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .bio-link:hover {
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 20px 42px rgba(37, 99, 235, .34);
        }

        .link-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 34px;
        }

        .link-text {
            line-height: 1.25;
        }

        .footer-links a {
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: #2563eb;
        }

        .copyright {
            color: #94a3b8;
            font-size: 13px;
        }

        @media (max-width: 420px) {
            .biolink-wrapper {
                padding-inline: 16px;
            }

            .profile-logo-wrap {
                width: 132px;
                height: 132px;
            }
        }
    </style>

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
    </script>
    <!-- End Meta Pixel Code -->
</head>
<body>
    <!-- Meta Pixel Code -->
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=2123472395268686&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    <main class="biolink-wrapper">
        <header class="text-center">
            <div class="profile-logo-wrap">
                <img src="{{ url('assets/brand/omfenz-logo.png') }}" alt="Logo Omfenz Digital" class="profile-logo">
            </div>

            <h1 class="brand-title h3">Omfenz Digital</h1>
            <p class="brand-description">
                Gudangnya Aset Digital &amp; Edukasi Premium. Beli 1x, Akses Selamanya!
            </p>
        </header>

        <section class="link-list" aria-label="Daftar tautan utama">
            <a href="{{ url('/aktivitas-anak') }}" class="bio-link">
                <span class="link-icon" aria-hidden="true">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 19.5V5.8C4 4.81 4.81 4 5.8 4H18C19.1 4 20 4.9 20 6V18.2C20 18.64 19.64 19 19.2 19H6.5C5.12 19 4 20.12 4 21.5V19.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 8H16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 12H14" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="link-text">Promo: 99.000++ Lembar Aktivitas Anak</span>
            </a>
        </section>

        <footer class="mt-5 pt-4 pb-4 border-top" style="text-align: center; font-size: 0.9rem; color: #4a5568;">
            <div class="container">
                <div class="d-flex flex-column flex-sm-row justify-content-between text-start mb-3 gap-4">
                    <div>
                        <strong class="d-block mb-2" style="color: #2d3748;">Hubungi Kami</strong>
                        Omfenz Digital<br>
                        Email: info@omfenz.com<br>
                        Telepon/WA: 0851-1365-5806<br>
                        Alamat: Perum Gejawan Indah J/153 Balecatur, Gamping, Sleman
                    </div>
                    <div class="text-sm-end">
                        <strong class="d-block mb-2" style="color: #2d3748;">Kebijakan & Ketentuan</strong>
                        <a href="{{ url('/syarat-ketentuan') }}" class="text-decoration-none" style="color: #4a5568;">Syarat & Ketentuan</a><br>
                        <a href="{{ url('/refund-policy') }}" class="text-decoration-none" style="color: #4a5568;">Kebijakan Pengembalian Dana (Refund Policy)</a><br>
                        <a href="{{ url('/faq') }}" class="text-decoration-none" style="color: #4a5568;">FAQ (Pertanyaan Umum)</a><br>
                        <a href="{{ url('/kontak') }}" class="text-decoration-none" style="color: #4a5568;">Kontak Kami</a>
                    </div>
                </div>
                
                <div class="copyright text-center pt-3 mt-3 border-top" style="font-size: 0.8rem;">
                    &copy; {{ date('Y') }} Omfenz Digital. Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


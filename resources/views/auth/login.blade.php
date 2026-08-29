<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Omfenz Digital</title>
    
    <link rel="icon" type="image/png" href="{{ url('assets/brand/omfenz-logo.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle background glow */
        body::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        .login-logo-wrap {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 16px;
            border: 4px solid #ffffff;
        }

        .login-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 14px;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border-color: #cbd5e1;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .btn-login {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        }
    </style>
</head>
<body>

<div class="login-card p-4 p-sm-5">
    
    <!-- Brand Logo -->
    <div class="login-logo-wrap">
        <img src="{{ url('assets/brand/omfenz-logo.png') }}" alt="Omfenz Logo">
    </div>

    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark mb-1">Masuk Panel Admin</h4>
        <p class="text-muted small mb-0">Silakan login untuk mengelola sistem Omfenz</p>
    </div>

    <!-- Session / Error Alerts -->
    @if (session('status'))
        <div class="alert alert-info py-2 px-3 small rounded-3 mb-3">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
            <ul class="m-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label small fw-semibold text-secondary">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control border-start-0 rounded-end-3" placeholder="fenthalari@gmail.com">
            </div>
        </div>

        <!-- Password Field -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="password" class="form-label small fw-semibold text-secondary mb-1">Password</label>
            </div>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0 rounded-start-3"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control border-start-0 border-end-0" placeholder="••••••••">
                <button class="input-group-text bg-light text-muted border-start-0 rounded-end-3" type="button" onclick="togglePasswordVisibility()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label small text-muted" for="remember_me">
                Ingat sesi login saya
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-login w-100 mb-3">
            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Dashboard
        </button>

        <div class="text-center">
            <a href="{{ url('/') }}" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Utama
            </a>
        </div>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
</script>

</body>
</html>

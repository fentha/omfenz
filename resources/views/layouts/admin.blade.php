<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Omfenz Digital</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ url('assets/brand/omfenz-logo.png') }}">

    <!-- Google Font (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #3b82f6;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --body-bg: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            color: #1e293b;
            min-height: 100vh;
        }

        /* App Wrapper */
        #app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease-in-out;
            z-index: 1040;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .sidebar-brand img {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #fff;
            padding: 2px;
        }

        .sidebar-brand span {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.02em;
        }

        .sidebar-brand .badge {
            font-size: 0.65rem;
            letter-spacing: 0.05em;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 1.25rem 1.5rem 0.5rem;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0.5rem 0.75rem;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 4px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--sidebar-text);
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
            text-decoration: none;
            gap: 12px;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.15rem;
            line-height: 1;
        }

        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--sidebar-active);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        .sidebar-user {
            padding: 1rem 1.25rem;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        /* Main Content */
        #main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            overflow-x: hidden;
        }

        /* Top Navbar */
        .top-navbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Cards & Components */
        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.03);
            background: #ffffff;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .badge-status {
            font-weight: 600;
            padding: 0.35em 0.75em;
            border-radius: 50rem;
            font-size: 0.75rem;
        }

        /* Mobile Sidebar Backdrop */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1030;
            display: none;
        }

        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                position: fixed;
                top: 0;
                bottom: 0;
                left: calc(-1 * var(--sidebar-width));
            }

            #sidebar-wrapper.show {
                left: 0;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<div id="app-wrapper">
    
    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar-wrapper">
        <!-- Brand Header -->
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ url('assets/brand/omfenz-logo.png') }}" alt="Omfenz Logo">
            <div>
                <span>OMFENZ</span>
                <span class="badge bg-primary ms-1">ADMIN</span>
            </div>
        </a>

        <!-- Sidebar Navigation Menu -->
        <div class="sidebar-heading">Menu Utama</div>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check-fill"></i>
                    <span>Pesanan / Orders</span>
                </a>
            </li>

            <div class="sidebar-heading mt-3">Akun & Sistem</div>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/') }}" target="_blank" class="nav-link text-info-emphasis">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <!-- Sidebar User Footer -->
        <div class="sidebar-user">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 overflow-hidden">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; flex-shrink: 0; font-size: 0.85rem;">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-truncate">
                        <div class="text-white fw-semibold text-truncate small">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-secondary text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1 text-danger" title="Keluar / Logout">
                        <i class="bi bi-power fs-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div id="main-wrapper">
        
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light border d-lg-none" type="button" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h5 class="m-0 fw-bold text-dark">@yield('page-title', 'Dashboard')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Direct Website Link -->
                <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-light border d-none d-md-inline-flex align-items-center gap-1 text-secondary fw-medium">
                    <i class="bi bi-globe"></i>
                    <span>Buka Web</span>
                </a>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2.5 rounded-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 26px; height: 26px; font-size: 0.75rem;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="fw-semibold small d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold small">{{ Auth::user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                        </li>
                        <li><a class="dropdown-item py-2 small" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Edit Profil</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 small text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-3 p-md-4 flex-grow-1">
            
            <!-- Global Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i>
                    <div>{{ session('warning') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 rounded-3" role="alert">
                    <i class="bi bi-x-circle-fill fs-5 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="py-3 px-4 bg-white border-top text-center text-muted small">
            &copy; {{ date('Y') }} <strong>Omfenz Digital</strong>. All rights reserved.
        </footer>
    </div>
</div>

<!-- Bootstrap 5.3.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar-wrapper');
        const backdrop = document.getElementById('sidebarBackdrop');
        sidebar.classList.toggle('show');
        backdrop.classList.toggle('show');
    }
</script>
@stack('scripts')
</body>
</html>

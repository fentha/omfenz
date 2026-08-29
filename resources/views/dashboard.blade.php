@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Ringkasan')

@section('content')
<div class="container-fluid p-0">
    
    <!-- Top Welcome Card -->
    <div class="card card-custom border-0 bg-primary text-white mb-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
        <div class="card-body p-4 position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary fw-bold mb-2">Panel Kontrol Omfenz</span>
                    <h3 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-white-50 mb-0">Selamat datang di sistem manajemen penjualan Omfenz Digital. Pantau pesanan dan transaksi pelanggan secara praktis.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('orders.index') }}" class="btn btn-light text-primary fw-semibold px-3 py-2 rounded-3 shadow-sm">
                        <i class="bi bi-cart-check me-1"></i> Kelola Semua Pesanan
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative background icon -->
        <i class="bi bi-graph-up-arrow position-absolute text-white opacity-10" style="font-size: 10rem; right: -20px; bottom: -35px;"></i>
    </div>

    <!-- Summary Stats Cards -->
    <div class="row g-3 mb-4">
        
        <!-- Total Orders -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-custom h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-semibold">Total Pesanan</span>
                        <h3 class="fw-bold text-dark my-1">{{ number_format($totalOrders) }}</h3>
                        <span class="text-muted small">Semua data pesanan</span>
                    </div>
                    <div class="stat-card-icon bg-primary-subtle text-primary">
                        <i class="bi bi-bag-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Success -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-custom h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-success small text-uppercase fw-bold">Pesanan Lunas</span>
                        <h3 class="fw-bold text-success my-1">{{ number_format($totalSuccess) }}</h3>
                        <span class="text-success small"><i class="bi bi-check-circle me-1"></i>Transaksi selesai</span>
                    </div>
                    <div class="stat-card-icon bg-success-subtle text-success">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pending -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-custom h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-warning small text-uppercase fw-bold">Pending</span>
                        <h3 class="fw-bold text-warning my-1">{{ number_format($totalPending) }}</h3>
                        <span class="text-muted small"><i class="bi bi-clock-history me-1"></i>Menunggu bayar</span>
                    </div>
                    <div class="stat-card-icon bg-warning-subtle text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card card-custom h-100 p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-primary small text-uppercase fw-bold">Total Omset</span>
                        <h4 class="fw-bold text-dark my-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        <span class="text-muted small">Dari pesanan sukses</span>
                    </div>
                    <div class="stat-card-icon bg-info-subtle text-info">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Orders Table Card -->
    <div class="card card-custom border-0 mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <div>
                <h6 class="fw-bold text-dark m-0">5 Pesanan Terkini</h6>
                <small class="text-muted">Transaksi terbaru yang masuk ke sistem</small>
            </div>
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary fw-semibold rounded-3">
                Lihat Lengkap <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted text-uppercase small">
                        <tr>
                            <th class="ps-4">ID & Waktu Buat</th>
                            <th>Pelanggan</th>
                            <th>Metode Bayar</th>
                            <th>Nominal & Net</th>
                            <th>Status & Waktu Bayar</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($recentOrders as $order)
                            @php
                                $phoneClean = preg_replace('/[^0-9]/', '', $order->phone);
                                $phoneWa = str_starts_with($phoneClean, '0') ? '62' . substr($phoneClean, 1) : $phoneClean;
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">#{{ $order->id }}</span>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        {{ $order->created_at->format('d/m/Y H:i') }} WIB
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $order->name }}</div>
                                    <div class="text-muted small">{{ $order->email }}</div>
                                    <a href="https://wa.me/{{ $phoneWa }}?text=Halo%20Kak%20{{ urlencode($order->name) }},%20kami%20dari%20Omfenz%20Digital%20mengonfirmasi%20Order%20ID%20%23{{ $order->id }}." target="_blank" class="badge bg-success-subtle text-success text-decoration-none border border-success-subtle mt-0.5" style="font-size: 0.7rem;">
                                        <i class="bi bi-whatsapp me-1"></i>{{ $order->phone }}
                                    </a>
                                </td>
                                <td>
                                    @if($order->payment_method)
                                        <span class="badge bg-dark-subtle text-dark border mb-0.5" style="font-size: 0.75rem;">
                                            <i class="bi bi-credit-card me-1"></i>{{ $order->payment_method }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                    @if($order->ipaymu_trx_id)
                                        <div class="text-secondary font-monospace" style="font-size: 0.72rem;">TRX: {{ $order->ipaymu_trx_id }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">Rp {{ number_format($order->amount, 0, ',', '.') }}</div>
                                    @if($order->fee > 0 || $order->net_amount)
                                        <div class="text-muted" style="font-size: 0.72rem;">
                                            <span>Fee: Rp {{ number_format($order->fee, 0, ',', '.') }}</span><br>
                                            <span class="text-success fw-semibold">Net: Rp {{ number_format($order->net_amount ?? ($order->amount - $order->fee), 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status === 'success' || $order->status === 'berhasil')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle badge-status">
                                            <i class="bi bi-check-circle-fill me-1"></i>Lunas / Sukses
                                        </span>
                                    @elseif ($order->status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle badge-status">
                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle badge-status">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif

                                    @if($order->paid_at)
                                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                                            <i class="bi bi-calendar2-check text-success me-1"></i>Bayar: {{ $order->paid_at->format('d/m/Y H:i') }} WIB
                                        </div>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('orders.index', ['search' => $order->id]) }}" class="btn btn-sm btn-light border fw-semibold">
                                        Kelola &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Belum ada transaksi pesanan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

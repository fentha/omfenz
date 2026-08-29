@extends('layouts.admin')

@section('title', 'Daftar Pesanan')
@section('page-title', 'Kelola Pesanan (Orders)')

@section('content')
<div class="container-fluid p-0">

    <!-- Summary Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card card-custom p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Pesanan</div>
                        <h4 class="fw-bold my-1 text-dark">{{ number_format($totalOrders) }}</h4>
                    </div>
                    <div class="stat-card-icon bg-primary-subtle text-primary">
                        <i class="bi bi-cart3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-custom p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-success small fw-semibold text-uppercase">Sukses / Lunas</div>
                        <h4 class="fw-bold my-1 text-success">{{ number_format($totalSuccess) }}</h4>
                    </div>
                    <div class="stat-card-icon bg-success-subtle text-success">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-custom p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-warning small fw-semibold text-uppercase">Pending</div>
                        <h4 class="fw-bold my-1 text-warning">{{ number_format($totalPending) }}</h4>
                    </div>
                    <div class="stat-card-icon bg-warning-subtle text-warning">
                        <i class="bi bi-hourglass"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-custom p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-primary small fw-semibold text-uppercase">Total Omset</div>
                        <h5 class="fw-bold my-1 text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h5>
                    </div>
                    <div class="stat-card-icon bg-info-subtle text-info">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card card-custom border-0 mb-4 p-3">
        <form method="GET" action="{{ route('orders.index') }}" class="row g-2 align-items-center">
            
            <!-- Search Keyword -->
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 bg-light" placeholder="Cari nama, email, nomor WhatsApp, atau ID...">
                </div>
            </div>

            <!-- Status Filter Dropdown -->
            <div class="col-6 col-md-3">
                <select name="status" onchange="this.form.submit()" class="form-select bg-light">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>🟢 Sukses / Lunas</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟡 Menunggu Bayar (Pending)</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>🔴 Gagal / Batal</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="col-6 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-semibold px-3 flex-grow-1">
                    Filter
                </button>
                @if(request('search') || (request('status') && request('status') != 'all'))
                    <a href="{{ route('orders.index') }}" class="btn btn-light border" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Orders Table Card -->
    <div class="card card-custom border-0 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <h6 class="fw-bold text-dark m-0">
                <i class="bi bi-list-check me-1 text-primary"></i> Data Pesanan
            </h6>
            <span class="badge bg-light text-secondary border">Total: {{ $orders->total() }} Data</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted text-uppercase small">
                    <tr>
                        <th class="ps-4">ID & Tanggal Buat</th>
                        <th>Pelanggan</th>
                        <th>WhatsApp / HP</th>
                        <th>Metode Bayar</th>
                        <th>Nominal, Fee & Net</th>
                        <th>Status & Waktu Bayar</th>
                        <th class="pe-4 text-center">Kelola Status & Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @php
                            $phoneClean = preg_replace('/[^0-9]/', '', $order->phone);
                            $phoneWa = str_starts_with($phoneClean, '0') ? '62' . substr($phoneClean, 1) : $phoneClean;
                        @endphp
                        <tr>
                            <!-- ID & Date -->
                            <td class="ps-4">
                                <span class="fw-bold text-dark fs-6">#{{ $order->id }}</span>
                                <div class="text-muted small" style="font-size: 0.75rem;">
                                    {{ $order->created_at->format('d M Y, H:i') }} WIB
                                </div>
                            </td>

                            <!-- Customer Name & Email -->
                            <td>
                                <div class="fw-bold text-dark">{{ $order->name }}</div>
                                <div class="text-secondary small">{{ $order->email }}</div>
                            </td>

                            <!-- Phone & WhatsApp -->
                            <td>
                                <div class="font-monospace small text-dark mb-1">{{ $order->phone }}</div>
                                <a href="https://wa.me/{{ $phoneWa }}?text=Halo%20Kak%20{{ urlencode($order->name) }},%20kami%20dari%20Omfenz%20Digital%20ingin%20mengonfirmasi%20pesanan%20aktivitas%20anak%20dengan%20Order%20ID%20%23{{ $order->id }}." target="_blank" class="btn btn-sm btn-outline-success py-0 px-2 rounded-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-whatsapp me-1"></i>Chat WA
                                </a>
                            </td>

                            <!-- Payment Method & Gateway Info -->
                            <td>
                                @if($order->payment_method)
                                    <span class="badge bg-dark-subtle text-dark border mb-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-credit-card me-1"></i>{{ $order->payment_method }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted border mb-1" style="font-size: 0.72rem;">Belum Bayar</span>
                                @endif

                                @if($order->ipaymu_trx_id)
                                    <div class="text-dark small font-monospace" style="font-size: 0.72rem;">TRX: {{ $order->ipaymu_trx_id }}</div>
                                @endif
                                @if($order->payment_url)
                                    <div>
                                        <a href="{{ $order->payment_url }}" target="_blank" class="small text-primary text-decoration-none d-inline-flex align-items-center gap-1 mt-0.5" style="font-size: 0.75rem;">
                                            <span>Link Bayar</span> <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    </div>
                                @endif
                            </td>

                            <!-- Amount, Fee & Net Amount -->
                            <td>
                                <div class="fw-bold text-dark">Rp {{ number_format($order->amount, 0, ',', '.') }}</div>
                                @if($order->fee > 0 || $order->net_amount)
                                    <div class="text-muted" style="font-size: 0.72rem;">
                                        <span>Fee: Rp {{ number_format($order->fee, 0, ',', '.') }}</span><br>
                                        <span class="text-success fw-semibold">Net: Rp {{ number_format($order->net_amount ?? ($order->amount - $order->fee), 0, ',', '.') }}</span>
                                    </div>
                                @else
                                    <div class="text-muted" style="font-size: 0.72rem;">Fee: Rp 0</div>
                                @endif
                            </td>

                            <!-- Status Badge & Paid At -->
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
                                        <i class="bi bi-x-circle me-1"></i>{{ ucfirst($order->status) }}
                                    </span>
                                @endif

                                @if($order->paid_at)
                                    <div class="text-success small mt-1 fw-medium" style="font-size: 0.72rem;">
                                        <i class="bi bi-calendar2-check me-1"></i>{{ $order->paid_at->format('d/m/Y H:i') }} WIB
                                    </div>
                                @else
                                    <div class="text-muted small mt-1" style="font-size: 0.72rem;">
                                        <i class="bi bi-clock me-1"></i>Belum Lunas
                                    </div>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="pe-4 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    
                                    <!-- Quick Change Status Form -->
                                    <form method="POST" action="{{ route('orders.updateStatus', $order) }}" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="if(confirm('Ubah status Order #{{ $order->id }} ke ' + this.value.toUpperCase() + '?')) { this.form.submit(); } else { this.value = '{{ $order->status }}'; }" class="form-select form-select-sm py-1 px-2 border-secondary-subtle" style="font-size: 0.8rem; width: auto;" title="Ubah status manual">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="success" {{ $order->status == 'success' || $order->status == 'berhasil' ? 'selected' : '' }}>Success (Lunas)</option>
                                            <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed (Batal)</option>
                                        </select>
                                    </form>

                                    <!-- Sync with iPaymu API -->
                                    <form method="POST" action="{{ route('orders.syncStatus', $order) }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-info py-1 px-2" title="Cek Status Real-time ke API iPaymu">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>

                                    <!-- Resend Access Email (if success) -->
                                    @if($order->status === 'success' || $order->status === 'berhasil')
                                        <form method="POST" action="{{ route('orders.resendEmail', $order) }}" onsubmit="return confirm('Kirim ulang email akses produk ke {{ $order->email }}?')" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2" title="Kirim Ulang Email Akses">
                                                <i class="bi bi-envelope-arrow-up"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Order -->
                                    <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Hapus permanen data order #{{ $order->id }} ini?')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Hapus Order">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-search fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                Tidak ditemukan data pesanan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-center">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>
@endsection

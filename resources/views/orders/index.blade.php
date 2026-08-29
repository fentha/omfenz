<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Kelola Pesanan (Orders)') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pantau seluruh transaksi dan status pesanan pelanggan secara real-time</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Notifications -->
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="p-4 bg-amber-50 border-l-4 border-amber-500 text-amber-800 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-sm">{{ session('warning') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Total Orders -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Pesanan</p>
                        <p class="text-2xl font-black text-gray-900 mt-1">{{ number_format($totalOrders) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Success -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Pesanan Sukses / Lunas</p>
                        <p class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($totalSuccess) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Pending -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-amber-600">Menunggu Pembayaran</p>
                        <p class="text-2xl font-black text-amber-600 mt-1">{{ number_format($totalPending) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Total Omset (Sukses)</p>
                        <p class="text-2xl font-black text-indigo-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filters & Search Toolbar -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <form method="GET" action="{{ route('orders.index') }}" class="flex flex-col md:flex-row items-center gap-4">
                    
                    <!-- Search Field -->
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan, email, nomor HP, atau ID transaksi..." class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm transition" />
                    </div>

                    <!-- Status Filter -->
                    <div class="w-full md:w-56">
                        <select name="status" onchange="this.form.submit()" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 text-sm transition">
                            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>🟢 Sukses (Lunas)</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>🟡 Menunggu Pembayaran</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>🔴 Gagal / Batal</option>
                        </select>
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-initial inline-flex justify-center items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-sm transition duration-150">
                            Filter
                        </button>
                        @if(request('search') || (request('status') && request('status') != 'all'))
                            <a href="{{ route('orders.index') }}" class="inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition duration-150" title="Reset Filter">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50/80 text-gray-500 font-semibold text-xs uppercase tracking-wider">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID & Tanggal</th>
                                <th scope="col" class="px-6 py-4">Pelanggan</th>
                                <th scope="col" class="px-6 py-4">Kontak</th>
                                <th scope="col" class="px-6 py-4">Nominal</th>
                                <th scope="col" class="px-6 py-4">Status Pembayaran</th>
                                <th scope="col" class="px-6 py-4">Info Gateway</th>
                                <th scope="col" class="px-6 py-4 text-center">Aksi / Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($orders as $order)
                                @php
                                    // Bersihkan nomor HP untuk link WhatsApp
                                    $phoneClean = preg_replace('/[^0-9]/', '', $order->phone);
                                    if (str_starts_with($phoneClean, '0')) {
                                        $phoneWa = '62' . substr($phoneClean, 1);
                                    } elseif (str_starts_with($phoneClean, '62')) {
                                        $phoneWa = $phoneClean;
                                    } else {
                                        $phoneWa = '62' . $phoneClean;
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50/70 transition duration-150">
                                    
                                    <!-- ID & Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">#{{ $order->id }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">
                                            {{ $order->created_at->format('d M Y, H:i') }} WIB
                                        </div>
                                    </td>

                                    <!-- Customer Name & Email -->
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $order->name }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                            <span>{{ $order->email }}</span>
                                        </div>
                                    </td>

                                    <!-- Contact & WhatsApp -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-gray-800 text-xs font-mono mb-1">{{ $order->phone }}</div>
                                        <a href="https://wa.me/{{ $phoneWa }}?text=Halo%20Kak%20{{ urlencode($order->name) }},%20kami%20dari%20Omfenz%20Digital%20ingin%20mengonfirmasi%20pesanan%20aktivitas%20anak%20dengan%20Order%20ID%20%23{{ $order->id }}." target="_blank" class="inline-flex items-center text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1 rounded-md transition">
                                            <svg class="w-3.5 h-3.5 mr-1 fill-current" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                            </svg>
                                            Chat WhatsApp
                                        </a>
                                    </td>

                                    <!-- Amount -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">
                                            Rp {{ number_format($order->amount, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($order->status === 'success' || $order->status === 'berhasil')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                                Sukses / Lunas
                                            </span>
                                        @elseif ($order->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                                Pending (Menunggu)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Gateway Info -->
                                    <td class="px-6 py-4 text-xs">
                                        @if($order->ipaymu_trx_id)
                                            <div class="text-gray-700 font-mono">TRX: {{ $order->ipaymu_trx_id }}</div>
                                        @endif
                                        @if($order->payment_url)
                                            <a href="{{ $order->payment_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline inline-flex items-center mt-1">
                                                <span>Link Bayar</span>
                                                <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            
                                            <!-- Quick Status Update Dropdown/Form -->
                                            <form method="POST" action="{{ route('orders.updateStatus', $order) }}" class="inline-flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="if(confirm('Ubah status order #{{ $order->id }} ke ' + this.value + '?')) { this.form.submit(); } else { this.value = '{{ $order->status }}'; }" class="text-xs rounded-lg border-gray-300 py-1 pl-2 pr-7 font-medium text-gray-700 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="success" {{ $order->status == 'success' || $order->status == 'berhasil' ? 'selected' : '' }}>Success (Lunas)</option>
                                                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed (Batal)</option>
                                                </select>
                                            </form>

                                            <!-- Resend Email Button (if success) -->
                                            @if($order->status === 'success' || $order->status === 'berhasil')
                                                <form method="POST" action="{{ route('orders.resendEmail', $order) }}" onsubmit="return confirm('Kirim ulang email akses produk ke {{ $order->email }}?')">
                                                    @csrf
                                                    <button type="submit" title="Kirim Ulang Email Akses" class="p-1.5 text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete Order -->
                                            <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data order #{{ $order->id }} ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Order" class="p-1.5 text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="font-semibold text-gray-700">Tidak ada data pesanan ditemukan</p>
                                            <p class="text-xs text-gray-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter status Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

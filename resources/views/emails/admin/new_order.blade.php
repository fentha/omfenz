<x-mail::message>
# Halo Admin, Ada Order Baru (Pending)!

Ada pengguna yang baru saja mengisi form pembelian dan saat ini sedang dialihkan ke halaman pembayaran.

**Detail Pemesan:**
- **Nama:** {{ $order->name }}
- **Email:** {{ $order->email }}
- **WhatsApp:** {{ $order->phone }}
- **Jumlah Tagihan:** Rp {{ number_format($order->amount, 0, ',', '.') }}
- **Waktu Order:** {{ $order->created_at->format('d M Y H:i') }}

Jika dalam 5 menit belum ada pembayaran (status belum berubah jadi success), Anda bisa follow up ke nomor WhatsApp di atas.

<x-mail::button :url="'https://wa.me/'.preg_replace('/[^0-9]/', '', $order->phone).'?text='.urlencode('Halo Kak '.$order->name.', kami lihat ada pesanan untuk Aktivitas Anak yang belum diselesaikan pembayarannya. Apakah ada kendala?')">
Follow Up WhatsApp
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>

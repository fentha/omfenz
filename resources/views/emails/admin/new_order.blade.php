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

@php
    $payLink = $order->payment_url ?: url('/aktivitas-anak');
    $waText = "Halo Kak " . $order->name . ", salam kenal! 😊 Terima kasih sudah memesan *Paket Aktivitas Anak* (Order #" . $order->id . "). Wah, si kecil pasti bakal senang nih main dan belajar pakai materinya!\n\n"
        . "Kami cek pesanannya masih menunggu pembayaran nih Kak. Apakah ada kendala saat memilih metode bayar? Jangan sungkan kabari kami ya kalau butuh bantuan. 🙏\n\n"
        . "Kakak bisa langsung melanjutkan pembayaran melalui tautan resmi ini:\n"
        . "👉 " . $payLink . "\n\n"
        . "Link akses Google Drive otomatis terkirim ke email *" . $order->email . "* ya Kak setelah pembayaran lunas.\n\n"
        . "Ditunggu kabarnya, semoga harinya menyenangkan! 🤗";
@endphp

<x-mail::button :url="'https://wa.me/'.preg_replace('/[^0-9]/', '', $order->phone).'?text='.urlencode($waText)">
Follow Up WhatsApp
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>

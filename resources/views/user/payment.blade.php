@extends('layouts.landingpage')

@section('content')
    <div class="container mt-5">
        <h2>Halaman Pembayaran</h2>

        <div class="card">
            <div class="card-body">
                <h5>Detail Pemesanan</h5>
                <p><strong>Nama Paket:</strong> {{ ucfirst($pemesanan->paket->nama) }}</p>
                <p><strong>Harga:</strong>
                    Rp{{ number_format($pemesanan->paket_jenis === 'special' ? $pemesanan->paket->harga_special : $pemesanan->paket->harga_platinum, 0, ',', '.') }}
                </p>
                <p><strong>Tanggal Pemesanan:</strong> {{ $pemesanan->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Status Pembayaran:</strong> {{ ucfirst($pemesanan->status_pembayaran) }}</p>
            </div>
        </div>

        <div class="mt-4">
            <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('pemesanans.index') }}";
                },
                onPending: function(result) {
                    alert("Pembayaran pending!");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                }
            });
        });
    </script>
@endsection

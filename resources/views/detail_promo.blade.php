@extends('layouts.landingpage')

@section('content')
    <div class="container mt-4">
        <div class="card d-flex flex-row" style="height: 100%;">
            <!-- Gambar Promo -->
            <img src="{{ asset('storage/' . $promo->foto) }}" class="card-img-top" alt="{{ $promo->nama }}"
                style="max-width: 400px; object-fit: cover;">

            <div class="card-body d-flex flex-column">
                <h3>{{ $promo->nama }}</h3>

                <!-- Tipe Promo -->
                <p class="text-muted">Tipe: {{ ucfirst($promo->tipe) }}</p>

                <!-- Rating -->
                <div class="d-flex align-items-center">
                    @if ($averageRating)
                        @php
                            $fullStars = floor($averageRating);
                            $halfStar = $averageRating - $fullStars >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                        @endphp

                        @for ($i = 0; $i < $fullStars; $i++)
                            <span class="text-warning">★</span>
                        @endfor

                        @if ($halfStar)
                            <span class="text-warning">★</span>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <span class="text-muted">★</span>
                        @endfor

                        <span class="ms-2">({{ number_format($averageRating, 1) }})</span>
                    @else
                        <span class="text-muted">Belum ada ulasan</span>
                    @endif
                </div>

                <!-- Detail Promo -->
                <div class="mt-4">
                    <p>Harga: <strong>Rp {{ number_format($promo->harga, 0, ',', '.') }}</strong></p>
                    <p>Tenaga Kerja: {{ $promo->tenaga_kerja }}</p>
                    <p>Waktu Kerja: {{ $promo->waktu }} jam</p>
                    <p>Penyimpanan: {{ $promo->penyimpanan }}</p>
                    <p>Deskripsi: {{ $promo->deskripsi }}</p>
                </div>

                <!-- Tombol Pesan Sekarang (Posisi di kanan) -->
                <div class="mt-auto text-end">
                    <a href="{{ route('pemesanans.promo.create', ['id' => $promo->id]) }}" class="btn btn-primary">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

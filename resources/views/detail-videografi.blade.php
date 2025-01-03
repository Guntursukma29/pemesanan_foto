@extends('layouts.landingpage')

@section('content')
    <div class="container mt-4">
        <div class="card d-flex flex-row">
            <img src="{{ asset('storage/' . $videografi->foto) }}" class="card-img-top" alt="{{ $videografi->nama }}"
                style="max-width: 400px;">
            <div class="card-body">
                <h3>{{ $videografi->nama }}</h3>
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
                <div class="mt-3">
                    <button id="special-package" class="btn btn-outline-secondary btn-sm me-2">Special Package</button>
                    <button id="platinum-package" class="btn btn-outline-secondary btn-sm">Platinum Package</button>
                </div>
                <div class="mt-4">
                    <p>Harga: <strong id="harga">Rp
                            {{ number_format($videografi->harga_special, 0, ',', '.') }}</strong>
                    </p>
                    <p>Tenaga Kerja: <span id="tenaga-kerja">{{ $videografi->tenaga_kerja_spesial }}</span></p>
                    <p>Waktu Kerja: <span id="waktu-kerja">{{ $videografi->waktu_spesial }}</span> jam</p>
                    <p>Penyimpanan: <span id="penyimpanan">{{ $videografi->penyimpanan_special }}</span></p>
                    <p>Deskripsi Paket: {{ $videografi->deskripsi }}</p>
                </div>
                <!-- Link Pesan Sekarang -->
                <a href="{{ route('pemesanans.videografi.create', ['videografi' => $videografi->id, 'paket' => 'special']) }}"
                    id="pesan-sekarang" class="btn btn-primary">Pesan Sekarang</a>
            </div>
        </div>
    </div>

    <script>
        let selectedPackage = 'special'; // Default package

        document.getElementById('special-package').addEventListener('click', function() {
            // Update all fields based on the Special Package
            document.getElementById('harga').innerText =
                "Rp {{ number_format($videografi->harga_special, 0, ',', '.') }}";
            document.getElementById('tenaga-kerja').innerText =
                "{{ $videografi->tenaga_kerja_spesial }}";
            document.getElementById('waktu-kerja').innerText =
                "{{ $videografi->waktu_spesial }}";
            document.getElementById('penyimpanan').innerText =
                "{{ $videografi->penyimpanan_special }}";
            selectedPackage = 'special';
            updatePesanSekarangLink();
        });

        document.getElementById('platinum-package').addEventListener('click', function() {
            // Update all fields based on the Platinum Package
            document.getElementById('harga').innerText =
                "Rp {{ number_format($videografi->harga_platinum, 0, ',', '.') }}";
            document.getElementById('tenaga-kerja').innerText =
                "{{ $videografi->tenaga_kerja_platinum }}";
            document.getElementById('waktu-kerja').innerText =
                "{{ $videografi->waktu_platinum }}";
            document.getElementById('penyimpanan').innerText =
                "{{ $videografi->penyimpanan_platinum }}";
            selectedPackage = 'platinum';
            updatePesanSekarangLink();
        });

        function updatePesanSekarangLink() {
            const pesanSekarangLink = document.getElementById('pesan-sekarang');
            pesanSekarangLink.href = "{{ route('pemesanans.videografi.create', ['videografi' => $videografi->id]) }}" +
                "?paket=" +
                selectedPackage;
        }
    </script>
@endsection

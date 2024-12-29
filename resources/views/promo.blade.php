@extends('layouts.landingpage')

@section('content')
    <div class="container mt-4">
        <div class="row">
            @foreach ($data as $promo)
                <div class="col-md-4 mb-4">
                    <div class="card" style="width: 22rem; height: 500px;">
                        <!-- Gambar promo -->
                        <img src="{{ asset('storage/' . $promo->foto) }}" class="card-img-top img-fluid"
                            alt="{{ $promo->nama }}" style="object-fit: cover; width: 100%; height: 300px;">
                        <div class="card-body">
                            <!-- Judul Promo -->
                            <h5 class="card-title">{{ $promo->nama }}</h5>
                            <!-- Harga Promo -->
                            <p class="card-text">Mulai Dari Harga: Rp
                                {{ number_format($promo->harga, 0, ',', '.') }}an</p>
                            <!-- Deskripsi singkat -->
                            <p class="card-text">{{ Str::limit($promo->deskripsi, 100) }}</p>
                            <!-- Tombol Lihat Detail -->
                            <a href="{{ route('promo.detail', $promo->id) }}" class="btn btn-primary">Lihat
                                Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

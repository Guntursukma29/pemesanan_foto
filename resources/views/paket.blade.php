@extends('layouts.landingpage')

@section('paket')
    <section id="features" class="features section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Paket</h2>
            <p>Pilih layanan terbaik kami yang sesuai dengan kebutuhan Anda.</p>
        </div>

        <div class="container">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#features-tab-1">
                            <h4>Fotografi</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#features-tab-2">
                            <h4>Videografi</h4>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content mt-4" data-aos="fade-up" data-aos-delay="200">
                <!-- Fotografi Tab -->
                <div class="tab-pane fade show active" id="features-tab-1">
                    <div class="row">
                        @foreach ($data as $fotografi)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $fotografi->foto) }}" class="card-img-top img-fluid"
                                        alt="{{ $fotografi->nama }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $fotografi->nama }}</h5>
                                        <p class="card-text">Mulai Dari Harga: Rp
                                            {{ number_format($fotografi->harga_special, 0, ',', '.') }}</p>
                                        <p class="card-text">{{ Str::limit($fotografi->deskripsi, 100) }}</p>
                                        <a href="{{ route('fotografi.detail', $fotografi->id) }}"
                                            class="btn btn-primary mt-auto">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Videografi Tab -->
                <div class="tab-pane fade" id="features-tab-2">
                    <div class="row">
                        @foreach ($videografis as $videografi)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="{{ asset('storage/' . $videografi->foto) }}" class="card-img-top img-fluid"
                                        alt="{{ $videografi->nama }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $videografi->nama }}</h5>
                                        <p class="card-text">Mulai Dari Harga: Rp
                                            {{ number_format($videografi->harga_special, 0, ',', '.') }}</p>
                                        <p class="card-text">{{ Str::limit($videografi->deskripsi, 100) }}</p>
                                        <a href="{{ route('videografi.detail', $videografi->id) }}"
                                            class="btn btn-primary mt-auto">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

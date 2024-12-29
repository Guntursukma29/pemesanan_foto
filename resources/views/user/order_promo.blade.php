@extends('layouts.landingpage')

@section('content')
    <div class="container mt-4">
        <form action="{{ route('pemesanans.promo.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">Form Pemesanan Promo</div>
                <div class="card-body">
                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->name }}"
                            readonly>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon"
                            value="{{ $user->customer->nomor_telepon }}" readonly>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>

                    <!-- Jam -->
                    <div class="mb-3">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="time" class="form-control" id="jam" name="jam" required>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        <small>If you choose outdoor, please drop your link address here to specify the location</small>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan"></textarea>
                    </div>

                    <!-- Jenis Pemotretan (Indoor / Outdoor) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tempat" class="form-label">Jenis Pemotretan</label>
                            <select class="form-select" id="tempat" name="tempat" required>
                                <option value="Indoor">Indoor</option>
                                <option value="Outdoor">Outdoor</option>
                            </select>
                        </div>
                    </div>

                    <h5>Paket Dipesan</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Promo</th>
                                <th>Harga</th>
                                <th>Tenaga Kerja</th>
                                <th>Waktu</th>
                                <th>Penyimpanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- Menampilkan data dari tabel promo -->
                                <td>{{ $promo->nama }}</td>
                                <td>Rp {{ number_format($promo->harga, 0, ',', '.') }}</td>
                                <td>{{ $promo->tenaga_kerja }}</td>
                                <td>{{ $promo->waktu }}</td>
                                <td>{{ $promo->penyimpanan }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Hidden field for package ID -->
                    <input type="hidden" name="id_paket" value="{{ $promo->id }}">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Buat Pesanan</button>
                        <button type="button" class="btn btn-secondary">Masukkan Keranjang</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

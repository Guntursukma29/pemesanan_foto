@extends('layouts.landingpage')

@section('content')
    <div class="container mt-4">
        <form action="{{ route('pemesanans.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">Form Pemesanan</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->name }}"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon"
                            value="{{ $user->customer->nomor_telepon }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="time" class="form-control" id="jam" name="jam" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        <small>If you choose outdoor, please drop your link address here to specify the location</small>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan"></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="paket_jenis" class="form-label">Jenis Paket</label>
                            <select class="form-select" id="paket_jenis" name="paket_jenis" required>
                                <option value="special">Special</option>
                                <option value="platinum">Platinum</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tempat" class="form-label">Jenis Pemotretan</label>
                            <select class="form-select" id="tempat" name="tempat" required>
                                <option value="Indoor">Indoor</option>
                                <option value="Outdoor">Outdoor</option>
                            </select>
                        </div>
                    </div>
                    <h5>Detail Paket</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Tenaga Kerja</th>
                                <th>Waktu</th>
                                <th>Penyimpanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $fotografi->nama }}</td>
                                <td id="harga">Rp {{ number_format($fotografi->harga_special, 0, ',', '.') }}</td>
                                <td id="tenaga_kerja">{{ $fotografi->tenaga_kerja_spesial }}</td>
                                <td id="waktu">{{ $fotografi->waktu_spesial }}</td>
                                <td id="penyimpanan">{{ $fotografi->penyimpanan_special }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="id_paket" value="{{ $fotografi->id }}">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Buat Pesanan</button>
                        <button type="button" class="btn btn-secondary">Masukkan Keranjang</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const paketSelect = document.getElementById('paket_jenis');
        const harga = document.getElementById('harga');
        const tenagaKerja = document.getElementById('tenaga_kerja');
        const waktu = document.getElementById('waktu');
        const penyimpanan = document.getElementById('penyimpanan');

        const paketData = {
            special: {
                harga: 'Rp {{ number_format($fotografi->harga_special, 0, ',', '.') }}',
                tenagaKerja: '{{ $fotografi->tenaga_kerja_spesial }}',
                waktu: '{{ $fotografi->waktu_spesial }}',
                penyimpanan: '{{ $fotografi->penyimpanan_special }}'
            },
            platinum: {
                harga: 'Rp {{ number_format($fotografi->harga_platinum, 0, ',', '.') }}',
                tenagaKerja: '{{ $fotografi->tenaga_kerja_platinum }}',
                waktu: '{{ $fotografi->waktu_platinum }}',
                penyimpanan: '{{ $fotografi->penyimpanan_platinum }}'
            }
        };

        paketSelect.addEventListener('change', function() {
            const selectedPaket = paketSelect.value;
            harga.textContent = paketData[selectedPaket].harga;
            tenagaKerja.textContent = paketData[selectedPaket].tenagaKerja;
            waktu.textContent = paketData[selectedPaket].waktu;
            penyimpanan.textContent = paketData[selectedPaket].penyimpanan;
        });
    </script>
@endsection

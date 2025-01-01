@extends('layouts.landingpage')

@section('content')
    <div class="container mt-4">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Riwayat Pemesanan</h3>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($pemesanans->isEmpty())
                            <p>Anda belum melakukan pemesanan apapun.</p>
                        @else
                            <table class="table" id="user">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Paket</th>
                                        <th>Harga</th>
                                        <th>Status Pemesanan</th>
                                        <th>Status Pembayaran</th>
                                        <th>Tanggal Pemesanan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemesanans as $key => $pemesanan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ ucfirst($pemesanan->paket->nama) }}</td>

                                            <td>
                                                Rp
                                                {{ number_format($pemesanan->paket_jenis === 'special' ? $pemesanan->paket->harga_special : $pemesanan->paket->harga_platinum, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if ($pemesanan->status_pemesanan === 'pending')
                                                    <span class="badge bg-warning">Menunggu Pembayaran</span>
                                                @elseif($pemesanan->status_pemesanan === 'proses')
                                                    <span class="badge bg-info">Menunggu Pelaksanaan</span>
                                                @elseif ($pemesanan->status_pemesanan === 'dokumentasi')
                                                    <span class="badge bg-secondary">Menunggu Hasil Dokumentasi</span>
                                                @elseif ($pemesanan->status_pemesanan === 'batal')
                                                    <span class="badge bg-info">Menunggu Hasil Edit</span>
                                                @else
                                                    <span class="badge bg-success">selesai</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($pemesanan->status_pembayaran === 'belum bayar')
                                                    <span class="badge bg-warning">Belum Bayar</span>
                                                @else
                                                    <span class="badge bg-success">PAID</span>
                                                @endif
                                            </td>
                                            <td>{{ $pemesanan->created_at->format('d-m-Y H:i') }}</td>
                                            <td class="text-center">

                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal-{{ $pemesanan->id }}">
                                                    Lihat Detail
                                                </button>
                                                @if ($pemesanan->status_pembayaran === 'belum bayar')
                                                    <!-- Button Ubah Jadwal -->
                                                    <a href="{{ route('pemesanans.bayar', $pemesanan->id) }}"
                                                        class="btn btn-success btn-sm"><i
                                                            class="bi bi-currency-dollar">Bayar</i></a>
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#ubahJadwalModal-{{ $pemesanan->id }}">
                                                        Ubah Jadwal
                                                    </button>


                                                    <!-- Modal Ubah Jadwal -->
                                                    <div class="modal fade" id="ubahJadwalModal-{{ $pemesanan->id }}"
                                                        tabindex="-1" aria-labelledby="ubahJadwalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="ubahJadwalLabel">Ubah Jadwal
                                                                        Pemesanan</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('pemesanans.ubahJadwal', $pemesanan->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="tanggal"
                                                                                class="form-label">Tanggal</label>
                                                                            <input type="date" class="form-control"
                                                                                name="tanggal"
                                                                                value="{{ old('tanggal', $pemesanan->tanggal) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="jam"
                                                                                class="form-label">Jam</label>
                                                                            <input type="time" class="form-control"
                                                                                name="jam"
                                                                                value="{{ old('jam', $pemesanan->jam) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="alamat"
                                                                                class="form-label">Alamat</label>
                                                                            <input type="text" class="form-control"
                                                                                name="alamat"
                                                                                value="{{ old('alamat', $pemesanan->alamat) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="tempat"
                                                                                class="form-label">Tempat</label>
                                                                            <select class="form-control" name="tempat"
                                                                                required>
                                                                                <option value="Indoor"
                                                                                    {{ old('tempat', $pemesanan->tempat) == 'Indoor' ? 'selected' : '' }}>
                                                                                    Indoor</option>
                                                                                <option value="Outdoor"
                                                                                    {{ old('tempat', $pemesanan->tempat) == 'Outdoor' ? 'selected' : '' }}>
                                                                                    Outdoor</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Button Hapus -->
                                                    <form action="{{ route('pemesanans.destroy', $pemesanan->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">Hapus</button>
                                                    </form>
                                                @else
                                                    @if ($pemesanan->status_pemesanan === 'selesai')
                                                        @if (!$pemesanan->ulasan()->exists())
                                                            <!-- Cek apakah ulasan sudah ada -->
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ulasModal-{{ $pemesanan->id }}">
                                                                Berikan Ulasan
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if (!empty($pemesanan->link_dokumentasi))
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#dokumentasiModal-{{ $pemesanan->id }}">
                                                        Dokumentasi
                                                    </button>
                                                @endif
                                            </td>
                                            <div class="modal fade" id="detailModal-{{ $pemesanan->id }}" tabindex="-1"
                                                aria-labelledby="detailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailModalLabel">Detail
                                                                Pemesanan Fotografi</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Nama Promo:</strong>
                                                                {{ $pemesanan->paket->nama }}</p>
                                                            <p><strong>Harga:</strong>
                                                                Rp
                                                                {{ number_format($pemesanan->paket_jenis === 'special' ? $pemesanan->paket->harga_special : $pemesanan->paket->harga_platinum, 0, ',', '.') }}
                                                            </p>
                                                            <p><strong>Status Pemesanan:</strong>
                                                                @if ($pemesanan->status_pemesanan === 'pending')
                                                                    Menunggu Pembayaran
                                                                @elseif ($pemesanan->status_pemesanan === 'proses')
                                                                    Menunggu Pelaksanaan
                                                                @else
                                                                    Selesai
                                                                @endif
                                                            </p>
                                                            <p><strong>Status Pembayaran:</strong>
                                                                {{ $pemesanan->status_pembayaran === 'belum bayar' ? 'Belum Bayar' : 'PAID' }}
                                                            </p>
                                                            <p><strong>Tanggal Pemesanan:</strong>
                                                                {{ $pemesanan->created_at->format('d-m-Y H:i') }}
                                                            </p>
                                                            <p><strong>Alamat:</strong> {{ $pemesanan->alamat }}
                                                            </p>
                                                            <p><strong>Tempat:</strong> {{ $pemesanan->tempat }}
                                                            </p>
                                                            <p><strong>Catatan:</strong>
                                                                {{ $pemesanan->catatan ?? 'Tidak ada catatan' }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="dokumentasiModal-{{ $pemesanan->id }}"
                                                tabindex="-1" aria-labelledby="dokumentasiModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="dokumentasiModalLabel">Link
                                                                Dokumentasi dan Input Kode Foto</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Link Dokumentasi -->
                                                            <p>Berikut adalah link dokumentasi untuk pemesanan ini:</p>
                                                            <a href="{{ $pemesanan->link_dokumentasi }}"
                                                                target="_blank">{{ $pemesanan->link_dokumentasi }}</a>

                                                            <hr>

                                                            <!-- Check if link_foto is set -->
                                                            @if ($pemesanan->link_foto)
                                                                <!-- If link_foto is available, show the link -->
                                                                <div class="mb-3">
                                                                    <label for="link_foto" class="form-label">Link
                                                                        Foto</label>
                                                                    <a href="{{ $pemesanan->link_foto }}"
                                                                        target="_blank">{{ $pemesanan->link_foto }}</a>
                                                                </div>
                                                            @else
                                                                <!-- If link_foto is not set, show the form to input code_foto -->
                                                                <form
                                                                    action="{{ route('pemesanans.kode_foto', $pemesanan->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="code_foto" class="form-label">Masukkan
                                                                            Kode Foto edit</label>
                                                                        <input type="text" name="code_foto"
                                                                            id="code_foto" class="form-control"
                                                                            placeholder="Masukkan kode foto" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Simpan
                                                                        Kode Foto</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </tr>
                                        <!-- Modal Ulasan -->
                                        <div class="modal fade" id="ulasModal-{{ $pemesanan->id }}" tabindex="-1"
                                            aria-labelledby="ulasModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ulasModalLabel">Berikan Ulasan untuk
                                                            Pemesanan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('ulasan.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="pemesanan_id"
                                                            value="{{ $pemesanan->id }}">
                                                        <input type="hidden" name="bintang"
                                                            id="rating-value-{{ $pemesanan->id }}" required>
                                                        <div class="modal-body">
                                                            <!-- Rating -->
                                                            <div class="mb-3">
                                                                <label for="bintang" class="form-label">Rating</label>
                                                                <div class="rating" id="rating-{{ $pemesanan->id }}">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="bi bi-star star"
                                                                            data-value="{{ $i }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>

                                                            <!-- Foto -->
                                                            <div class="mb-3">
                                                                <label for="foto" class="form-label">Foto
                                                                    (opsional)
                                                                </label>
                                                                <input type="file" class="form-control" name="foto"
                                                                    accept="image/*">
                                                            </div>

                                                            <!-- Catatan -->
                                                            <div class="mb-3">
                                                                <label for="catatan" class="form-label">Catatan</label>
                                                                <textarea class="form-control" name="catatan" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Kirim
                                                                Ulasan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <style>
                                            .rating {
                                                display: flex;
                                                gap: 5px;
                                            }

                                            .star {
                                                font-size: 32px;
                                                color: gray;
                                                cursor: pointer;
                                                transition: color 0.3s;
                                            }

                                            .star.selected {
                                                color: gold;
                                            }

                                            .star:hover,
                                            .star:hover~.star {
                                                color: gold;
                                            }
                                        </style>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih semua elemen rating
            document.querySelectorAll('.rating').forEach(rating => {
                const stars = rating.querySelectorAll('.star');
                const ratingId = rating.id.split('-')[1];

                // Tambahkan event listener pada setiap bintang
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');

                        // Set nilai rating ke input hidden
                        document.getElementById(`rating-value-${ratingId}`).value = value;

                        // Update warna bintang
                        stars.forEach(s => {
                            s.classList.remove('selected');
                            if (s.getAttribute('data-value') <= value) {
                                s.classList.add('selected');
                            }
                        });
                    });
                });
            });
        });
    </script>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih semua elemen rating
            document.querySelectorAll('.rating').forEach(rating => {
                const stars = rating.querySelectorAll('.star');
                const ratingId = rating.id.split('-')[1];

                // Tambahkan event listener pada setiap bintang
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');

                        // Set nilai rating ke input hidden
                        document.getElementById(`rating-value-${ratingId}`).value = value;

                        // Update warna bintang
                        stars.forEach(s => {
                            s.classList.remove('selected');
                            if (s.getAttribute('data-value') <= value) {
                                s.classList.add('selected');
                            }
                        });
                    });
                });
            });
        });
    </script>
@endsection

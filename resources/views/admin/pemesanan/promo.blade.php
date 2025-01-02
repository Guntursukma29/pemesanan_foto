@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Daftar Pemesanan Promo</h3>
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>Nama Promo</th>
                                    <th>Tanggal</th>
                                    <th>Status Pemesanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Fotografer</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemesanans as $index => $pemesanan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pemesanan->order_id }}</td>
                                        <td>{{ $pemesanan->user->name }}</td>
                                        <td>{{ $pemesanan->promo->nama }}</td>
                                        <td>{{ $pemesanan->tanggal }}</td>
                                        <td>
                                            @if ($pemesanan->status_pemesanan === 'pending')
                                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                                            @elseif($pemesanan->status_pemesanan === 'proses')
                                            <span class="badge bg-info">Menunggu Pelaksanaan</span>
                                            @elseif ($pemesanan->status_pemesanan === 'dokumentasi')
                                            <span class="badge bg-secondary">Menunggu Hasil Dokumentasi</span>
                                            @elseif ($pemesanan->status_pemesanan === 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                            @else
                                            <span class="badge bg-info">Menunggu Hasil Edit</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                            class="badge {{ $pemesanan->status_pembayaran === 'belum bayar' ? 'bg-warning' : 'bg-success' }}">
                                            {{ ucfirst($pemesanan->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td>{{ $pemesanan->fotografer->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($pemesanan->promo->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <!-- Tombol untuk membuka modal detail -->
                                            <button type="button" class="btn btn-rounded btn-primary btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#detailModal{{ $pemesanan->id }}">
                                                Detail
                                            </button>
                                            <form method="POST" action="{{ route('reminder.promo', $pemesanan->id) }}"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Reminder</button>
                                            </form>
                                            <!-- Tombol untuk membuka modal input fotografer -->
                                            @if ($pemesanan->fotografer)
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#assignFotograferModal{{ $pemesanan->id }}">
                                                    Ubah Fotografer
                                                </button>
                                                <form method="POST" action="{{ route('reminder.promo', $pemesanan->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-info">Kirim
                                                        Reminder</button>
                                                </form>
                                            @elseif ($pemesanan->status_pemesanan === 'proses' && $pemesanan->status_pembayaran === 'dibayar')
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#assignFotograferModal{{ $pemesanan->id }}">
                                                    Input Fotografer
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="detailModal{{ $pemesanan->id }}" tabindex="-1"
                                        aria-labelledby="detailModalLabel{{ $pemesanan->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $pemesanan->id }}">
                                                        Detail Pemesanan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Order ID:</strong> {{ $pemesanan->order_id }}</p>
                                                    <p><strong>Nama:</strong> {{ $pemesanan->user->name }}</p>
                                                    <p><strong>Nama Paket:</strong> {{ $pemesanan->promo->nama }}</p>
                                                    <p><strong>Harga:</strong> Rp
                                                        {{ number_format($pemesanan->promo->harga, 0, ',', '.') }}
                                                    </p>
                                                    <p><strong>Tanggal:</strong> {{ $pemesanan->tanggal }}</p>
                                                    <p><strong>Status Pemesanan:</strong>
                                                        @if ($pemesanan->status_pemesanan === 'pending')
                                                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                                                        @elseif($pemesanan->status_pemesanan === 'proses')
                                                            <span class="badge bg-info">Menunggu Pelaksanaan</span>
                                                        @elseif ($pemesanan->status_pemesanan === 'dokumentasi')
                                                            <span class="badge bg-secondary">Menunggu Hasil
                                                                Dokumentasi</span>
                                                        @elseif ($pemesanan->status_pemesanan === 'selesai')
                                                            <span class="badge bg-success">Selesai</span>
                                                        @else
                                                            <span class="badge bg-info">Menunggu Hasil Edit</span>
                                                        @endif
                                                    </p>
                                                    <p><strong>Status Pembayaran:</strong>
                                                        @if ($pemesanan->status_pembayaran === 'belum bayar')
                                                            <span class="badge bg-warning">Belum Bayar</span>
                                                        @else
                                                            <span class="badge bg-success">PAID</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Input Fotografer -->
                                    <div class="modal fade" id="assignFotograferModal{{ $pemesanan->id }}" tabindex="-1"
                                        aria-labelledby="assignFotograferModalLabel{{ $pemesanan->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST"
                                                action="{{ route('admin.pemesanan.promo.assign', $pemesanan->id) }}">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="assignFotograferModalLabel{{ $pemesanan->id }}">
                                                            {{ $pemesanan->fotografer ? 'Ubah Fotografer' : 'Input Fotografer' }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="fotografer">Pilih Fotografer</label>
                                                            <select name="id_fotografer" id="fotografer"
                                                                class="form-control">
                                                                @foreach ($fotografer as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">Total Harga Spesial</td>
                                    <td colspan="2">Rp {{ number_format($totalHargaSpesial, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="8">Total Harga Platinum</td>
                                    <td colspan="2">Rp {{ number_format($totalHargaPlatinum, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="8">Total Keseluruhan</td>
                                    <td colspan="2">Rp {{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

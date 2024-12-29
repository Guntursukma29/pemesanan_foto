@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Daftar Pemesanan Fotografi</h3>
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Status Pemesanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Fotografer</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemesanans as $key => $pemesanan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pemesanan->order_id }}</td>
                                        <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                        <td>{{ $pemesanan->tanggal }}</td>
                                        <td>Rp
                                            {{ number_format($pemesanan->paket_jenis === 'special' ? $pemesanan->paket->harga_special : $pemesanan->paket->harga_platinum, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
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
                                            @if ($pemesanan->status_pembayaran === 'belum bayar')
                                                <span class="badge bg-warning">Belum Bayar</span>
                                            @else
                                                <span class="badge bg-success">PAID</span>
                                            @endif
                                        </td>
                                        <td>{{ $pemesanan->fotografer->name ?? '-' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $pemesanan->id }}">
                                                Detail
                                            </button>

                                            @if ($pemesanan->status_pemesanan !== 'selesai')
                                                @if ($pemesanan->fotografer)
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#inputFotograferModal{{ $pemesanan->id }}">
                                                        Ubah Fotografer
                                                    </button>
                                                @elseif ($pemesanan->status_pemesanan === 'proses' && $pemesanan->status_pembayaran === 'dibayar')
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#inputFotograferModal{{ $pemesanan->id }}">
                                                        Input Fotografer
                                                    </button>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
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
                                                    <p><strong>Nama:</strong> {{ $pemesanan->user->name ?? '-' }}</p>
                                                    <p><strong>Email:</strong> {{ $pemesanan->user->email ?? '-' }}</p>
                                                    <p><strong>Harga:</strong>
                                                        Rp{{ number_format($pemesanan->paket->harga_special ?: $pemesanan->paket->harga_platinum, 0, ',', '.') }}
                                                    </p>
                                                    <p><strong>Tanggal:</strong> {{ $pemesanan->tanggal }}</p>
                                                    <p><strong>Jam:</strong> {{ $pemesanan->jam }}</p>
                                                    <p><strong>Alamat:</strong> {{ $pemesanan->alamat }}</p>
                                                    <p><strong>Tempat:</strong> {{ $pemesanan->tempat }}</p>
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
                                    <div class="modal fade" id="inputFotograferModal{{ $pemesanan->id }}" tabindex="-1"
                                        aria-labelledby="inputFotograferModalLabel{{ $pemesanan->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('fotografer.assign', $pemesanan->id) }}">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="inputFotograferModalLabel{{ $pemesanan->id }}">
                                                            Input Fotografer
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

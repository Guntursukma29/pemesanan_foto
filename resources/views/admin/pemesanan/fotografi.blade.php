@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('admin.pemesanan.index') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="bulan">Bulan:</label>
                    <select name="bulan" id="bulan" class="form-control">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tahun">Tahun:</label>
                    <select name="tahun" id="tahun" class="form-control">
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class=" col-md-4 text-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
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
                                    <th>Nama Paket</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Fotografer</th>
                                    <th>Status Pemesanan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemesanans as $key => $pemesanan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pemesanan->order_id }}</td>
                                        <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                        <td>{{ $pemesanan->paket->nama }}</td>
                                        <td>{{ $pemesanan->tanggal }}</td>
                                        <td>{{ $pemesanan->jam }}</td>
                                        <td>{{ $pemesanan->fotografer->name ?? '-' }}</td>
                                        <td class="text-center">
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
                                        <td>Rp
                                            {{ number_format($pemesanan->paket_jenis === 'special' ? $pemesanan->paket->harga_special : $pemesanan->paket->harga_platinum, 0, ',', '.') }}
                                        </td>
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
                                                    <form method="POST"
                                                        action="{{ route('reminder.pemesanan', $pemesanan->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info">Kirim
                                                            Reminder</button>
                                                    </form>
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
                                                        @elseif ($pemesanan->status_pemesanan === 'batal')
                                                            <span class="badge bg-info">Menunggu Hasil Edit</span>
                                                        @else
                                                            <span class="badge bg-success">selesai</span>
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
                            <tfoot>
                                <tr>
                                    <td colspan="9">Total Harga Pemesanan Paket Spesial</td>
                                    <td colspan="2">Rp {{ number_format($totalHargaSpesial, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="9">Total Harga Pemesanan Paket Platinum</td>
                                    <td colspan="2">Rp {{ number_format($totalHargaPlatinum, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="9">Total Pendapatan</td>
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

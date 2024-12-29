@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Daftar Pemesanan Fotografi</h3>
                        <table class="table text-center" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status Pemesanan</th>
                                    <th>Link Dokumentasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemesanansFotografi as $index => $pemesanan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pemesanan->order_id }}</td>
                                        <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                        <td>{{ $pemesanan->tanggal }}</td>
                                        <td>{{ $pemesanan->jam }}</td>
                                        <td class="text-center">
                                            @if ($pemesanan->status_pemesanan === 'pending')
                                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                                            @elseif($pemesanan->status_pemesanan === 'proses')
                                                <span class="badge bg-info">Menunggu Pelaksanaan</span>
                                            @elseif ($pemesanan->status_pemesanan === 'dokumentasi')
                                                <span class="badge bg-primary">Menunggu dokumentasi</span>
                                            @else
                                                <span class="badge bg-secondary">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pemesanan->link_dokumentasi)
                                                <a href="{{ $pemesanan->link_dokumentasi }}" target="_blank">Lihat
                                                    Dokumentasi</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pemesanan->status_pemesanan === 'proses')
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-rounded btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#linkDokumentasiModal{{ $pemesanan->id }}">
                                                    Link Dokumentasi
                                                </button>
                                            @endif

                                            @if ($pemesanan->code_foto)
                                                <!-- Button untuk Masukkan Link Foto -->
                                                <button type="button" class="btn btn-sm btn-rounded btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#linkFotoModal{{ $pemesanan->id }}">
                                                    Masukkan Link Foto
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Link Dokumentasi -->
                                    <div class="modal fade" id="linkDokumentasiModal{{ $pemesanan->id }}" tabindex="-1"
                                        aria-labelledby="linkDokumentasiModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="linkDokumentasiModalLabel">Input Link
                                                        Dokumentasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form
                                                    action="{{ route('pemesanan.updateLinkDokumentasi', ['id' => $pemesanan->id, 'tipe' => 'fotografi']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="link_dokumentasi" class="form-label">Link
                                                                Dokumentasi</label>
                                                            <input type="url" name="link_dokumentasi"
                                                                class="form-control" placeholder="Masukkan Link Dokumentasi"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Link Foto -->
                                    <div class="modal fade" id="linkFotoModal{{ $pemesanan->id }}" tabindex="-1"
                                        aria-labelledby="linkFotoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="linkFotoModalLabel">Input Link Foto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form
                                                    action="{{ route('pemesanan.inputCodeFoto', ['id' => $pemesanan->id, 'tipe' => 'fotografi']) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="link_foto" class="form-label">Link Foto</label>
                                                            <input type="url" name="link_foto" class="form-control"
                                                                placeholder="Masukkan Link Foto" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
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
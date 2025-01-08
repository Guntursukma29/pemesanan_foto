@extends('layouts.dashboard')

@section('content')
    <div class="row mb-3">
        <div class="col">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                    <i class="mdi mdi-home"></i>
                </span> {{ $title }}
            </h3>
        </div>
        <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-rounded btn-info" data-bs-toggle="modal" data-bs-target="#createModal">
                Tambah Paket
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table " id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Gambar</th>
                                    <th>Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Gambar Paket"
                                                    width="400">
                                            @else
                                                Tidak ada gambar
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($item->harga_special, 2) }}</td>
                                        <td class="text-center">
                                            <!-- Tombol Detail -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $item->id }}">
                                                Detail
                                            </button>

                                            <!-- Tombol Update -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateModal{{ $item->id }}">
                                                Update
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form id="deleteForm{{ $item->id }}"
                                                action="{{ route('fotografi.destroy', $item->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" onclick="confirmDelete({{ $item->id }})"
                                                class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">
                                                        Detail Paket Fotografi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama Paket:</strong> {{ $item->nama }}</p>
                                                    <p><strong>Harga Special:</strong> Rp
                                                        {{ number_format($item->harga_special, 0, ',', '.') }}</p>
                                                    <p><strong>Harga Platinum:</strong> Rp
                                                        {{ number_format($item->harga_platinum, 0, ',', '.') }}</p>
                                                    <p><strong>Tenaga Kerja Special:</strong>
                                                        {{ $item->tenaga_kerja_spesial }}</p>
                                                    <p><strong>Tenaga Kerja Platinum:</strong>
                                                        {{ $item->tenaga_kerja_platinum }}</p>
                                                    <p><strong>Waktu Special:</strong> {{ $item->waktu_spesial }} jam</p>
                                                    <p><strong>Waktu Platinum:</strong> {{ $item->waktu_platinum }} jam</p>
                                                    <p><strong>Penyimpanan Special:</strong>
                                                        {{ $item->penyimpanan_special }}</p>
                                                    <p><strong>Penyimpanan Platinum:</strong>
                                                        {{ $item->penyimpanan_platinum }}</p>
                                                    <p><strong>Deskripsi:</strong>
                                                        {{ $item->deskripsi_spesial ?? 'Tidak ada deskripsi' }}</p>
                                                    <p><strong>Gambar:</strong></p>
                                                    <p><strong>Deskripsi:</strong>
                                                        {{ $item->deskripsi_platinum ?? 'Tidak ada deskripsi' }}</p>
                                                    <p><strong>Gambar:</strong></p>
                                                    @if ($item->foto)
                                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Gambar Paket"
                                                            class="img-fluid">
                                                    @else
                                                        <p>Tidak ada gambar</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Update -->
                                    <div class="modal fade" id="updateModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="updateModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateModalLabel{{ $item->id }}">
                                                        Update Paket Fotografi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('fotografi.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="nama{{ $item->id }}" class="form-label">Nama
                                                                Paket</label>
                                                            <input type="text" name="nama" class="form-control"
                                                                id="nama{{ $item->id }}" value="{{ $item->nama }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="foto{{ $item->id }}"
                                                                class="form-label">Gambar</label>
                                                            <input type="file" name="foto" class="form-control"
                                                                id="foto{{ $item->id }}">
                                                            @if ($item->foto)
                                                                <p class="mt-2">Gambar saat ini: <img
                                                                        src="{{ asset('storage/' . $item->foto) }}"
                                                                        alt="Gambar Paket" width="50"></p>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="harga_special{{ $item->id }}"
                                                                class="form-label">Harga Special</label>
                                                            <input type="text" name="harga_special"
                                                                class="form-control"
                                                                id="harga_special{{ $item->id }}"
                                                                value="{{ $item->harga_special }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="harga_platinum{{ $item->id }}"
                                                                class="form-label">Harga Platinum</label>
                                                            <input type="text" name="harga_platinum"
                                                                class="form-control"
                                                                id="harga_platinum{{ $item->id }}"
                                                                value="{{ $item->harga_platinum }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tenaga_kerja_spesial{{ $item->id }}"
                                                                class="form-label">Tenaga Kerja Special</label>
                                                            <input type="text" name="tenaga_kerja_spesial"
                                                                class="form-control"
                                                                id="tenaga_kerja_spesial{{ $item->id }}"
                                                                value="{{ $item->tenaga_kerja_spesial }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tenaga_kerja_platinum{{ $item->id }}"
                                                                class="form-label">Tenaga Kerja Platinum</label>
                                                            <input type="text" name="tenaga_kerja_platinum"
                                                                class="form-control"
                                                                id="tenaga_kerja_platinum{{ $item->id }}"
                                                                value="{{ $item->tenaga_kerja_platinum }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="waktu_spesial{{ $item->id }}"
                                                                class="form-label">Waktu Special (Jam)</label>
                                                            <input type="text" name="waktu_spesial"
                                                                class="form-control"
                                                                id="waktu_spesial{{ $item->id }}"
                                                                value="{{ $item->waktu_spesial }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="waktu_platinum{{ $item->id }}"
                                                                class="form-label">Waktu Platinum (Jam)</label>
                                                            <input type="text" name="waktu_platinum"
                                                                class="form-control"
                                                                id="waktu_platinum{{ $item->id }}"
                                                                value="{{ $item->waktu_platinum }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penyimpanan_special{{ $item->id }}"
                                                                class="form-label">Penyimpanan Special</label>
                                                            <input type="text" name="penyimpanan_special"
                                                                class="form-control"
                                                                id="penyimpanan_special{{ $item->id }}"
                                                                value="{{ $item->penyimpanan_special }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="penyimpanan_platinum{{ $item->id }}"
                                                                class="form-label">Penyimpanan Platinum</label>
                                                            <input type="text" name="penyimpanan_platinum"
                                                                class="form-control"
                                                                id="penyimpanan_platinum{{ $item->id }}"
                                                                value="{{ $item->penyimpanan_platinum }}" >
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="deskripsi_spesial{{ $item->id }}"
                                                                class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi_spesial" id="deskripsi_spesial{{ $item->id }}" class="form-control" >{{ $item->deskripsi_spesial }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="deskripsi_platinum{{ $item->id }}"
                                                                class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi_platinum" id="deskripsi_platinum{{ $item->id }}" class="form-control" >{{ $item->deskripsi_platinum }}</textarea>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data Fotografi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('fotografi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Paket</label>
                            <input type="text" name="nama" class="form-control" id="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" id="foto">
                        </div>
                        <div class="mb-3">
                            <label for="harga_special" class="form-label">Harga Special</label>
                            <input type="number" name="harga_special" class="form-control" id="harga_special" >
                        </div>
                        <div class="mb-3">
                            <label for="harga_platinum" class="form-label">Harga Platinum</label>
                            <input type="number" name="harga_platinum" class="form-control" id="harga_platinum"
                                >
                        </div>
                        <div class="mb-3">
                            <label for="tenaga_kerja_spesial" class="form-label">Tenaga Kerja Special</label>
                            <input type="text" name="tenaga_kerja_spesial" class="form-control"
                                id="tenaga_kerja_spesial" >
                        </div>
                        <div class="mb-3">
                            <label for="tenaga_kerja_platinum" class="form-label">Tenaga Kerja Platinum</label>
                            <input type="text" name="tenaga_kerja_platinum" class="form-control"
                                id="tenaga_kerja_platinum" >
                        </div>
                        <div class="mb-3">
                            <label for="waktu_spesial" class="form-label">Waktu Special (Jam)</label>
                            <input type="text" name="waktu_spesial" class="form-control" id="waktu_spesial" >
                        </div>
                        <div class="mb-3">
                            <label for="waktu_platinum" class="form-label">Waktu Platinum (Jam)</label>
                            <input type="text" name="waktu_platinum" class="form-control" id="waktu_platinum"
                                >
                        </div>
                        <div class="mb-3">
                            <label for="penyimpanan_special" class="form-label">Penyimpanan Special</label>
                            <input type="text" name="penyimpanan_special" class="form-control"
                                id="penyimpanan_special" >
                        </div>
                        <div class="mb-3">
                            <label for="penyimpanan_platinum" class="form-label">Penyimpanan Platinum</label>
                            <input type="text" name="penyimpanan_platinum" class="form-control"
                                id="penyimpanan_platinum" >
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_spesial" class="form-label">Deskripsi spesial</label>
                            <textarea name="deskripsi_spesial" id="deskripsi_spesial" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_platinum" class="form-label">Deskripsi platinum</label>
                            <textarea name="deskripsi_platinum" id="deskripsi_platinum" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

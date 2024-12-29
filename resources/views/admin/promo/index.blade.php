@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <h1 class="text-center">Manajemen Promo</h1>

        <!-- Tambah Promo -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPromoModal">
            Tambah Promo
        </button>
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Promo</h3>
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Foto</th>
                                    <th>Tipe</th>
                                    <th>Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promo as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td><img src="{{ asset('storage/' . $p->foto) }}" width="50" alt="Foto">
                                        </td>
                                        <td>{{ $p->tipe }}</td>
                                        <td>Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPromoModal{{ $p->id }}">Edit</button>
                                            <form id="deleteForm{{ $p->id }}"
                                                action="{{ route('promo.destroy', $p->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" onclick="confirmDelete({{ $p->id }})"
                                                class="btn
                                                btn-danger btn-sm">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Edit Promo Modal -->
                                    <div class="modal fade" id="editPromoModal{{ $p->id }}" tabindex="-1"
                                        aria-labelledby="editPromoModalLabel{{ $p->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('promo.update', $p->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Promo</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @include('admin.promo.form', ['promo' => $p])
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Tambah Promo Modal -->
                        <div class="modal fade" id="addPromoModal" tabindex="-1" aria-labelledby="addPromoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Promo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @include('admin.promo.form', ['promo' => null])
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

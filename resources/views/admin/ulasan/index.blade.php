@extends('layouts.dashboard')

@section('content')
    <div class="container mt-4">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Ulasan</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Nama Paket</th>
                                    <th>Rating</th>
                                    <th>Foto</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ulasan as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            @if ($item->pemesanan_id)
                                                {{ optional($item->pemesanan->fotografi)->nama ?? 'Nama tidak ditemukan' }}
                                            @elseif ($item->pemesanan_videografi_id)
                                                {{ optional($item->pemesananVideografi->videografi)->nama ?? 'Nama tidak ditemukan' }}
                                            @elseif ($item->pemesanan_promo_id)
                                                {{ optional($item->pemesananPromo->promo)->nama ?? 'Nama tidak ditemukan' }}
                                            @else
                                                Tidak ada paket
                                            @endif
                                        </td>

                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $item->bintang)
                                                    <span class="fa fa-star" style="color: gold;"></span>
                                                    <!-- Bintang penuh -->
                                                @else
                                                    <span class="fa fa-star-o" style="color: gold;"></span>
                                                    <!-- Bintang kosong -->
                                                @endif
                                            @endfor
                                        </td>
                                        <td>
                                            @if ($item->foto)
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Ulasan"
                                                    class="img-thumbnail" width="100">
                                            @else
                                                Tidak ada foto
                                            @endif
                                        </td>
                                        <td>{{ $item->catatan }}</td>
                                        <td>
                                            @if ($item->status === 'tampilkan')
                                                <form id="hideForm{{ $item->id }}"
                                                    action="{{ route('ulasan.sembunyikan', $item->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>

                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="confirmHide({{ $item->id }})">
                                                    Sembunyikan
                                                </button>
                                            @else
                                                <span class="badge badge-secondary">Tersembunyi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

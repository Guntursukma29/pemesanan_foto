@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h3>Dokumentasi Fotografi</h3>
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>Fotografer</th>
                                    <th>Hasil Dokumentasi</th>
                                    <th>Foto Yang Di edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemesanans as $key => $pemesanan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $pemesanan->order_id }}</td>
                                        <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                        <td>{{ $pemesanan->fotografer->name ?? '-' }}</td>
                                        <td>
                                            @if ($pemesanan->link_dokumentasi)
                                                <a href="{{ $pemesanan->link_dokumentasi }}" target="_blank">Lihat
                                                    Dokumentasi</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pemesanan->link_foto)
                                                <a href="{{ $pemesanan->link_foto }}" target="_blank">Lihat
                                                    Dokumentasi</a>
                                            @else
                                                -
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

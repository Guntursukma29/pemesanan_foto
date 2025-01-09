@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">
        <div class="row purchace-popup">
            <div class="col-12">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-home"></i>
                    </span> Dashboard
                </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-warning text-white">
                    <div class="card-body">
                        <h4 class="font-weight-normal mb-3">Jasa Fotografi</h4>
                        <h2 class="font-weight-normal mb-5">Rp {{ number_format($totalPendapatanFotografi, 0, ',', '.') }}
                        </h2>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info text-white">
                    <div class="card-body">
                        <h4 class="font-weight-normal mb-3">Jasa videografi</h4>
                        <h2 class="font-weight-normal mb-5">Rp {{ number_format($totalPendapatanVideografi, 0, ',', '.') }}
                        </h2>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body">
                        <h4 class="font-weight-normal mb-3">Promo</h4>
                        <h2 class="font-weight-normal mb-5">Rp {{ number_format($totalHargaKeseluruhanPromo, 0, ',', '.') }}
                        </h2>
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

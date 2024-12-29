@extends('layouts.dashboard')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body text-center">
                        <!-- Foto Profil -->
                        <div class="profile-photo mb-4">
                            <img src="{{ asset('uploads/foto/' . ($user->foto ?? 'default.png')) }}" alt="Foto Profil"
                                class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <form action="{{ route('profile.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <!-- Label untuk Nama -->
                                <div class="col-md-4 text-start">
                                    <label for="name" class="form-label">Nama</label>
                                </div>
                                <!-- Input untuk Nama -->
                                <div class="col-md-8">
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ $user->name }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Label untuk Email -->
                                <div class="col-md-4 text-start">
                                    <label for="email" class="form-label">Email</label>
                                </div>
                                <!-- Input untuk Email -->
                                <div class="col-md-8">
                                    <input type="email" id="email" name="email" class="form-control"
                                        value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Label untuk Password -->
                                <div class="col-md-4 text-start">
                                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin
                                        diubah)</label>
                                </div>
                                <!-- Input untuk Password -->
                                <div class="col-md-8">
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Label untuk Nomor Telepon -->
                                <div class="col-md-4 text-start">
                                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                </div>
                                <!-- Input untuk Nomor Telepon -->
                                <div class="col-md-8">
                                    <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control"
                                        value="{{ $user->role === 'customer' ? $customer->nomor_telepon ?? '' : $fotografer->nomor_telepon ?? '' }}"
                                        required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- Label untuk Foto -->
                                <div class="col-md-4 text-start">
                                    <label for="foto" class="form-label">Foto Profil</label>
                                </div>
                                <!-- Input untuk Foto -->
                                <div class="col-md-8">
                                    <input type="file" id="foto" name="foto" class="form-control-file">
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

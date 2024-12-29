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
                Tambah Pengguna
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    @if (in_array($user->role, ['customer', 'fotografer', 'admin']))
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->role == 'customer')
                                                    {{ $user->customer ? $user->customer->nomor_telepon : 'No phone' }}
                                                @elseif($user->role == 'fotografer')
                                                    {{ $user->fotografer ? $user->fotografer->nomor_telepon : 'No phone' }}
                                                @else
                                                    Tidak ada
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#detailModal{{ $user->id }}">Detail</button>
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $user->id }}">Edit</button>
                                                <!-- Form Hapus -->
                                                <form id="deleteForm{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                    class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="detailModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Pengguna</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Nama:</strong></label>
                                                            <div class="col-sm-8">
                                                                <p class="form-control-plaintext">{{ $user->name }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Email:</strong></label>
                                                            <div class="col-sm-8">
                                                                <p class="form-control-plaintext">{{ $user->email }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Role:</strong></label>
                                                            <div class="col-sm-8">
                                                                <p class="form-control-plaintext">
                                                                    {{ ucfirst($user->role) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>Nomor
                                                                    Telepon:</strong></label>
                                                            <div class="col-sm-8">
                                                                <p class="form-control-plaintext">
                                                                    @if ($user->role == 'customer')
                                                                        {{ $user->customer ? $user->customer->nomor_telepon : '-' }}
                                                                    @elseif ($user->role == 'fotografer')
                                                                        {{ $user->fotografer ? $user->fotografer->nomor_telepon : '-' }}
                                                                    @else
                                                                        Tidak ada
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Pengguna</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Nama</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="name"
                                                                        class="form-control" value="{{ $user->name }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Email</label>
                                                                <div class="col-sm-8">
                                                                    <input type="email" name="email"
                                                                        class="form-control" value="{{ $user->email }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Role</label>
                                                                <div class="col-sm-8">
                                                                    <select name="role" class="form-control" required>
                                                                        <option value="customer"
                                                                            {{ $user->role == 'customer' ? 'selected' : '' }}>
                                                                            Customer</option>
                                                                        <option value="fotografer"
                                                                            {{ $user->role == 'fotografer' ? 'selected' : '' }}>
                                                                            Fotografer</option>
                                                                        <option value="admin"
                                                                            {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                            Admin</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Nomor
                                                                    Telepon</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="nomor_telepon"
                                                                        class="form-control"
                                                                        value="{{ $user->role == 'customer' ? optional($user->customer)->nomor_telepon : ($user->role == 'fotografer' ? optional($user->fotografer)->nomor_telepon : '') }}">

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">Password
                                                                    (Opsional)
                                                                </label>
                                                                <div class="col-sm-8">
                                                                    <input type="password" name="password"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Nama" name="name" id="name"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" placeholder="Email" name="email" id="email"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-4 col-form-label">Role</label>
                            <div class="col-sm-8">
                                <select name="role" id="role" class="form-control" required>
                                    <option value="customer">Customer</option>
                                    <option value="fotografer">Fotografer</option>
                                    <option value="admin">Admin</option>
                                </select>


                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_telepon" class="col-sm-4 col-form-label">Nomor Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control"
                                    value="{{ old('nomor_telepon') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" placeholder="Password" id="password"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-4 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                    id="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

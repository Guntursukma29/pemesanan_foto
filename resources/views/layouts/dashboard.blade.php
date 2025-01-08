<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Clicks Studio</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <h1 class="navbar-brand brand-logo">Clicks Studio</h1>
                </div>
               
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
               
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="{{ asset('uploads/foto/' . (Auth::user()->foto ?? 'default.png')) }}"
                                    alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <!-- Link Profile berdasarkan role -->
                            @if (Auth::user()->role == 'admin')
                                <a class="dropdown-item" href="{{ route('profile.admin') }}">
                                    <i class="mdi mdi-account mr-2 text-primary"></i> Profile
                                </a>
                            @elseif(Auth::user()->role == 'fotografer')
                                <a class="dropdown-item" href="{{ route('profile.fotografer') }}">
                                    <i class="mdi mdi-account mr-2 text-primary"></i> Profile
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <!-- Link Logout -->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); 
                                        document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-2 text-primary"></i> Signout
                            </a>

                            <!-- Form untuk Logout -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="{{ asset('uploads/foto/' . (Auth::user()->foto ?? 'default.png')) }}"
                                    alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                                <span class="text-secondary text-small">{{ Auth::user()->role }}</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <span class="menu-title">Dashboard</span>
                                <i class="mdi mdi-home menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#ui-data" aria-expanded="false" aria-controls="ui-data"
                                data-bs-toggle="collapse">
                                <span class="menu-title">Data</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                            </a>
                            <div class="collapse" id="ui-data">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link"
                                            href="{{ route('users.index') }}">User</a>
                                    </li>
                                </ul>
                            </div>
                        </li><li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.pemesanan.videografi.index') ? 'active' : '' }}" href="#ui-pemesanan" aria-expanded="false" aria-controls="ui-data" data-bs-toggle="collapse">
                                <span class="menu-title">Pemesanan</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                            </a>
                            <div class="collapse" id="ui-pemesanan">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.pemesanan.videografi.index') ? 'active' : '' }}" href="{{ route('admin.pemesanan.videografi.index') }}">Videografi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.pemesanan.index') ? 'active' : '' }}" href="{{ route('admin.pemesanan.index') }}">Fotografi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.pemesanan.promo.index') ? 'active' : '' }}" href="{{ route('admin.pemesanan.promo.index') }}">Promo</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('videografi.index') ? 'active' : '' }}" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                                <span class="menu-title">Paket</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('videografi.index') ? 'active' : '' }}" href="{{ route('videografi.index') }}">Videografi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('fotografi.index') ? 'active' : '' }}" href="{{ route('fotografi.index') }}">Fotografi</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dokumentasi.videografi') ? 'active' : '' }}" href="#ui-dokumentasi" aria-expanded="false" aria-controls="ui-data" data-bs-toggle="collapse">
                                <span class="menu-title">Dokumentasi</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                            </a>
                            <div class="collapse" id="ui-dokumentasi">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('dokumentasi.videografi') ? 'active' : '' }}" href="{{ route('dokumentasi.videografi') }}">Videografi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('dokumentasi.fotografi') ? 'active' : '' }}" href="{{ route('dokumentasi.fotografi') }}">Fotografi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('dokumentasi.promo') ? 'active' : '' }}" href="{{ route('dokumentasi.promo') }}">Promo</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        {{-- login sebagai role = fotografer --}}
                        {{-- end role = fotografer --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ulasan.index') }}">
                                <span class="menu-title">Ulasan</span>
                                <i class="mdi mdi-table-large menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('promo.index') }}">
                                <span class="menu-title">Promo</span>
                                <i class="mdi mdi-table-large menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('portofolio.index') }}">
                                <span class="menu-title">Portofolio</span>
                                <i class="mdi mdi-table-large menu-icon"></i>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->role === 'fotografer')
                        <li class="nav-item">
                            <a class="nav-link" href="#ui-data" aria-expanded="false" aria-controls="ui-data"
                                data-bs-toggle="collapse">
                                <span class="menu-title">Pemesanan</span>
                                <i class="menu-arrow"></i>
                                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                            </a>
                            <div class="collapse" id="ui-data">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link"
                                            href="{{ route('fotografer.fotografi') }}">Fotografi</a>
                                    </li>
                                    <li class="nav-item"> <a class="nav-link"
                                            href="{{ route('fotografer.videografi') }}">Videografi</a></li>
                                    <li class="nav-item"> <a class="nav-link"
                                            href="{{ route('fotografer.promo') }}">Promo</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        @yield('content')
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->

                    <!-- partial -->
                </div>
                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                            Clicks Studio</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><a
                                href="https://www.bootstrapdash.com/bootstrap-admin-template/"
                                target="_blank"></a></span>
                    </div>
                </footer>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ asset('admin/assets/vendors/chart.js/Chart.umd.js') }}"></script>
        <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page -->
        <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
        <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
        <!-- End custom js for this page -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                });
            </script>
        @elseif ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Ada yang salah!',
                    text: '{{ $errors->first() }}',
                });
            </script>
        @endif

        @if (session('delete_success'))
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Dihapus',
                    text: '{{ session('delete_success') }}',
                });
            </script>
        @endif

        <script>
            function confirmDelete(userId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika konfirmasi diterima, kirimkan form penghapusan
                        document.getElementById('deleteForm' + userId).submit();
                    }
                });
            }
        </script>
        <script>
            function confirmHide(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Ulasan ini akan disembunyikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Sembunyikan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirimkan form penyembunyian jika konfirmasi diterima
                        document.getElementById('hideForm' + id).submit();
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#userTable').DataTable();
                $('#userTableVideografi').DataTable();
                $('#user').DataTable();
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>

</html>

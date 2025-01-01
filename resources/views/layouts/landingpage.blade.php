<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - iLanding Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">


    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: iLanding
  * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
  * Updated: Nov 12 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">Clicks Studio</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('landing.page') }}"
                            class="{{ request()->routeIs('landing.page') ? 'active' : '' }}">Home</a></li>
                    <li><a href="#" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('paket.index') }}"
                            class="{{ request()->routeIs('paket.index') ? 'active' : '' }}">Paket</a></li>
                    <li><a href="{{ route('promo') }}"
                            class="{{ request()->routeIs('promo') ? 'active' : '' }}">Promo</a></li>
                    <li class="dropdown">
                        <a href="#"
                            class="{{ request()->routeIs('pemesanans.index') || request()->routeIs('pemesanans.videografi.index') || request()->routeIs('pemesanans.promo.index') ? 'active' : '' }}">
                            <span>Riwayat Pesanan</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            @auth
                                <li><a href="{{ route('pemesanans.index') }}"
                                        class="{{ request()->routeIs('pemesanans.index') ? 'active' : '' }}">Pemesanan
                                        Fotografi</a></li>
                                <li><a href="{{ route('pemesanans.videografi.index') }}"
                                        class="{{ request()->routeIs('pemesanans.videografi.index') ? 'active' : '' }}">Pemesanan
                                        Videografi</a></li>
                                <li><a href="{{ route('pemesanans.promo.index') }}"
                                        class="{{ request()->routeIs('pemesanans.promo.index') ? 'active' : '' }}">Pemesanan
                                        Promo</a></li>
                            @endauth
                        </ul>
                    </li>
                    <li><a href="#contact" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            @if (Route::has('login'))
                <a class="btn-getstarted dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @auth
                        <!-- Menampilkan nama pengguna jika sudah login -->
                        {{ Auth::user()->name }}
                    @else
                        Menu
                    @endauth
                </a>
                <ul class="dropdown-menu">
                    @auth
                        <li><a class="dropdown-item" href="{{ route('profile.customer') }}">
                                <i class="mdi mdi-history mr-2 text-primary"></i> Profile
                            </a></li>
                        <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout mr-2 text-primary"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endauth
                </ul>


            @endif

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                @yield('content')

            </div>

        </section>
        @yield('paket')
    </main>

    <footer id="footer" class="footer bg-light">

        <div class="container footer-top">
            <div class="row gy-4">
                <!-- Footer Alamat -->
                <div class="col-lg-4 col-md-6 footer-about text-start">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">Clicks Studio</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jln. Kenangah Indah g1b</p>
                        <p>Blok Harmoni No. 18-20 Rt 1/Rw.6 Kelurahan Jatimulyo,</p>
                        <p>Kecamatan Lowokmaru, Kabupaten Malang, Jawa Timur.</p>
                    </div>
                </div>
    
                <!-- Footer Layanan -->
                <div class="col-lg-4 col-md-6 footer-links ">
                    <h4>Layanan</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Wedding</a></li>
                        <li><a href="#">Birthday</a></li>
                        <li><a href="#">Graduation</a></li>
                        <li><a href="#">Video Profiling</a></li>
                        <li><a href="#">Engangement</a></li>
                        <li><a href="#">Event</a></li>
                    </ul>
                </div>
    
                <!-- Footer Kontak -->
                <div class="col-lg-4 col-md-6 footer-links ">
                    <h4>Kontak Kami</h4>
                    <div class="d-flex flex-column mt-4 align-items-start">
                        <!-- Logo Instagram -->
                        <div class="d-flex align-items-center mb-3">
                            <!-- Logo Instagram -->
                            <a href="https://www.instagram.com/clicks._studio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" style="text-decoration: none; margin-right: 10px;">
                                <svg width="40" height="40" viewBox="0 0 200 200">
                                    <defs>
                                        <!-- 矩形的線性漸層 -->
                                        <linearGradient id="gradient1" x1=".8" y1=".8" x2="0">
                                            <stop offset="0" stop-color="#c92bb7"/>
                                            <stop offset="1" stop-color="#3051f1"/>
                                        </linearGradient>
                                        <!-- 矩形的放射漸層 -->
                                        <radialGradient id="gradient2" cx=".2" cy="1" r="1.2">
                                            <stop offset="0" stop-color="#fcdf8f"/>
                                            <stop offset=".1" stop-color="#fbd377"/>
                                            <stop offset=".25" stop-color="#fa8e37"/>
                                            <stop offset=".35" stop-color="#f73344"/>
                                            <stop offset=".65" stop-color="#f73344" stop-opacity="0" />
                                        </radialGradient>
                                        <!-- 矩形外框 -->
                                        <rect id="logoContainer" x="0" y="0" width="200" height="200" rx="50" ry="50" />
                                    </defs>
                            
                                    <!-- colorful 的背景 -->
                                    <use xlink:href="#logoContainer" fill="url(#gradient1)" />
                                    <use xlink:href="#logoContainer" fill="url(#gradient2)" />
                            
                                    <!-- 相機外框 -->
                                    <rect x="35" y="35" width="130" height="130" rx="30" ry="30"
                                          fill="none" stroke="#fff" stroke-width="13" />
                            
                                    <!-- 鏡頭外框 -->
                                    <circle cx="100" cy="100" r="32"
                                            fill="none" stroke="#fff" stroke-width="13" />
                            
                                    <!-- 閃光燈 -->
                                    <circle cx="140" cy="62" r="9" fill="#fff"/>
                                </svg>
                            </a>
                            <!-- Tulisan -->
                            <p class="mb-0">
                                <strong>Instagram:</strong> clicks.studio
                            </p>
                        </div>
                        
                        <!-- Logo WhatsApp -->
                        <div class="d-flex align-items-center mb-3">
                            <a href="https://wa.me/6285290602986" style="text-decoration: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" id="IconChangeColor" height="40" width="40"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 122.8c-72.7 0-131.8 59.1-131.9 131.8 0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6 49.9-13.1 4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8 0-35.2-15.2-68.3-40.1-93.2-25-25-58-38.7-93.2-38.7zm77.5 188.4c-3.3 9.3-19.1 17.7-26.7 18.8-12.6 1.9-22.4.9-47.5-9.9-39.7-17.2-65.7-57.2-67.7-59.8-2-2.6-16.2-21.5-16.2-41s10.2-29.1 13.9-33.1c3.6-4 7.9-5 10.6-5 2.6 0 5.3 0 7.6.1 2.4.1 5.7-.9 8.9 6.8 3.3 7.9 11.2 27.4 12.2 29.4s1.7 4.3.3 6.9c-7.6 15.2-15.7 14.6-11.6 21.6 15.3 26.3 30.6 35.4 53.9 47.1 4 2 6.3 1.7 8.6-1 2.3-2.6 9.9-11.6 12.5-15.5 2.6-4 5.3-3.3 8.9-2 3.6 1.3 23.1 10.9 27.1 12.9s6.6 3 7.6 4.6c.9 1.9.9 9.9-2.4 19.1zM400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM223.9 413.2c-26.6 0-52.7-6.7-75.8-19.3L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5 29.9 30 47.9 69.8 47.9 112.2 0 87.4-72.7 158.5-160.1 158.5z" id="mainIconPathAttribute" fill="green"></path></svg>
                            </a>
                            <p class="mt-2"><strong>WhatsApp :</strong> +6285290602986</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Clicks Studio</strong> <span>All Rights Reserved</span></p>
        </div>
    
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
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
        $(document).ready(function() {
            $('.user').DataTable();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


</body>

</html>

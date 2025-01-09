<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - iLanding Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.0.1/swiper-bundle.min.css">

    <!-- Favicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
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
                    <li><a href="{{ route('landing.page') }}" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="{{ route('paket.index') }}">Paket</a></li>
                    <li><a href="{{ route('promo') }}">Promo</a></li>
                    <li class="dropdown"><a href="#"><span>Riwayat Pesanan</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('pemesanans.index') }}">Pemesanan Fotografi</a></li>
                            <li><a href="{{ route('pemesanans.videografi.index') }}">Pemesanan Videografi</a></li>
                            <li><a href="{{ route('pemesanans.promo.index') }}">Pemesanan Promo</a></li>
                        </ul>
                    </li>
                    <li><a href="#footer">Contact</a></li>
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

                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            <div class="company-badge mb-4">
                                <i class="bi bi-gear-fill me-2"></i>
                                Clicks Studio
                            </div>

                            <h1 class="mb-4">
                                Jadikan Moment Anda <br>
                                Lebih bermakna<br>
                                <span class="accent-text">Bersama Clicks Studio</span>
                            </h1>

                            <p class="mb-4 mb-md-5">
                                The Best Memories Start Here
                            </p>

                            <div class="hero-buttons">
                                @auth
                                    {{-- Jika pengguna sudah login, tombol tidak akan muncul --}}
                                @else
                                    {{-- Jika pengguna belum login, tampilkan tombol --}}
                                    <a href="{{ route('login') }}" class="btn btn-primary me-0 me-sm-2 mx-1">TRY IT
                                        NOW</a>
                                @endauth {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                                    class="btn btn-link mt-2 mt-sm-0 glightbox">
                                    <i class="bi bi-play-circle me-1"></i>
                                    Play Video
                                </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            <img src="{{ asset('assets/img/foto.jpg') }}" alt="Hero Image" class="img-fluid">

                            {{-- <div class="customers-badge">
                                <div class="customer-avatars">
                                    <img src="{{ asset('assets/img/avatar-1.webp') }}" alt="Customer 1"
                                        class="avatar">
                                    <img src="{{ asset('assets/img/avatar-2.webp') }}" alt="Customer 2"
                                        class="avatar">
                                    <img src="{{ asset('assets/img/avatar-3.webp') }}" alt="Customer 3"
                                        class="avatar">
                                    <img src="{{ asset('assets/img/avatar-4.webp') }}" alt="Customer 4"
                                        class="avatar">
                                    <img src="{{ asset('assets/img/avatar-5.webp') }}" alt="Customer 5"
                                        class="avatar">
                                    <span class="avatar more">12+</span>
                                </div>
                                <p class="mb-0 mt-2">12,000+ lorem ipsum dolor sit amet consectetur adipiscing elit</p>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 align-items-center justify-content-between">

                    <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
                        <span class="about-meta">TENTANG KAMI</span>
                        {{-- <h2 class="about-title">Voluptas enim suscipit temporibus</h2> --}}
                        <p class="about-description">Clicks Studio merupakan sebuah jasa layanan fotografi dan
                            videografi yang
                            beroperasi dikota malang tepatnya di Jln. Kenangah Indah g1b Blok Harmoni No. 18-20 Rt
                            1/Rw.6 Kelurahan Jatimulyo, Kecamatan Lowokmaru, Kabupaten Malang, Jawa Timur.
                        </p>
                        <p class="about-description">Kami telah melayani pelanggan dengan berbagai layanan fotografi
                            dan videografi, meliputi pre-wedding, wisuda, birthday, serta berbagai event lainnya. Dengan
                            tim yang terdiri dari fotografer dan videografer berpengalaman, kami menyediakan berbagai
                            paket layanan yang dapat disesuaikan dengan kebutuhan Anda, seperti

                        <div class="row feature-list-wrapper">
                            <div class="col-md-6">
                                <ul class="feature-list">
                                    <li><i class="bi bi-check-circle-fill"></i>Engangement</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Wisuda</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Birthday</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="feature-list">
                                    <li><i class="bi bi-check-circle-fill"></i>Wedding</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Video Profiling</li>
                                    <li><i class="bi bi-check-circle-fill"></i>Event</li>
                                </ul>
                            </div>
                        </div>

                        <div class="info-wrapper">
                            <div class="row gy-4">
                                <div class="col-lg-5">
                                    <div class="profile d-flex align-items-center gap-3">
                                        <img src="{{ asset('assets/img/owner.jpeg') }}" alt="CEO Profile"
                                            class="profile-image">
                                        <div>
                                            <h4 class="profile-name">M. Hafiz</h4>
                                            <p class="profile-position">Owner &amp;</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="contact-info d-flex align-items-center gap-2">
                                        <i class="bi bi-telephone-fill"></i>
                                        <div>
                                            <p class="contact-label">Call us anytime</p>
                                            <p class="contact-number">+62 852 90602986</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="image-wrapper">
                            <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                                <img src="{{ asset('assets/img/clicks studio.png') }}" alt="Business Meeting"
                                    class="img-fluid main-image rounded-4">
                                {{-- <img src="{{ asset('assets/img/about-2.webp') }}" alt="Team Discussion"
                                    class="img-fluid small-image rounded-4"> --}}
                            </div>
                            {{-- <div class="experience-badge floating">
                                <h3>15+ <span>Years</span></h3>
                                <p>Of experience in business service</p>
                            </div>
                        </div> --}}
                        </div>
                    </div>

                </div>

        </section><!-- /About Section -->

        <section id="clients" class="clients section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-center">Portofolio</h3>

                <!-- Swiper Slider -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($portofolio as $item)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $item->foto) }}" class="img-fluid"
                                    alt="Portofolio Foto" width="300" height="200">
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- Swiper Initialization -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const swiper = new Swiper(".mySwiper", {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        slidesPerView: 1,
                        spaceBetween: 10,
                        breakpoints: {
                            320: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            480: {
                                slidesPerView: 3,
                                spaceBetween: 30,
                            },
                            768: {
                                slidesPerView: 4,
                                spaceBetween: 40,
                            },
                            992: {
                                slidesPerView: 6,
                                spaceBetween: 50,
                            },
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                    });
                });
            </script>
        </section>






        <section id="testimonials" class="testimonials section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Apa Kata Mereka?</h2>
                {{-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> --}}
            </div><!-- End Section Title -->

            <div class="container">

                <!-- Wrapper for Testimonials with Scroll -->
                <div class="testimonial-wrapper" style="max-height: 600px; overflow-y: auto;">
                    <div class="row g-5">
                        @forelse ($ulasan as $key => $item)
                            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="testimonial-item"
                                    style="display: flex; flex-direction: column; align-items: center; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">

                                    <!-- Foto Pengguna (Segi Empat) -->
                                    <img src="{{ asset('uploads/foto/' . ($item->user->foto ?? 'default.png')) }}"
                                        class="testimonial-img" alt="Foto Profil"
                                        style="width: 80px; height: 80px; object-fit: contain; margin-bottom: 15px;">

                                    <!-- Nama Pengguna -->
                                    <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 5px;">
                                        {{ $item->user->name }}</h3>

                                    <!-- Paket yang Dipesan -->
                                    <h4 style="font-size: 14px; color: #777; text-align: center; margin-bottom: 10px;">
                                        @if ($item->pemesanan_id)
                                            {{ optional($item->pemesanan->fotografi)->nama ?? 'Nama tidak ditemukan' }}
                                        @elseif ($item->pemesanan_videografi_id)
                                            {{ optional($item->pemesananVideografi->videografi)->nama ?? 'Nama tidak ditemukan' }}
                                        @elseif ($item->pemesanan_promo_id)
                                            {{ optional($item->pemesananPromo->promo)->nama ?? 'Nama tidak ditemukan' }}
                                        @else
                                            Tidak ada paket
                                        @endif
                                    </h4>

                                    <!-- Rating Bintang -->
                                    <div class="stars" style="margin-bottom: 10px;">
                                        @for ($i = 1; $i <= $item->bintang; $i++)
                                            <span class="bi bi-star-fill" style="color: gold;"></span>
                                        @endfor
                                        @for ($i = $item->bintang + 1; $i <= 5; $i++)
                                            <span class="bi bi-star" style="color: lightgray;"></span>
                                        @endfor
                                    </div>

                                    <!-- Foto Testimonial -->
                                    <img src="{{ asset('storage/' . $item->foto) }}" class="testimonial-img"
                                        alt="Foto Profil"
                                        style="width: 100%; max-height: 250px; object-fit: contain; border-radius: 8px; margin-bottom: 15px;">

                                    <!-- Catatan Testimonial -->
                                    <p style="font-size: 14px; color: #555; text-align: center;">
                                        <i class="bi bi-quote quote-icon-left"
                                            style="font-size: 20px; color: gold;"></i>
                                        <span>{{ $item->catatan }}</span>
                                        <i class="bi bi-quote quote-icon-right"
                                            style="font-size: 20px; color: gold;"></i>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <h4 style="text-align: center; width: 100%; padding: 20px; background-color: #f9f9f9;">
                                Tidak Ada</h4>
                        @endforelse
                    </div><!-- End .row -->
                </div><!-- End .testimonial-wrapper -->

            </div><!-- End .container -->
        </section><!-- /Testimonials Section -->



        <!-- Stats Section -->
        {{-- <section id="stats" class="stats section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Clients</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Projects</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="1453"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hours Of Support</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Workers</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section --> --}}
        <!-- Faq Section -->
        <section class="faq-9 faq section light-background" id="faq">

            <div class="container">
                <div class="row">

                    <div class="col-lg-5" data-aos="fade-up">
                        <h2 class="faq-title">Punya Pertanyaan? Cek FAQ Kami</h2>
                        {{-- <p class="faq-description">Maecenas tempus tellus eget condimentum rhoncus sem quam semper
                            libero sit amet adipiscing sem neque sed ipsum.</p> --}}
                        <div class="faq-arrow d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                            <svg class="faq-arrow" width="200" height="211" viewBox="0 0 200 211"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M198.804 194.488C189.279 189.596 179.529 185.52 169.407 182.07L169.384 182.049C169.227 181.994 169.07 181.939 168.912 181.884C166.669 181.139 165.906 184.546 167.669 185.615C174.053 189.473 182.761 191.837 189.146 195.695C156.603 195.912 119.781 196.591 91.266 179.049C62.5221 161.368 48.1094 130.695 56.934 98.891C84.5539 98.7247 112.556 84.0176 129.508 62.667C136.396 53.9724 146.193 35.1448 129.773 30.2717C114.292 25.6624 93.7109 41.8875 83.1971 51.3147C70.1109 63.039 59.63 78.433 54.2039 95.0087C52.1221 94.9842 50.0776 94.8683 48.0703 94.6608C30.1803 92.8027 11.2197 83.6338 5.44902 65.1074C-1.88449 41.5699 14.4994 19.0183 27.9202 1.56641C28.6411 0.625793 27.2862 -0.561638 26.5419 0.358501C13.4588 16.4098 -0.221091 34.5242 0.896608 56.5659C1.8218 74.6941 14.221 87.9401 30.4121 94.2058C37.7076 97.0203 45.3454 98.5003 53.0334 98.8449C47.8679 117.532 49.2961 137.487 60.7729 155.283C87.7615 197.081 139.616 201.147 184.786 201.155L174.332 206.827C172.119 208.033 174.345 211.287 176.537 210.105C182.06 207.125 187.582 204.122 193.084 201.144C193.346 201.147 195.161 199.887 195.423 199.868C197.08 198.548 193.084 201.144 195.528 199.81C196.688 199.192 197.846 198.552 199.006 197.935C200.397 197.167 200.007 195.087 198.804 194.488ZM60.8213 88.0427C67.6894 72.648 78.8538 59.1566 92.1207 49.0388C98.8475 43.9065 106.334 39.2953 114.188 36.1439C117.295 34.8947 120.798 33.6609 124.168 33.635C134.365 33.5511 136.354 42.9911 132.638 51.031C120.47 77.4222 86.8639 93.9837 58.0983 94.9666C58.8971 92.6666 59.783 90.3603 60.8213 88.0427Z"
                                    fill="currentColor"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                        <div class="faq-container">
                            {{-- edit disini --}}
                            <div class="faq-item faq-active">
                                {{-- pertanyaan --}}
                                <h3>Apakah saya akan mendapatkan file hasil foto dan video secara digital?</h3>
                                {{-- ini jawaban --}}
                                <div class="faq-content">
                                    <p>Iya, semua file hasil foto dan video akan dikirimkan dalam format digital melalui
                                        link gdrive.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Berapa lama waktu yang dibutuhkan untuk pengeditan hasil foto atau video??</h3>
                                <div class="faq-content">
                                    <p>Waktu editing tergantung pada jenis paket dan jumlah foto/video yang diambil.
                                        Rata-rata, hasil dokumentasi dapat diselesaikan dalam waktu 2-3 hari.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3> Apakah saya bisa meminta revisi pada hasil foto atau video?</h3>
                                <div class="faq-content">
                                    <p> Ya, kami menyediakan opsi revisi sesuai dengan paket yang Anda pilih. Untuk
                                        mengetahui detail lebih lanjut mengenai revisi yang termasuk dalam setiap paket,
                                        silakan cek informasi di halaman paket layanan kami.
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Bagaimana cara melakukan pemesanan jasa di website ini?</h3>
                                <div class="faq-content">
                                    <p>Anda dapat melakukan pemesanan dengan memilih paket yang tersedia di halaman
                                        layanan kami, mengisi formulir pemesanan, dan memilih tanggal yang tersedia
                                        sesuai kebutuhan Anda. Setelah itu, Anda akan diarahkan untuk melakukan
                                        pembayaran secara online.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Apakah ada promo atau diskon yang tersedia?</h3>
                                <div class="faq-content">
                                    <p>Informasi terkait promo atau diskon dapat dilihat di halaman promo di website
                                        kami. Jangan lupa untuk mengecek secara berkala!
                                    </p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                            <div class="faq-item">
                                <h3>Apakah saya bisa mengubah jadwal pemesanan?</h3>
                                <div class="faq-content">
                                    <p>Anda hanya dapat mengubah jadwal pemesanan sebelum melakukan pembayaran. Setelah
                                        pembayaran dilakukan, jadwal yang telah ditentukan tidak dapat diubah.</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div><!-- End Faq item-->

                        </div>
                    </div>

                </div>
            </div>
        </section><!-- /Faq Section -->

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
                            <a href="https://www.instagram.com/clicks._studio?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                                style="text-decoration: none; margin-right: 10px;">
                                <svg width="40" height="40" viewBox="0 0 200 200">
                                    <defs>
                                        <!-- 矩形的線性漸層 -->
                                        <linearGradient id="gradient1" x1=".8" y1=".8" x2="0">
                                            <stop offset="0" stop-color="#c92bb7" />
                                            <stop offset="1" stop-color="#3051f1" />
                                        </linearGradient>
                                        <!-- 矩形的放射漸層 -->
                                        <radialGradient id="gradient2" cx=".2" cy="1" r="1.2">
                                            <stop offset="0" stop-color="#fcdf8f" />
                                            <stop offset=".1" stop-color="#fbd377" />
                                            <stop offset=".25" stop-color="#fa8e37" />
                                            <stop offset=".35" stop-color="#f73344" />
                                            <stop offset=".65" stop-color="#f73344" stop-opacity="0" />
                                        </radialGradient>
                                        <!-- 矩形外框 -->
                                        <rect id="logoContainer" x="0" y="0" width="200" height="200"
                                            rx="50" ry="50" />
                                    </defs>

                                    <!-- colorful 的背景 -->
                                    <use xlink:href="#logoContainer" fill="url(#gradient1)" />
                                    <use xlink:href="#logoContainer" fill="url(#gradient2)" />

                                    <!-- 相機外框 -->
                                    <rect x="35" y="35" width="130" height="130" rx="30" ry="30"
                                        fill="none" stroke="#fff" stroke-width="13" />

                                    <!-- 鏡頭外框 -->
                                    <circle cx="100" cy="100" r="32" fill="none" stroke="#fff"
                                        stroke-width="13" />

                                    <!-- 閃光燈 -->
                                    <circle cx="140" cy="62" r="9" fill="#fff" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" id="IconChangeColor"
                                    height="40"
                                    width="40"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M224 122.8c-72.7 0-131.8 59.1-131.9 131.8 0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6 49.9-13.1 4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8 0-35.2-15.2-68.3-40.1-93.2-25-25-58-38.7-93.2-38.7zm77.5 188.4c-3.3 9.3-19.1 17.7-26.7 18.8-12.6 1.9-22.4.9-47.5-9.9-39.7-17.2-65.7-57.2-67.7-59.8-2-2.6-16.2-21.5-16.2-41s10.2-29.1 13.9-33.1c3.6-4 7.9-5 10.6-5 2.6 0 5.3 0 7.6.1 2.4.1 5.7-.9 8.9 6.8 3.3 7.9 11.2 27.4 12.2 29.4s1.7 4.3.3 6.9c-7.6 15.2-15.7 14.6-11.6 21.6 15.3 26.3 30.6 35.4 53.9 47.1 4 2 6.3 1.7 8.6-1 2.3-2.6 9.9-11.6 12.5-15.5 2.6-4 5.3-3.3 8.9-2 3.6 1.3 23.1 10.9 27.1 12.9s6.6 3 7.6 4.6c.9 1.9.9 9.9-2.4 19.1zM400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM223.9 413.2c-26.6 0-52.7-6.7-75.8-19.3L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5 29.9 30 47.9 69.8 47.9 112.2 0 87.4-72.7 158.5-160.1 158.5z"
                                        id="mainIconPathAttribute" fill="green"></path>
                                </svg>
                            </a>
                            <p class="mt-2"><strong>WhatsApp :</strong> +6285290602986</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Clicks Studio</strong> <span>All Rights
                    Reserved</span></p>
        </div>

    </footer>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.0.1/swiper-bundle.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper('.swiper-container', {
                slidesPerView: 3,
                spaceBetween: 20,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    },
                }
            });
        });
    </script>
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
            $('#userTable').DataTable();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</body>

</html>

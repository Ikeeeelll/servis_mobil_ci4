<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sparepart - Utama Service Station</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Favicon -->
    <link href="/theme/img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="/theme/https://fonts.googleapis.com">
    <link rel="preconnect" href="/theme/https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="/theme/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/theme/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/theme/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="/theme/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="/theme/css/style.css" rel="stylesheet">
    <style>
        .sparepart-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .sparepart-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        .sparepart-card .card-img-top {
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sparepart-card .card-img-top i {
            font-size: 4rem;
            color: white;
        }
        .badge-stock {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.8rem;
        }
        .price-tag {
            font-size: 1.2rem;
            font-weight: 700;
            color: #d63384;
        }
        .search-box {
            max-width: 400px;
            margin: 0 auto 30px;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    
    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>Jl. S Parman No. 156 - 164 Padang</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center py-3">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Senin – Kamis : 08.00 AM – 17.00 PM & Sabtu – Minggu : 08.00 AM – 17.00 PM</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>(0751) 7054654</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square bg-white text-primary me-1" href="https://www.facebook.com/share/16Vd6P3VMo/"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-0" href="https://www.instagram.com/utamaservice_padang?igsh=MTB4eG5ya3doOTZ6cQ=="><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="<?= site_url('/') ?>" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>Utama Service Station</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="<?= site_url('/') ?>" class="nav-item nav-link">Beranda</a>
                <a href="<?= site_url('/Home/tentang') ?>" class="nav-item nav-link">Tentang Kami</a>
                <a href="<?= site_url('/Home/sparepart') ?>" class="nav-item nav-link active">Sparepart</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Servis</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="<?= site_url('/Booking') ?>" class="dropdown-item">Booking Servis</a>
                        <a href="<?= site_url('/Home/status') ?>" class="dropdown-item">Status Servis</a>
                        <a href="<?= site_url('/Home/layanan') ?>" class="dropdown-item">Jenis Servis</a>
                    </div>
                 </div>
                <?php if (session()->get('loggedin')): ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-user me-2"></i><?= session()->get('nama') ?>
                        </a>
                        <div class="dropdown-menu fade-down m-0">
                            <a href="<?= site_url('/Mobil') ?>" class="dropdown-item">Mobil Saya</a>
                            <a href="<?= site_url('/Home/profil') ?>" class="dropdown-item">Setting</a>
                            <a href="<?= site_url('/login/logout') ?>" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="#" class="nav-item nav-link" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</a>
                <?php endif; ?>
            </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/theme/img/carousel-bg-1.jpg'); background-size: cover; background-position: center;">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-3">Katalog Sparepart</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('/') ?>" class="text-white">Beranda</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Sparepart</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Sparepart Section Start -->
    <div class="container py-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="text-primary text-uppercase">// Katalog Sparepart //</h6>
            <h1 class="mb-5">Sparepart Berkualitas untuk Kendaraan Anda</h1>
        </div>

        <!-- Search Box -->
        <div class="search-box mb-5">
            <div class="input-group">
                <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="searchSparepart" placeholder="Cari sparepart...">
            </div>
        </div>

        <!-- Sparepart Grid -->
        <div class="row g-4" id="sparepartGrid">
            <?php if (!empty($sparepart)): ?>
                <?php foreach ($sparepart as $item): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 sparepart-item wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card sparepart-card shadow-sm h-100 position-relative">
                            <!-- Stock Badge -->
                            <?php if ($item['stok'] > 0): ?>
                                <span class="badge bg-success badge-stock">Stok: <?= $item['stok'] ?> <?= $item['satuan'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger badge-stock">Habis</span>
                            <?php endif; ?>
                            
                            <!-- Foto Sparepart -->
                            <?php if (!empty($item['foto'])): ?>
                                <img src="<?= base_url('uploads/sparepart/' . $item['foto']) ?>" class="card-img-top" alt="<?= esc($item['nama_sparepart']) ?>" style="height: 180px; object-fit: contain; background: white; padding: 10px;">
                            <?php else: ?>
                                <div class="card-img-top">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold mb-2"><?= esc($item['nama_sparepart']) ?></h5>
                                <p class="text-muted small mb-1 no-parts-text"><?= esc($item['no_parts'] ?? '-') ?></p>
                                <p class="text-muted small mb-2"><?= esc($item['satuan']) ?></p>
                                <p class="price-tag mb-0">Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?></p>
                            </div>
                            
                            <div class="card-footer bg-white border-0 text-center pb-3">
                                <?php if ($item['stok'] > 0): ?>
                                    <span class="badge bg-primary px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Tersedia
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i> Tidak Tersedia
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Belum ada data sparepart tersedia.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Info Section -->
        <div class="row mt-5 pt-5">
            <div class="col-lg-12">
                <div class="bg-light p-4 rounded-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h4 class="fw-bold mb-2"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Pembelian</h4>
                            <p class="mb-0 text-muted">
                                Untuk melakukan pembelian sparepart, silakan kunjungi langsung bengkel kami atau hubungi kami melalui telepon di <strong>(0751) 7054654</strong>. 
                                Tim kami akan membantu Anda menemukan sparepart yang tepat untuk kendaraan Anda.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="https://wa.me/6275170546544" target="_blank" class="btn btn-success btn-lg">
                                <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sparepart Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Alamat -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Alamat</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. S Parman No. 156 - 164 Padang</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(0751) 7054654</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/share/16Vd6P3VMo/"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/utamaservice_padang?igsh=MTB4eG5ya3doOTZ6cQ=="><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Jam Buka -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Buka</h4>
                    <h6 class="text-light">Senin – Kamis :</h6>
                    <p class="mb-4">08.00 AM – 17.00 PM</p>
                    <h6 class="text-light">Sabtu – Minggu :</h6>
                    <p class="mb-0">08.00 AM – 17.00 PM</p>
                </div>

                <!-- Servis -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Servis</h4>
                    <a class="btn btn-link" href="/Home/layanan">Tes Diagnostik</a>
                    <a class="btn btn-link" href="/Home/layanan">Servis Mesin</a>
                    <a class="btn btn-link" href="/Home/layanan">Penggantian Ban</a>
                    <a class="btn btn-link" href="/Home/layanan">Penggantian Oli</a>
                    <a class="btn btn-link" href="/Home/layanan">Pembersihan Vakum</a>
                </div>

                <!-- Kolom Baru: Dukungan -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Dukungan & Bantuan</h4>
                    <a class="btn btn-link" href="/Home/tentang">Tentang Kami</a>
                    <a class="btn btn-link" href="/Home/faq">FAQ</a>
                    <a class="btn btn-link" href="/Booking">Booking Servis</a>
                    <a class="btn btn-link" href="/Home/sparepart">Katalog Sparepart</a>
                </div>
            </div>

        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="index.php">2025 Utama Service Station</a></div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="index.php">Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/theme/lib/wow/wow.min.js"></script>
    <script src="/theme/lib/easing/easing.min.js"></script>
    <script src="/theme/lib/waypoints/waypoints.min.js"></script>
    <script src="/theme/lib/counterup/counterup.min.js"></script>
    <script src="/theme/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/theme/lib/tempusdominus/js/moment.min.js"></script>
    <script src="/theme/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="/theme/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="/theme/js/main.js"></script>
    
    <!-- Search Script -->
    <script>
        $(document).ready(function() {
            $('#searchSparepart').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.sparepart-item').filter(function() {
                    var title = $(this).find('.card-title').text().toLowerCase();
                    var noParts = $(this).find('.no-parts-text').text().toLowerCase();
                    $(this).toggle(title.indexOf(value) > -1 || noParts.indexOf(value) > -1);
                });
            });
        });
    </script>

    <?= $this->include('template/modal_login'); ?>
</body>

</html>

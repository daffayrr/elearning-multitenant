
<!DOCTYPE html>
<!-- Tambahkan class has-navbar-fixed-top agar konten tidak tertutup navbar -->
<html lang="id" class="has-navbar-fixed-top" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud LMS - Sistem e-Learning Berbasis Cloud</title>
    <meta name="description" content="Cloud LMS adalah penyedia layanan dan solusi IT terpercaya.">
    
    <!-- Import Font Inter dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Devicon untuk Ikon Programming -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css" />
    
    <!-- Bulma CSS v1.0.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    <!-- Tambahkan ini agar Admin bisa membaca FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta property="og:image" content="https://toscaflow.id/uploads/image/Tech.png">
    <meta name="description" content="Cloud LMS adalah penyedia layanan IT terintegrasi, melayani jasa pembuatan website, aplikasi sistem informasi, hingga konfigurasi server dan jaringan.">
    
    <style>
        :root {
            /* Override Warna Primary Bulma menjadi Tosca (#00A896) */
            --bulma-primary-h: 173;
            --bulma-primary-s: 100%;
            --bulma-primary-l: 33%;
            --bulma-primary: #00A896; 
            
            /* Override Warna Link Bulma menjadi Tosca yang sedikit lebih gelap */
            --bulma-link-h: 173;
            --bulma-link-s: 100%;
            --bulma-link-l: 28%;
            --bulma-link: #008778;
        }

        /* Terapkan Font Inter secara global */
        body { 
            font-family: 'Inter', sans-serif; 
            letter-spacing: -0.01em; /* Ciri khas font modern */
        }
        
        .navbar { padding: 0.5rem 0; transition: all 0.3s ease; }
        .footer-list { list-style: none; margin-left: 0; padding-left: 0; }
        .footer-list li { margin-bottom: 0.75rem; }
        .footer-list a { transition: color 0.2s; }
        .footer-list a:hover { color: var(--bulma-primary); }

        /* Kustomisasi tambahan untuk Hero Badge & Ikon */
        .badge-tosca {
            background-color: #E6F6F4;
            color: #00A896;
        }
        [data-theme="dark"] .badge-tosca {
            background-color: rgba(0, 168, 150, 0.2);
            color: #48C7B7;
        }

        /* CSS untuk Horizontal Scroll Portofolio */
        .portfolio-scroll-wrapper {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 1.5rem;
            padding-bottom: 2rem;
            padding-top: 1rem;
            /* Menyembunyikan scrollbar bawaan agar rapi, tapi tetap bisa digeser */
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .portfolio-scroll-wrapper::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }
        .portfolio-card-item {
            scroll-snap-align: start;
            flex: 0 0 340px; /* Lebar statis setiap kartu */
            display: flex;
            flex-direction: column;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            background-color: var(--bulma-scheme-main);
            border: 1px solid var(--bulma-border-light);
            transition: transform 0.3s ease;
        }
        .portfolio-card-item:hover {
            transform: translateY(-5px);
        }
        .portfolio-desc-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Maksimal 3 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* CSS Khusus untuk Kartu Layanan */
        .service-card-item {
            scroll-snap-align: start;
            flex: 0 0 300px; /* Lebar kartu layanan */
            display: flex;
            flex-direction: column;
            border-radius: 1rem;
            background-color: var(--bulma-scheme-main);
            border: 1px solid var(--bulma-border-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 1.75rem 1.5rem;
        }
        .service-card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-color: var(--bulma-primary); /* Border berubah tosca saat di-hover */
        }
        .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* CSS Khusus untuk Kartu Produk */
        .product-card-item {
            scroll-snap-align: start;
            flex: 0 0 350px;
            display: flex;
            flex-direction: column;
            border-radius: 1.25rem;
            background-color: var(--bulma-scheme-main);
            border: 1px solid var(--bulma-border-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden; /* Penting agar background atas tidak keluar dari radius */
        }
        .product-card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            border-color: var(--bulma-primary);
        }
        /* Bagian atas kartu yang berwarna gradasi */
        .product-card-top {
            height: 180px;
            background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        [data-theme="dark"] .product-card-top {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        }
        .product-icon-floating {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background-color: var(--bulma-link);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* CSS Khusus untuk Ikon Teknologi */
        .tech-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 110px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        .tech-item:hover {
            transform: translateY(-5px);
        }
        .tech-box {
            width: 75px;
            height: 75px;
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.75rem;
            color: white;
            box-shadow: 0 8px 15px rgba(0,0,0,0.06);
            margin-bottom: 0.75rem;
        }
        
        /* Warna Gradasi Kustom Sesuai Identitas Teknologi */
        .bg-php { background: linear-gradient(135deg, #8892BF 0%, #4F5B93 100%); }
        .bg-mysql { background: linear-gradient(135deg, #0093B5 0%, #00618A 100%); }
        .bg-ci { background: linear-gradient(135deg, #FF6A4D 0%, #DD3814 100%); }
        .bg-html { background: linear-gradient(135deg, #FF7B42 0%, #E34F26 100%); }
        .bg-python { background: linear-gradient(135deg, #5192C6 0%, #306998 100%); }
        .bg-dotnet { background: linear-gradient(135deg, #7E53C5 0%, #512BD4 100%); }
        .bg-linux { background: linear-gradient(135deg, #4A4A4A 0%, #1D1D1D 100%); }
        .bg-cloudflare { background: linear-gradient(135deg, #FFA954 0%, #F38020 100%); }
        .bg-nginx { background: linear-gradient(135deg, #00BA47 0%, #009639 100%); }
        .bg-apache { background: linear-gradient(135deg, #E6484F 0%, #D22128 100%); }

        /* CSS Khusus untuk Kartu Klien */
        /* CSS Khusus untuk Kartu Klien */
        /* Mengatur kotak luar agar seragam */
        .client-card {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 140px; /* Tinggi seragam untuk semua kotak, silakan sesuaikan */
            padding: 20px;
            background-color: #ffffff; /* Background putih agar logo PNG terlihat jelas */
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* Memberikan efek kartu elegan */
            transition: transform 0.3s ease;
        }
        
        /* Efek melayang saat kursor diarahkan (opsional) */
        .client-card:hover {
            transform: translateY(-5px);
        }
        
        /* Mengatur gambar logo di dalamnya */
        .client-logo {
            max-width: 85%; /* Maksimal lebar 85% dari kotak agar ada ruang bernapas */
            max-height: 80px; /* Maksimal tinggi 80px agar logo tidak raksasa */
            width: auto;
            height: auto;
            object-fit: contain; /* Mencegah gambar menjadi gepeng/distorsi */
            
            /* Opsional: Membuat logo abu-abu, lalu berwarna saat di-hover agar terlihat lebih pro */
             filter: grayscale(100%); 
             opacity: 0.7; 
             transition: all 0.3s ease; 
        }
        
        
         .client-card:hover .client-logo {
            filter: grayscale(0%);
            opacity: 1;
        } 
        
        /* Penyesuaian opasitas di Dark Mode agar tidak terlalu pucat saat bersanding dengan latar terang */
        [data-theme="dark"] .client-logo {
            filter: grayscale(100%) opacity(0.8); 
        }

        .client-card:hover .client-logo {
            filter: grayscale(0%) opacity(1);
        }

        /* CSS Khusus untuk Kartu Artikel */
        .article-card-item {
            scroll-snap-align: start;
            flex: 0 0 350px;
            display: flex;
            flex-direction: column;
            border-radius: 1.25rem;
            background-color: var(--bulma-scheme-main);
            border: 1px solid var(--bulma-border-light);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .article-card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
            border-color: var(--bulma-primary);
        }
        
        /* Pembungkus Gambar 16:9 */
        .article-img-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* Rasio 16:9 */
            background-color: var(--bulma-border-light);
            overflow: hidden;
        }
        .article-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .article-card-item:hover .article-img-wrapper img {
            transform: scale(1.05); /* Efek zoom in saat dihover */
        }
        
        /* Badge Kategori Melayang */
        .article-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background-color: var(--bulma-primary);
            color: white;
            padding: 0.25rem 0.85rem;
            border-radius: 1rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            z-index: 2;
        }

        /* Teks Meta (User, Tanggal, Views) */
        .article-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.75rem;
            color: var(--bulma-text-light);
            margin-bottom: 0.75rem;
        }
        .article-meta span {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Perbaikan Layout Portfolio */
.portfolio-header-gradient {
    background: linear-gradient(to bottom, var(--bulma-scheme-main-bis) 0%, var(--bulma-scheme-main) 100%);
    padding: 4rem 0;
    border-bottom: 1px solid var(--bulma-border-light);
}
.tech-tag-custom {
    background-color: var(--bulma-primary-light);
    color: var(--bulma-primary-dark);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.75rem;
    display: inline-block;
    margin: 0.25rem;
}
.info-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--bulma-primary);
    font-weight: 700;
    display: block;
    margin-bottom: 0.25rem;
}
.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--bulma-text);
}
    </style>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G8KJRBKS5V"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-G8KJRBKS5V');
    </script>
</head>
<body>

    
    <!-- NAVBAR (FIXED TOP) -->
    <nav class="navbar is-fixed-top has-shadow" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand align-items-center">
                <a class="navbar-item" href="https://toscaflow.id/">
                                            <img src="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png" alt="Cloud LMS" 
                             class="dynamic-logo"
                             data-light="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png" 
                             data-dark="https://toscaflow.id/uploads/logo/1777701228_2955d0d783fe7b984d40.png" 
                             style="max-height: 2.2rem; width: auto;">
                                    </a>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasic" class="navbar-menu font-weight-medium">
                <div class="navbar-end is-align-items-center">
                    <a href="https://toscaflow.id/about" class="navbar-item">Tentang Kami</a>
                    <a href="https://toscaflow.id/services" class="navbar-item">Layanan</a>
                    <a href="https://toscaflow.id/portfolio" class="navbar-item">Portofolio</a>
                    <a href="https://toscaflow.id/products" class="navbar-item">Produk</a>
                    <a href="https://toscaflow.id/blog" class="navbar-item">Artikel & Berita</a>
                    <a href="https://toscaflow.id/contact" class="navbar-item">Kontak</a>
                    
                    <!-- Tombol Dark/Light Mode -->
                    <a class="navbar-item px-4" id="theme-toggle" title="Ubah Tema" style="cursor: pointer;">
                        <span class="icon is-medium">
                            <i class="fa-solid fa-moon is-size-5" id="theme-icon"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN DINAMIS HALAMAN -->
    
<!-- HERO SECTION -->
<section class="hero is-medium mt-6">
    <div class="hero-body pt-6 pb-6">
        <div class="container">
            <div class="columns is-vcentered">
                
                <!-- KOLOM KIRI: Teks & Tombol -->
                <div class="column is-6 pr-6-desktop">
                                       
                    <!-- Judul Utama -->
                    <h1 class="title is-size-1-desktop is-size-2-touch has-text-weight-bold mb-4" style="line-height: 1.2;">
                    Sistem LMS Berbasis Cloud Multi-Tenant
                    </h1>
                    
                    <!-- Deskripsi -->
                    <p class="subtitle is-size-5 has-text-grey mb-5" style="line-height: 1.6;">
                        <strong>Cloud LMS</strong> Platform e-learning yang tangguh dan dinamis, dirancang khusus untuk memfasilitasi kebutuhan institusi modern dengan ekosistem multi-tenant terbaik.
                    </p>

                    <!-- Poin-poin Checklist -->
                    <div class="is-flex is-flex-wrap-wrap mb-6" style="gap: 1.2rem;">
                        <div class="is-flex is-align-items-center">
                            <span class="icon has-text-success mr-2"><i class="fa-regular fa-circle-check is-size-5"></i></span>
                            <span class="has-text-weight-medium is-size-6">Multi-Tenant Ekosistem</span>
                        </div>
                        <div class="is-flex is-align-items-center">
                            <span class="icon has-text-success mr-2"><i class="fa-regular fa-circle-check is-size-5"></i></span>
                            <span class="has-text-weight-medium is-size-6">Manajemen Kursus</span>
                        </div>
                        <div class="is-flex is-align-items-center">
                            <span class="icon has-text-success mr-2"><i class="fa-regular fa-circle-check is-size-5"></i></span>
                            <span class="has-text-weight-medium is-size-6">Ujian &amp; Penilaian</span>
                        </div>  
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="buttons">
                        <a href="/login" class="button is-link is-medium is-rounded px-5 has-text-weight-semibold">
                            <span class="icon is-small"><i class="fa-solid fa-arrow-right-to-bracket"></i></span>
                            <span>Login Tenant</span>
                        </a>
                        <a href="/register-institution" class="button is-success is-medium is-rounded px-5 has-text-weight-semibold">
                            <span class="icon is-small"><i class="fa-solid fa-building-circle-check"></i></span>
                            <span>Buat Tenant Baru</span>
                        </a>
                    </div>
                </div>

                <!-- MOCKUP -->
                
                <!-- KOLOM KANAN: Gambar Mockup -->
                <div class="column is-6">
                    <div style="position: relative; padding: 1rem; ">
                        <!-- Tempat Gambar Utama (Silakan ganti src dengan gambar mockup asli Anda nanti) -->
                        <figure class="image">
                            <!-- Menggunakan placeholder sementara agar bentuknya terlihat -->
                            <img src="https://toscaflow.id/uploads/image/hero.png" 
                                 alt="Mockup Sistem" 
                                 style="border-radius: 1.5rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                        </figure>

                        <!-- Elemen Mengambang (Floating Card) seperti di referensi -->
                        <div class="box is-flex is-align-items-center py-3 px-4" 
                             style="position: absolute; bottom: -10px; left: -10px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-radius: 1rem;">
                            <span class="icon is-large has-text-success has-background-success-light mr-3" style="border-radius: 50%;">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="has-text-weight-bold is-size-6 mb-0">Terpercaya & Profesional</p>
                                <p class="has-text-grey is-size-7 mb-0">Solusi IT Terpadu</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ====================================================================================================================================================== -->

<!-- TENTANG KAMI SECTION -->
<section id="tentang" class="section py-6">
    <div class="container mt-4 mb-6">
        <!-- Header Text -->
        <div class="columns is-centered">
            <div class="column is-8 has-text-centered">
                <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-3" style="letter-spacing: 0.1em;">
                    Tentang Cloud LMS
                </p>
                <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-5" style="letter-spacing: -0.02em;">
                    Membangun Ekosistem Digital Berkinerja Tinggi
                </h2>
                <!-- Menghapus has-text-grey agar subtitle otomatis menyesuaikan warna terang/gelap bawaan Bulma -->
                <p class="subtitle is-size-6" style="line-height: 1.7;">
                    Cloud LMS adalah perusahaan teknologi yang menghadirkan solusi IT terpadu. Melalui arsitektur jaringan yang solid, manajemen server yang andal, serta pemantauan proaktif dari Operation Center kami, kami memastikan infrastruktur bisnis Anda beroperasi 24/7 dengan performa maksimal.
                </p>
            </div>
        </div>

        <!-- Statistik Grid (4 Kolom) -->
        <div class="columns is-multiline is-centered mt-5">
            <!-- Stat 1 -->
            <div class="column is-3-desktop is-6-tablet">
                <div class="box has-text-centered h-100" style="border-radius: 1rem; padding: 2rem 1.5rem;">
                    <span class="icon is-large has-text-primary mb-3">
                        <i class="fa-solid fa-server fa-2x"></i>
                    </span>
                    <h3 class="title is-size-3 mb-1">99.9%</h3>
                    <p class="is-size-7 has-text-weight-medium">Server Uptime</p>
                </div>
            </div>
            
            <!-- Stat 2 -->
            <div class="column is-3-desktop is-6-tablet">
                <div class="box has-text-centered h-100" style="border-radius: 1rem; padding: 2rem 1.5rem;">
                    <span class="icon is-large has-text-primary mb-3">
                        <i class="fa-solid fa-shield-halved fa-2x"></i>
                    </span>
                    <h3 class="title is-size-3 mb-1">24/7</h3>
                    <p class="is-size-7 has-text-weight-medium">Operation Center</p>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="column is-3-desktop is-6-tablet">
                <div class="box has-text-centered h-100" style="border-radius: 1rem; padding: 2rem 1.5rem;">
                    <span class="icon is-large has-text-primary mb-3">
                        <i class="fa-solid fa-network-wired fa-2x"></i>
                    </span>
                    <h3 class="title is-size-3 mb-1">100+</h3>
                    <p class="is-size-7 has-text-weight-medium">Proyek Terintegrasi</p>
                </div>
            </div>

            <!-- Stat 4 -->
            <div class="column is-3-desktop is-6-tablet">
                <div class="box has-text-centered h-100" style="border-radius: 1rem; padding: 2rem 1.5rem;">
                    <span class="icon is-large has-text-primary mb-3">
                        <i class="fa-solid fa-handshake fa-2x"></i>
                    </span>
                    <h3 class="title is-size-3 mb-1">100%</h3>
                    <p class="is-size-7 has-text-weight-medium">Kepuasan Klien</p>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="has-text-centered mt-6">
            <a href="#kontak" class="button is-primary is-outlined is-rounded px-6 has-text-weight-semibold">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</section>

<!-- ====================================================================================================================================================== -->

<!-- PORTOFOLIO SECTION -->
<section id="portofolio" class="section py-6" style="background-color: var(--bulma-scheme-main-bis);">
    <div class="container mt-4 mb-5">
        
        <!-- Header Text -->
        <div class="has-text-centered mb-6">
            <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-2" style="letter-spacing: 0.1em;">
                Portofolio Kami
            </p>
            <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-4" style="letter-spacing: -0.02em;">
                Proyek dan Produk Digital Kami
            </h2>
            <p class="subtitle is-size-6 has-text-grey">
                Proyek dan produk digital yang telah sukses kami kembangkan untuk klien dengan standar kualitas terbaik.
            </p>
        </div>

                    
            <!-- Container Scroll Utama (Tanpa tombol absolute di sampingnya) -->
            <div class="portfolio-scroll-wrapper px-2" id="portfolioScrollWrapper">
                                    <!-- Kartu Portofolio -->
                    <div class="portfolio-card-item">
                        
                        <!-- Gambar Proyek -->
                        <div class="card-image">
                            <figure class="image is-4by3 m-0">
                                                                    <img src="https://toscaflow.id/uploads/portfolios/1777916062_c58498cd1524148962dc.png" alt="CTEFL CBT Poltekkes Yogyakarta" style="object-fit: cover; height: 100%; width: 100%;">
                                                            </figure>
                        </div>
                        
                        <!-- Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            
                            <!-- Kategori / Nama Klien (Badge) -->
                            <div class="mb-3">
                                <span class="tag badge-tosca is-rounded has-text-weight-medium px-3">
                                    Poltekkes Kemenkes Yogyakarta                                </span>
                            </div>
                            
                            <!-- Judul -->
                            <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                                CTEFL CBT Poltekkes Yogyakarta                            </h3>
                            
                            <!-- Deskripsi Singkat -->
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                                CBT CTEFL adalah platform ujian berbasis komputer yang dirancang khusus untuk standarisasi sertifikasi kemahiran bahasa Inggris secara digital dan efisien. Sistem ini mengintegrasikan metode pengujian bahasa Inggris yang komprehensif ke dalam infrastruktur web yang stabil, memungkinkan penyelenggara ujian untuk mengelola ribuan peserta secara simultan tanpa kendala teknis. Dengan fokus pada integritas data dan kemudahan penggunaan, CBT CTEFL mentransformasi metode ujian konvensional menjadi ekosistem digital yang mampu melakukan penilaian secara otomatis, akurat, dan transparan.                            </p>
                            
                            <!-- Link Lihat Detail -->
                            <div class="mt-auto pt-4" style="border-top: 1px solid var(--bulma-border-light);">
                                <a href="https://toscaflow.id/portfolio/ctefl-cbt-poltekkes-yogyakarta" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                                    <!-- Kartu Portofolio -->
                    <div class="portfolio-card-item">
                        
                        <!-- Gambar Proyek -->
                        <div class="card-image">
                            <figure class="image is-4by3 m-0">
                                                                    <img src="https://toscaflow.id/uploads/portfolios/1777916403_8531144aa3097895c040.png" alt="Tosca CMS Engine" style="object-fit: cover; height: 100%; width: 100%;">
                                                            </figure>
                        </div>
                        
                        <!-- Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            
                            <!-- Kategori / Nama Klien (Badge) -->
                            <div class="mb-3">
                                <span class="tag badge-tosca is-rounded has-text-weight-medium px-3">
                                    Cloud LMS Solution                                </span>
                            </div>
                            
                            <!-- Judul -->
                            <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                                Tosca CMS Engine                            </h3>
                            
                            <!-- Deskripsi Singkat -->
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                                Tosca CMS Engine adalah sebuah Content Management System eksklusif yang dikembangkan secara mandiri untuk menjawab kebutuhan akan platform pengelolaan konten yang ringan, cepat, dan mengutamakan keamanan data. Dibangun menggunakan framework CodeIgniter 4 dengan penerapan struktur direktori yang terisolasi, sistem ini memisahkan inti logika aplikasi (core) dari direktori publik untuk meminimalkan risiko serangan siber. Proyek ini merupakan perpaduan antara performa komputasi yang lincah dengan antarmuka pengguna yang bersih menggunakan Bulma CSS, menghasilkan halaman website yang intuitif namun tetap memiliki kapabilitas kustomisasi yang tidak terbatas.                            </p>
                            
                            <!-- Link Lihat Detail -->
                            <div class="mt-auto pt-4" style="border-top: 1px solid var(--bulma-border-light);">
                                <a href="https://toscaflow.id/portfolio/tosca-cms-engine" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                                    <!-- Kartu Portofolio -->
                    <div class="portfolio-card-item">
                        
                        <!-- Gambar Proyek -->
                        <div class="card-image">
                            <figure class="image is-4by3 m-0">
                                                                    <img src="https://toscaflow.id/uploads/portfolios/1781681792_14052dc9289940b63e9c.png" alt="Ruang Makna" style="object-fit: cover; height: 100%; width: 100%;">
                                                            </figure>
                        </div>
                        
                        <!-- Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            
                            <!-- Kategori / Nama Klien (Badge) -->
                            <div class="mb-3">
                                <span class="tag badge-tosca is-rounded has-text-weight-medium px-3">
                                    Universitas Sarjanawiyata Tamansiswa                                </span>
                            </div>
                            
                            <!-- Judul -->
                            <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                                Ruang Makna                            </h3>
                            
                            <!-- Deskripsi Singkat -->
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                                Ruang Makna adalah aplikasi mobile e-learning komprehensif yang dirancang untuk memberikan pengalaman belajar yang mulus, interaktif, dan mudah diakses. Aplikasi ini memungkinkan pengguna untuk membaca e-book (PDF), menonton video pembelajaran, dan membagikan kisah inspiratif ke komunitas. Dibangun dengan arsitektur Offline-First, aplikasi ini menjamin transisi antarmuka yang instan tanpa waktu muat (loading) berlebih, bahkan pada kondisi jaringan yang tidak stabil.                            </p>
                            
                            <!-- Link Lihat Detail -->
                            <div class="mt-auto pt-4" style="border-top: 1px solid var(--bulma-border-light);">
                                <a href="https://toscaflow.id/portfolio/ruang-makna" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                            </div>

            <!-- Tombol Navigasi Geser (Di Bawah Kartu) -->
            <div class="is-flex is-justify-content-center is-align-items-center mt-5 is-hidden-mobile" style="gap: 1rem;">
                <button id="btnScrollLeft" class="button is-primary is-light is-rounded" style="width: 50px; height: 50px;" title="Geser Kiri">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                </button>
                <button id="btnScrollRight" class="button is-primary is-rounded" style="width: 50px; height: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);" title="Geser Kanan">
                    <span class="icon"><i class="fas fa-arrow-right"></i></span>
                </button>
            </div>

            <!-- Bagian Bawah: Instruksi Geser & Tombol Lihat Semua -->
            <div class="has-text-centered mt-5 pt-5" style="border-top: 1px dashed var(--bulma-border-light);">
                <p class="is-size-7 has-text-grey mb-4 is-hidden-desktop">Geser layar untuk melihat lebih banyak <span class="has-text-primary ml-1">&bull;&bull;&bull;</span></p>
                <a href="https://toscaflow.id/portfolio" class="button is-primary is-medium is-rounded px-6 has-text-weight-semibold">
                    <span>Lihat Semua Portofolio</span>
                    <span class="icon"><i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        
    </div>
</section>

<!-- Script JavaScript (Tetap Sama Seperti Sebelumnya) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scrollWrapper = document.getElementById('portfolioScrollWrapper');
        const btnLeft = document.getElementById('btnScrollLeft');
        const btnRight = document.getElementById('btnScrollRight');

        if(scrollWrapper && btnLeft && btnRight) {
            // Menentukan jarak gulir setiap kali tombol diklik (dalam pixel)
            const scrollAmount = 350; 

            btnLeft.addEventListener('click', function() {
                scrollWrapper.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            btnRight.addEventListener('click', function() {
                scrollWrapper.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>

<!-- ====================================================================================================================================================== -->

<!-- LAYANAN SECTION -->
<section id="layanan" class="section py-6">
    <div class="container mt-4 mb-5">
        
        <!-- Header Text -->
        <div class="has-text-centered mb-6">
            <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-2" style="letter-spacing: 0.1em;">
                Layanan Kami
            </p>
            <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-4" style="letter-spacing: -0.02em;">
                Layanan Transformasi Digital Cloud LMS            </h2>
            <p class="subtitle is-size-6 has-text-grey">
                Solusi teknologi komprehensif untuk mendukung transformasi digital dan operasional bisnis Anda.
            </p>
        </div>

        <!-- Horizontal Scroll Container -->
                    <!-- Tambahkan ID 'servicesScrollWrapper' agar bisa digerakkan oleh JavaScript -->
            <div class="portfolio-scroll-wrapper px-2 pb-4" id="servicesScrollWrapper">
                                    <div class="service-card-item">
                        <!-- Kotak Ikon -->
                        <div class="icon-box has-background-primary mb-4">
                            <!-- Ganti bagian ikon di Home Anda menjadi persis seperti ini -->
                            <span class="icon is-large has-text-white" style="background: linear-gradient(135deg, var(--bulma-primary) 0%, #0093B5 100%); border-radius: 1rem; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0, 168, 150, 0.2);">
                                
                                <i class="fa-solid fa-laptop-code is-size-3"></i>

                            </span>
                        </div>
                        
                        <!-- Judul Layanan -->
                        <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                            Sistem Manajemen Pembelajaran                        </h3>
                        
                        <!-- Deskripsi Singkat -->
                        <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                            Layanan pembuatan website profesional, responsif, dan aman untuk memperkuat identitas dan presensi digital bisnis Anda.                        </p>
                        
                        <!-- Link Pelajari Lebih Lanjut -->
                        <div class="mt-auto pt-2">
                            <!-- Link ini akan mengarah ke detail layanan berdasarkan slug -->
                            <a href="https://toscaflow.id/services/jasa-pembuatan-website" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                Pelajari Lebih Lanjut 
                                <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                                    <div class="service-card-item">
                        <!-- Kotak Ikon -->
                        <div class="icon-box has-background-primary mb-4">
                            <!-- Ganti bagian ikon di Home Anda menjadi persis seperti ini -->
                            <span class="icon is-large has-text-white" style="background: linear-gradient(135deg, var(--bulma-primary) 0%, #0093B5 100%); border-radius: 1rem; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0, 168, 150, 0.2);">
                                
                                <i class="fa-solid fa-server is-size-3"></i>

                            </span>
                        </div>
                        
                        <!-- Judul Layanan -->
                        <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                            Hosting Website                        </h3>
                        
                        <!-- Deskripsi Singkat -->
                        <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                            Solusi web hosting cepat, aman, dan stabil dengan jaminan uptime tinggi untuk memastikan website bisnis Anda selalu dapat diakses 24/7.                        </p>
                        
                        <!-- Link Pelajari Lebih Lanjut -->
                        <div class="mt-auto pt-2">
                            <!-- Link ini akan mengarah ke detail layanan berdasarkan slug -->
                            <a href="https://toscaflow.id/services/hosting-website" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                Pelajari Lebih Lanjut 
                                <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                                    <div class="service-card-item">
                        <!-- Kotak Ikon -->
                        <div class="icon-box has-background-primary mb-4">
                            <!-- Ganti bagian ikon di Home Anda menjadi persis seperti ini -->
                            <span class="icon is-large has-text-white" style="background: linear-gradient(135deg, var(--bulma-primary) 0%, #0093B5 100%); border-radius: 1rem; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0, 168, 150, 0.2);">
                                
                                <i class="fa-solid fa-person-chalkboard is-size-3"></i>

                            </span>
                        </div>
                        
                        <!-- Judul Layanan -->
                        <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                            Konsultan IT                        </h3>
                        
                        <!-- Deskripsi Singkat -->
                        <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                            Konsultasi strategis IT untuk membantu bisnis Anda melakukan transformasi digital, mengoptimalkan infrastruktur, dan meminimalkan risiko teknologi.                        </p>
                        
                        <!-- Link Pelajari Lebih Lanjut -->
                        <div class="mt-auto pt-2">
                            <!-- Link ini akan mengarah ke detail layanan berdasarkan slug -->
                            <a href="https://toscaflow.id/services/konsultan-it" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                Pelajari Lebih Lanjut 
                                <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                                    <div class="service-card-item">
                        <!-- Kotak Ikon -->
                        <div class="icon-box has-background-primary mb-4">
                            <!-- Ganti bagian ikon di Home Anda menjadi persis seperti ini -->
                            <span class="icon is-large has-text-white" style="background: linear-gradient(135deg, var(--bulma-primary) 0%, #0093B5 100%); border-radius: 1rem; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0, 168, 150, 0.2);">
                                
                                <i class="fa-solid fa-screwdriver-wrench is-size-3"></i>

                            </span>
                        </div>
                        
                        <!-- Judul Layanan -->
                        <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                            Maintenance Sistem                        </h3>
                        
                        <!-- Deskripsi Singkat -->
                        <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                            Layanan pemeliharaan sistem proaktif untuk memastikan aplikasi web dan infrastruktur IT Anda senantiasa optimal, aman, dan terhindar dari downtime.                        </p>
                        
                        <!-- Link Pelajari Lebih Lanjut -->
                        <div class="mt-auto pt-2">
                            <!-- Link ini akan mengarah ke detail layanan berdasarkan slug -->
                            <a href="https://toscaflow.id/services/maintenance-sistem" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                Pelajari Lebih Lanjut 
                                <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                                    <div class="service-card-item">
                        <!-- Kotak Ikon -->
                        <div class="icon-box has-background-primary mb-4">
                            <!-- Ganti bagian ikon di Home Anda menjadi persis seperti ini -->
                            <span class="icon is-large has-text-white" style="background: linear-gradient(135deg, var(--bulma-primary) 0%, #0093B5 100%); border-radius: 1rem; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0, 168, 150, 0.2);">
                                
                                <i class="fa-solid fa-network-wired is-size-3"></i>

                            </span>
                        </div>
                        
                        <!-- Judul Layanan -->
                        <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4;">
                            Manajemen Server &amp; Infrastruktur                        </h3>
                        
                        <!-- Deskripsi Singkat -->
                        <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                            Solusi instalasi, optimasi, dan pengelolaan server secara komprehensif untuk memastikan infrastruktur IT Anda beroperasi dengan efisien, aman, dan tanpa hambatan.                        </p>
                        
                        <!-- Link Pelajari Lebih Lanjut -->
                        <div class="mt-auto pt-2">
                            <!-- Link ini akan mengarah ke detail layanan berdasarkan slug -->
                            <a href="https://toscaflow.id/services/manajemen-server-infrastruktur" class="has-text-primary has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                Pelajari Lebih Lanjut 
                                <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                            </div>

            <!-- Footer Section: Link Selengkapnya & Tombol Navigasi -->
            <div class="is-flex is-justify-content-space-between is-align-items-center mt-4 px-2">
                <a href="https://toscaflow.id/services" class="has-text-primary has-text-weight-bold is-size-6">
                    Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                </a>
                
                <!-- Tombol panah yang sudah diaktifkan -->
                <div class="is-hidden-mobile buttons mb-0">
                    <button id="btnScrollLeftServices" class="button is-rounded is-small is-primary is-light" title="Geser Kiri">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="btnScrollRightServices" class="button is-rounded is-small is-primary" title="Geser Kanan">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        
    </div>
</section>

<!-- Script JavaScript Khusus untuk Geser Layanan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceScroll = document.getElementById('servicesScrollWrapper');
        const btnLeftService = document.getElementById('btnScrollLeftServices');
        const btnRightService = document.getElementById('btnScrollRightServices');

        if(serviceScroll && btnLeftService && btnRightService) {
            // Jarak geser dalam pixel
            const scrollAmount = 350; 

            btnLeftService.addEventListener('click', function() {
                serviceScroll.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            btnRightService.addEventListener('click', function() {
                serviceScroll.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>

<!-- ====================================================================================================================================================== -->

<!-- PRODUK SECTION -->
<section id="produk" class="section py-6" style="background-color: var(--bulma-scheme-main-bis);">
    <div class="container mt-4 mb-5">
        
        <!-- Header Text -->
        <div class="has-text-centered mb-6">
            <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-2" style="letter-spacing: 0.1em;">
                Produk Kami
            </p>
            <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-4" style="letter-spacing: -0.02em;">
                Solusi Digital untuk Transformasi Bisnis
            </h2>
            <p class="subtitle is-size-6 has-text-grey">
                Produk-produk inovatif yang dirancang untuk mengoptimalkan operasional bisnis, meningkatkan produktivitas, dan memberikan pengalaman digital terbaik.
            </p>
        </div>

                    <!-- Tambahkan ID 'productScrollWrapper' -->
            <div class="portfolio-scroll-wrapper px-2 pb-4" id="productScrollWrapper">
                                    <div class="product-card-item">
                        
                        <!-- Area Gradasi Atas -->
                        <div class="product-card-top">
                            <div class="product-icon-floating">
                                <i class="fa-solid fa-id-badge"></i>
                            </div>
                            
                            <h3 class="title is-size-3 has-text-link has-text-weight-bold mb-0 is-flex is-align-items-center">
                                <span class="icon is-large mr-2"><i class="fa-solid fa-id-badge"></i></span>
                                InternFlow                            </h3>
                        </div>
                        
                        <!-- Area Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            <div class="mb-3">
                                <span class="tag is-info is-light is-rounded has-text-weight-medium px-3" style="font-size: 0.7rem;">
                                    Software as a Service (SaaS)                                </span>
                            </div>
                            
                            <h4 class="title is-size-5 mb-3 has-text-weight-bold">
                                InternFlow                            </h4>
                            
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp" style="line-height: 1.6;">
                                Sistem informasi terintegrasi untuk mendigitalisasi proses rekrutmen, pemberkasan, hingga pengarsipan data peserta magang atau PKL pada instansi dan perusahaan.                            </p>
                            
                            <!-- Checklist Fitur -->
                            <div class="mb-4 mt-auto">
                                                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Pendaftaran dan seleksi calon peserta magang secara online</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Manajemen kuota divisi dan penempatan peserta</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Sistem unggah pemberkasan (CV, Surat Kampus/Sekolah, Laporan Akhir)</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Alur persetujuan (approval) bertingkat oleh admin dan mentor</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Pencetakan sertifikat elektronik dan rekapitulasi nilai akhir</span>
                                    </div>
                                                            </div>
                            
                            <!-- Link Lihat Detail -->
                            <div class="pt-2">
                                <a href="https://toscaflow.id/products/internflow" class="has-text-link has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>

                    </div>
                                    <div class="product-card-item">
                        
                        <!-- Area Gradasi Atas -->
                        <div class="product-card-top">
                            <div class="product-icon-floating">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            
                            <h3 class="title is-size-3 has-text-link has-text-weight-bold mb-0 is-flex is-align-items-center">
                                <span class="icon is-large mr-2"><i class="fa-solid fa-boxes-stacked"></i></span>
                                ToscaStock                            </h3>
                        </div>
                        
                        <!-- Area Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            <div class="mb-3">
                                <span class="tag is-info is-light is-rounded has-text-weight-medium px-3" style="font-size: 0.7rem;">
                                    Software as a Service (SaaS)                                </span>
                            </div>
                            
                            <h4 class="title is-size-5 mb-3 has-text-weight-bold">
                                ToscaStock                            </h4>
                            
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp" style="line-height: 1.6;">
                                Perangkat lunak manajemen inventaris cerdas berbasis web yang dirancang untuk mengoptimalkan perputaran stok barang dengan metode First-In First-Out (FIFO) yang akurat.                            </p>
                            
                            <!-- Checklist Fitur -->
                            <div class="mb-4 mt-auto">
                                                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Pencatatan mutasi barang masuk dan keluar secara real-time</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Penerapan otomatis algoritma antrean stok FIFO</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Peringatan batas minimum stok (Low Stock Alert)</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Pembuatan barcode/QR code untuk pelacakan fisik barang</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Laporan valuasi aset dan riwayat transaksi harian</span>
                                    </div>
                                                            </div>
                            
                            <!-- Link Lihat Detail -->
                            <div class="pt-2">
                                <a href="https://toscaflow.id/products/toscastock" class="has-text-link has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>

                    </div>
                                    <div class="product-card-item">
                        
                        <!-- Area Gradasi Atas -->
                        <div class="product-card-top">
                            <div class="product-icon-floating">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            
                            <h3 class="title is-size-3 has-text-link has-text-weight-bold mb-0 is-flex is-align-items-center">
                                <span class="icon is-large mr-2"><i class="fa-solid fa-shield-halved"></i></span>
                                Tosca CMS Engine                            </h3>
                        </div>
                        
                        <!-- Area Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            <div class="mb-3">
                                <span class="tag is-info is-light is-rounded has-text-weight-medium px-3" style="font-size: 0.7rem;">
                                    Software as a Service (SaaS)                                </span>
                            </div>
                            
                            <h4 class="title is-size-5 mb-3 has-text-weight-bold">
                                Tosca CMS Engine                            </h4>
                            
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp" style="line-height: 1.6;">
                                Mesin pengelola konten website (CMS) eksklusif berkinerja tinggi yang dirancang khusus dengan arsitektur keamanan tingkat lanjut untuk perusahaan dan instansi pemerintah.                            </p>
                            
                            <!-- Checklist Fitur -->
                            <div class="mb-4 mt-auto">
                                                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Arsitektur sistem terisolasi untuk mencegah serangan siber</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Antarmuka panel admin yang intuitif, ringan, dan responsif</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Manajemen modul dinamis (Portofolio, Layanan, Artikel)</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Sistem routing URL yang ramah mesin pencari (SEO Optimized)</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Kustomisasi penuh tanpa bloatware (fitur tidak penting) seperti pada CMS instan</span>
                                    </div>
                                                            </div>
                            
                            <!-- Link Lihat Detail -->
                            <div class="pt-2">
                                <a href="https://toscaflow.id/products/tosca-cms-engine" class="has-text-link has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>

                    </div>
                                    <div class="product-card-item">
                        
                        <!-- Area Gradasi Atas -->
                        <div class="product-card-top">
                            <div class="product-icon-floating">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            
                            <h3 class="title is-size-3 has-text-link has-text-weight-bold mb-0 is-flex is-align-items-center">
                                <span class="icon is-large mr-2"><i class="fa-solid fa-location-dot"></i></span>
                                PressApp                            </h3>
                        </div>
                        
                        <!-- Area Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            <div class="mb-3">
                                <span class="tag is-info is-light is-rounded has-text-weight-medium px-3" style="font-size: 0.7rem;">
                                    Software as a Service (SaaS)                                </span>
                            </div>
                            
                            <h4 class="title is-size-5 mb-3 has-text-weight-bold">
                                PressApp                            </h4>
                            
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp" style="line-height: 1.6;">
                                PressApp adalah solusi digital modern untuk manajemen absensi dan pemantauan kehadiran karyawan perusahaan Anda. Dirancang untuk fleksibilitas dan akurasi tinggi, aplikasi ini memungkinkan pencatatan waktu kerja yang presisi, baik untuk pegawai yang bekerja di kantor (WFO), di lapangan, maupun dari jarak jauh (WFH). Mengandalkan teknologi geolokasi yang aman, PressApp secara otomatis mengelola rekapitulasi data kehadiran harian, meminimalkan risiko kecurangan, serta menyederhanakan tugas administrasi divisi HR. Tinggalkan sistem absensi manual yang tidak efisien dan beralihlah ke ekosistem terintegrasi yang dirancang khusus untuk mendorong kedisiplinan dan produktivitas tim Anda.                            </p>
                            
                            <!-- Checklist Fitur -->
                            <div class="mb-4 mt-auto">
                                                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Absensi masuk dan keluar berbasis geolokasi (GPS) dengan batas radius yang dapat disesuaikan</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Sistem pengajuan dan persetujuan (approval) cuti, izin, serta sakit secara mandiri melalui aplikasi</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Pemantauan jam kerja, lembur, dan keterlambatan secara otomatis</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Dashboard analitik komprehensif bagi HRD untuk memantau tren kehadiran secara keseluruhan</span>
                                    </div>
                                                                    <div class="is-flex is-align-items-center mb-2">
                                        <span class="icon has-text-success is-small mr-2"><i class="fa-regular fa-circle-check"></i></span>
                                        <span class="is-size-7 has-text-weight-medium">Ekspor laporan kehadiran harian dan bulanan yang kompatibel untuk kebutuhan penggajian (Payroll)</span>
                                    </div>
                                                            </div>
                            
                            <!-- Link Lihat Detail -->
                            <div class="pt-2">
                                <a href="https://toscaflow.id/products/pressapp" class="has-text-link has-text-weight-semibold is-size-7 is-flex is-align-items-center">
                                    Lihat Detail 
                                    <span class="icon is-small ml-2"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>

                    </div>
                            </div>

            <!-- Footer Section: Link Selengkapnya & Tombol Navigasi -->
            <div class="is-flex is-justify-content-space-between is-align-items-center mt-4 px-2">
                <a href="https://toscaflow.id/products" class="has-text-link has-text-weight-bold is-size-6">
                    Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                </a>
                
                <!-- Tombol Navigasi Aktif -->
                <div class="is-hidden-mobile buttons mb-0">
                    <button id="btnScrollLeftProducts" class="button is-rounded is-small is-link is-light" title="Geser Kiri">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="btnScrollRightProducts" class="button is-rounded is-small is-link" title="Geser Kanan">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        
    </div>
</section>

<!-- Script JavaScript Khusus untuk Geser Produk -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productScroll = document.getElementById('productScrollWrapper');
        const btnLeftProduct = document.getElementById('btnScrollLeftProducts');
        const btnRightProduct = document.getElementById('btnScrollRightProducts');

        if(productScroll && btnLeftProduct && btnRightProduct) {
            // Jarak geser dalam pixel
            const scrollAmount = 350; 

            btnLeftProduct.addEventListener('click', function() {
                productScroll.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });

            btnRightProduct.addEventListener('click', function() {
                productScroll.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>

<!-- ====================================================================================================================================================== -->

<!-- TEKNOLOGI SECTION -->
<section id="teknologi" class="section py-6">
    <div class="container mt-4 mb-5">
        
        <!-- Header Text -->
        <div class="has-text-centered mb-6">
            <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-2" style="letter-spacing: 0.1em;">
                Teknologi Kami
            </p>
            <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-4" style="letter-spacing: -0.02em;">
                Teknologi Terkini yang Kami Gunakan
            </h2>
            <p class="subtitle is-size-6 has-text-grey" style="max-width: 700px; margin: 0 auto;">
                Kami senantiasa mengaplikasikan teknologi terkini untuk menciptakan sistem yang efektif, aman, dan berkinerja tinggi sesuai standar industri.
            </p>
        </div>

        <!-- Tech Grid Berjajar Tengah -->
        <div class="is-flex is-flex-wrap-wrap is-justify-content-center mt-6" style="gap: 1rem;">
            
            <div class="tech-item">
                <div class="tech-box bg-php">
                    <i class="devicon-php-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">PHP</span>
            </div>

            <div class="tech-item">
                <div class="tech-box bg-mysql">
                    <i class="devicon-mysql-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">MySQL</span>
            </div>

            <div class="tech-item">
                <div class="tech-box bg-ci">
                    <i class="devicon-codeigniter-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">CodeIgniter</span>
            </div>

            <div class="tech-item">
                <div class="tech-box bg-html">
                    <i class="devicon-html5-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">HTML5</span>
            </div>

            <div class="tech-item">
                <div class="tech-box bg-python">
                    <i class="devicon-python-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">Python</span>
            </div>

            <div class="tech-item">
                <div class="tech-box bg-dotnet">
                    <i class="devicon-dot-net-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">.NET</span>
            </div>

            <div class="tech-item">
                <div class="tech-box bg-linux">
                    <i class="devicon-linux-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">Linux</span>
            </div>
            
            <div class="tech-item">
                <div class="tech-box bg-cloudflare">
                    <i class="devicon-cloudflare-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">Cloudflare</span>
            </div>
            
            <div class="tech-item">
                <div class="tech-box bg-nginx">
                    <i class="devicon-nginx-original"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">Nginx</span>
            </div>
            
            <div class="tech-item">
                <div class="tech-box bg-apache">
                    <i class="devicon-apache-plain"></i>
                </div>
                <span class="is-size-7 has-text-weight-bold has-text-grey">Apache</span>
            </div>

        </div>

        <!-- Footer Text -->
        <div class="has-text-centered mt-5">
            <p class="is-size-7 has-text-grey">Dan berbagai teknologi server serta jaringan lainnya yang kami kuasai untuk operasional IT Anda.</p>
        </div>

    </div>
</section>

<!-- ====================================================================================================================================================== -->

<!-- KLIEN SECTION -->
<section id="klien" class="section py-6" style="background-color: var(--bulma-scheme-main-bis);">
    <div class="container mt-4 mb-5">
        
        <!-- Header Text -->
        <div class="has-text-centered mb-6">
            <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-2" style="letter-spacing: 0.1em;">
                Partner Terpercaya
            </p>
            <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-4" style="letter-spacing: -0.02em;">
                Dipercaya oleh Institusi Terkemuka
            </h2>
            <p class="subtitle is-size-6 has-text-grey" style="max-width: 700px; margin: 0 auto;">
                Melayani sektor pendidikan dan pemerintahan dengan solusi teknologi dan operasional infrastruktur terbaik.
            </p>
        </div>

        <!-- Grid Klien -->
        <div class="columns is-multiline is-centered mt-5">
            
            <!-- Klien 1: Poltekkes Kemenkes Yogyakarta -->
            <div class="column is-4-desktop is-6-tablet">
                <div class="client-card">
                    <img src="https://poltekkesjogja.ac.id/assets/img/logo%20polkesyo.svg" 
                         alt="Poltekkes Kemenkes Yogyakarta" 
                         class="client-logo"
                         onerror="this.onerror=null; this.src='https://placehold.co/300x150/ffffff/00a896?text=Poltekkes+Jogja';">
                </div>
            </div>

            <!-- Klien 2: Universitas Muhammadiyah Yogyakarta (UMY) -->
            <div class="column is-4-desktop is-6-tablet">
                <div class="client-card">
                    <img src="https://www.umy.ac.id/wp-content/uploads/2025/01/Logo-UMY-header-1024x162.png" 
                         alt="UMY" 
                         class="client-logo"
                         onerror="this.onerror=null; this.src='https://placehold.co/300x150/ffffff/00a896?text=UMY';">
                </div>
            </div>
            
            <!-- Klien 3: BalaiUST -->
            <div class="column is-4-desktop is-6-tablet">
                <div class="client-card">
                    <img src="https://toscaflow.id/uploads/image/ust_logo_20.png" 
                         alt="Universitas Sarjanawiyata Tamansiswa (UST)" 
                         class="client-logo"
                         onerror="this.onerror=null; this.src='https://placehold.co/300x150/ffffff/00a896?text=Universitas +Sarjanawiyata+Tamansiswa';">
                </div>
            </div>

            <!-- Klien 3: Balai Tekkomdik DIY -->
            <div class="column is-4-desktop is-6-tablet">
                <div class="client-card">
                    <img src="https://btkp-diy.or.id/file/tampilan/logo.png" 
                         alt="Balai Tekkomdik DIY" 
                         class="client-logo"
                         onerror="this.onerror=null; this.src='https://placehold.co/300x150/ffffff/00a896?text=Balai+Tekkomdik+DIY';">
                </div>
            </div>

             <!-- Klien 4: YSI-->
             <div class="column is-4-desktop is-6-tablet">
                <div class="client-card">
                    <img src="https://sagasitas.org/tmp/2015/10/cropped-sagasitas.png" 
                         alt="Yayasan Sagasitas Indonesia" 
                         class="client-logo"
                         onerror="this.onerror=null; this.src='https://placehold.co/300x150/ffffff/00a896?text=Balai+Tekkomdik+DIY';">
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ====================================================================================================================================================== -->

<!-- ARTIKEL SECTION -->
<section id="artikel" class="section py-6" >
    <div class="container mt-4 mb-5">
        
        <!-- Header Text -->
        <div class="has-text-centered mb-6">
            <p class="has-text-weight-bold has-text-primary is-size-7 is-uppercase mb-2" style="letter-spacing: 0.1em;">
                Artikel Terbaru
            </p>
            <h2 class="title is-size-2-desktop is-size-3-touch has-text-weight-bold mb-4" style="letter-spacing: -0.02em;">
                Wawasan & Berita Terkini
            </h2>
            <p class="subtitle is-size-6 has-text-grey">
                Dapatkan insight terbaru seputar teknologi, inovasi, dan tren industri digital.
            </p>
        </div>

                    <div class="portfolio-scroll-wrapper px-2 pb-4">
                                    <div class="article-card-item">
                        
                        <!-- Gambar & Badge -->
                        <div class="article-img-wrapper">
                            <!-- Badge Kategori -->
                            <span class="article-badge">TECHNOLOGY</span>
                            
                            <!-- Menggunakan $row->thumbnail sesuai database -->
                                                            <img src="https://toscaflow.id/uploads/articles/1784878527_5ae2b5f3e6402a69ac5e.jpg" alt="Perkuat Efektivitas Pembelajaran Digital, Cloud LMS Isi Workshop Media Digital di Poltekkes Kemenkes Yogyakarta">
                                                    </div>

                        <!-- Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            
                            <!-- Meta Data -->
                            <div class="article-meta">
                                <span><i class="fa-regular fa-user"></i> Super Admin</span>
                                <span><i class="fa-regular fa-calendar"></i> 24 Jul 2026</span>
                                <span><i class="fa-regular fa-eye"></i> 0 views</span>
                            </div>

                            <!-- Judul Artikel (Otomatis terpotong 2 baris jika kepanjangan) -->
                            <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <a href="https://toscaflow.id/blog/perkuat-efektivitas-pembelajaran-digital-toscaflow-isi-workshop-media-digital-di-poltekkes-kemenkes-yogyakarta" style="color: inherit;">
                                    Perkuat Efektivitas Pembelajaran Digital, Cloud LMS Isi Workshop Media Digital di Poltekkes Kemenkes Yogyakarta                                </a>
                            </h3>

                            <!-- Cuplikan Isi (Menggunakan fungsi bawaan PHP strip_tags agar kode HTML tidak ikut tampil) -->
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                                YOGYAKARTA, 24 Juli 2026 – Cloud LMS kembali menunjukkan komitmennya dalam mendukung digitalisasi di dunia pendidikan tinggi. Bertempat di Ruang Nawasena, Gedung G Poltekkes Kemenkes Yogyakarta, Head of Operation Center Cloud LMS, Farras Daffa Yassarramadhan, hadir sebagai narasumber utama dalam Workshop Pembuatan Video Pembelajaran bagi Tenaga Pendidik dan Kependidikan di Bidang Kesehatan.&amp;nbsp;&amp;nbsp;​Kegiatan intensif yang berlangsung selama tiga hari, mulai tanggal 22 hingga 24 Juli 2026 ini, ditujukan untuk membekali para dosen dan tenaga kependidikan dengan keterampilan teknis produksi media pembelajaran audiovisual yang interaktif dan informatif.&amp;nbsp;&amp;nbsp;​Selama lokakarya berlangsung, materi yang disampaikan mencakup berbagai tahapan krusial dalam pembuatan konten digital:&amp;nbsp;&amp;nbsp;​Perancangan Konsep &amp;amp; Alur Cerita: Teknik penulisan naskah video pembelajaran serta optimasi pengambilan gambar menggunakan smartphone.&amp;nbsp;&amp;nbsp;​Pemanfaatan Teknologi AI: Praktik langsung (hands-on) penyuntingan dan pembuatan video pembelajaran secara efisien memanfaatkan alat berbasis AI seperti Google Vids dan NotebookLM.&amp;nbsp;&amp;nbsp;​Praktik Mandiri &amp;amp; Reviu: Pendampingan pembuatan karya secara intensif hingga sesi presentasi dan evaluasi hasil video.&amp;nbsp;&amp;nbsp;​Melalui pelatihan ini, para peserta tidak hanya memahami aspek teknis video editing, tetapi juga mampu memanfaatkan integrasi kecerdasan buatan (Artificial Intelligence) untuk mempercepat serta meningkatkan kualitas materi ajar digital di bidang kesehatan.&amp;nbsp;&amp;nbsp;​Sebagai penyedia solusi teknologi dan transformasi digital, Cloud LMS terus berupaya memberikan kontribusi nyata dalam memperkuat kapabilitas media digital di berbagai sektor, termasuk instansi pemerintah dan lembaga pendidikan tinggi.                            </p>
                            
                        </div>
                    </div>
                                    <div class="article-card-item">
                        
                        <!-- Gambar & Badge -->
                        <div class="article-img-wrapper">
                            <!-- Badge Kategori -->
                            <span class="article-badge">TECHNOLOGY</span>
                            
                            <!-- Menggunakan $row->thumbnail sesuai database -->
                                                            <img src="https://toscaflow.id/uploads/articles/1781826825_0cdc726939a6f8b97e0f.jpg" alt="Sinergi Cloud LMS dan BTKP DIY Wujudkan Digitalisasi Pendidikan Melalui Mobile Learning Service di SMKN 1 Ponjong">
                                                    </div>

                        <!-- Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            
                            <!-- Meta Data -->
                            <div class="article-meta">
                                <span><i class="fa-regular fa-user"></i> Super Admin</span>
                                <span><i class="fa-regular fa-calendar"></i> 18 Jun 2026</span>
                                <span><i class="fa-regular fa-eye"></i> 0 views</span>
                            </div>

                            <!-- Judul Artikel (Otomatis terpotong 2 baris jika kepanjangan) -->
                            <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <a href="https://toscaflow.id/blog/sinergi-toscaflow-dan-btkp-diy-wujudkan-digitalisasi-pendidikan-melalui-mobile-learning-service-di-smkn-1-ponjong" style="color: inherit;">
                                    Sinergi Cloud LMS dan BTKP DIY Wujudkan Digitalisasi Pendidikan Melalui Mobile Learning Service di SMKN 1 Ponjong                                </a>
                            </h3>

                            <!-- Cuplikan Isi (Menggunakan fungsi bawaan PHP strip_tags agar kode HTML tidak ikut tampil) -->
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                                PONJONG, GUNUNGKIDUL – Dalam upaya mengakselerasi transformasi digital dan meningkatkan kompetensi tenaga pendidik, Balai Teknologi Komunikasi Pendidikan (BTKP) Daerah Istimewa Yogyakarta kembali menggandeng Cloud LMS dalam program inovatif bertajuk Mobile Learning Service (MLS). Kegiatan pelatihan komprehensif ini sukses diselenggarakan di SMKN 1 Ponjong pada hari Kamis (18/06/2026).Acara pelatihan ini diikuti dengan antusias oleh jajaran guru SMKN 1 Ponjong dan dibuka secara resmi oleh Kepala Sekolah, Ibu Nurwastuti Setyowati, S.Pd.I. Dalam sambutannya, beliau menekankan pentingnya adaptasi pendidik terhadap perkembangan teknologi informasi guna menciptakan ekosistem pembelajaran yang lebih interaktif, efektif, dan relevan dengan generasi pelajar saat ini.Menguasai Ekosistem Digital: Microsite Edukatif dan WaygroundMateri pelatihan kali ini difokuskan pada pembekalan keterampilan teknis yang dapat langsung diaplikasikan oleh para guru dalam menunjang kegiatan belajar mengajar (KBM). Terdapat dua fokus utama yang diusung dalam kegiatan ini:1. Pembuatan Microsite Edukatif menggunakan s.id
Para guru dibimbing secara langsung untuk membuat landing page atau microsite pendidikan yang ringkas namun fungsional. Menggunakan platform s.id, para guru dilatih untuk menyusun portal informasi kelas, merangkum materi mata pelajaran, hingga memusatkan berbagai tautan penting dalam satu halaman yang mudah diakses oleh siswa melalui perangkat seluler mereka.2. Pembelajaran Interaktif Menggunakan Wayground
Selain pembuatan portal informasi kelas, pelatihan ini juga mengenalkan pemanfaatan Wayground sebagai media pembelajaran digital. Platform ini memungkinkan para pendidik untuk merancang skenario pembelajaran yang lebih dinamis dan dua arah. Dengan Wayground, interaksi antara pendidik dan siswa dapat terjalin dengan lebih optimal melalui ruang digital yang atraktif.Dukungan Teknis Penuh dari Cloud LMSSebagai mitra penyedia layanan IT dan infrastruktur digital, kehadiran tim Cloud LMS dalam kegiatan ini berperan krusial dalam memastikan kelancaran praktik. Cloud LMS mendampingi langsung para guru SMKN 1 Ponjong selama proses pembuatan microsite hingga eksplorasi fitur-fitur pembelajaran di platform Wayground.Kolaborasi berkelanjutan antara BTKP DIY dan Cloud LMS ini membuktikan komitmen nyata dalam memajukan kualitas pendidikan vokasi di Daerah Istimewa Yogyakarta. Melalui penguasaan teknologi microsite dan Wayground, diharapkan guru-guru SMKN 1 Ponjong dapat terus berinovasi dan menghadirkan pengalaman belajar yang tak terbatas oleh ruang dan waktu.                            </p>
                            
                        </div>
                    </div>
                                    <div class="article-card-item">
                        
                        <!-- Gambar & Badge -->
                        <div class="article-img-wrapper">
                            <!-- Badge Kategori -->
                            <span class="article-badge">TECHNOLOGY</span>
                            
                            <!-- Menggunakan $row->thumbnail sesuai database -->
                                                            <img src="https://toscaflow.id/uploads/articles/1781826444_3dd6a2390beaee7bd1a2.jpg" alt="Kolaborasi BTKP DIY dan Cloud LMS: Gelar Pelatihan Pembuatan Microsite Terintegrasi di UNU Yogyakarta">
                                                    </div>

                        <!-- Konten Bawah -->
                        <div class="p-5 is-flex is-flex-direction-column is-flex-grow-1">
                            
                            <!-- Meta Data -->
                            <div class="article-meta">
                                <span><i class="fa-regular fa-user"></i> Super Admin</span>
                                <span><i class="fa-regular fa-calendar"></i> 18 Jun 2026</span>
                                <span><i class="fa-regular fa-eye"></i> 0 views</span>
                            </div>

                            <!-- Judul Artikel (Otomatis terpotong 2 baris jika kepanjangan) -->
                            <h3 class="title is-size-5 mb-3 has-text-weight-bold" style="line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <a href="https://toscaflow.id/blog/kolaborasi-btkp-diy-dan-toscaflow-gelar-pelatihan-pembuatan-microsite-terintegrasi-di-unu-yogyakarta" style="color: inherit;">
                                    Kolaborasi BTKP DIY dan Cloud LMS: Gelar Pelatihan Pembuatan Microsite Terintegrasi di UNU Yogyakarta                                </a>
                            </h3>

                            <!-- Cuplikan Isi (Menggunakan fungsi bawaan PHP strip_tags agar kode HTML tidak ikut tampil) -->
                            <p class="is-size-7 has-text-grey mb-4 portfolio-desc-clamp is-flex-grow-1" style="line-height: 1.6;">
                                YOGYAKARTA – Dalam upaya mendorong literasi digital dan keterampilan praktis mahasiswa di era teknologi, Balai Teknologi Komunikasi Pendidikan (BTKP) Daerah Istimewa Yogyakarta bersinergi dengan Cloud LMS menyelenggarakan kegiatan pengimbasan dan workshop teknologi web pada Jumat (12/06/2026). Kegiatan yang berlangsung di kampus Universitas Nahdlatul Ulama (UNU) Yogyakarta ini disambut dengan antusiasme tinggi oleh puluhan mahasiswa yang hadir.Acara ini secara resmi dibuka oleh Kepala Program Studi Informatika UNU Yogyakarta, Bapak Yana Hendriana, S.T., M.Eng. Dalam sambutannya, beliau menekankan pentingnya pembekalan hardskill yang relevan dengan kebutuhan industri saat ini, khususnya dalam mengelola identitas digital dan pembuatan halaman web yang efisien.Sesi materi utama dipandu langsung oleh Bapak Oki Pambudi, M.Pd., selaku Staff Pengembang Teknologi Pembelajaran dari BTKP DIY. Beliau membawakan materi teknis yang sangat aplikatif, yaitu strategi pembuatan microsite menggunakan platform s.id yang kemudian diintegrasikan secara profesional menggunakan layanan domain dari Exabytes.Praktik pengintegrasian ini menjadi fokus utama kegiatan, di mana audiens diajarkan cara melakukan konfigurasi Name Server (NS) pada domain Exabytes agar dapat terhubung atau &quot;ditempelkan&quot; langsung ke ekosistem microsite s.id. Teknik ini memungkinkan pengguna untuk memiliki halaman pendaratan (landing page) yang ringan, fungsional, dan tetap menggunakan nama domain kustom yang terlihat profesional.Guna memastikan materi dapat diserap dan dipraktikkan langsung tanpa kendala teknis, tim Cloud LMS hadir secara penuh sebagai pendamping kegiatan. Kehadiran perwakilan Cloud LMS di tengah-tengah mahasiswa memastikan setiap langkah konfigurasi—mulai dari pointing domain hingga penyesuaian DNS—berjalan lancar dan presisi.Keterlibatan Cloud LMS dalam acara ini merupakan bentuk komitmen berkelanjutan dari kami selaku penyedia jasa solusi IT terintegrasi, untuk tidak hanya melayani sektor korporat, tetapi juga berkontribusi aktif dalam mencetak talenta-talenta digital muda yang kompeten dari bangku perkuliahan.Melalui sinergi antara BTKP DIY, akademisi UNU Yogyakarta, dan praktisi dari Cloud LMS, diharapkan para mahasiswa dapat mengimplementasikan ilmu pembuatan microsite ini untuk berbagai kebutuhan, mulai dari portofolio pribadi, inkubasi bisnis mahasiswa, hingga proyek-proyek digital di masa depan.                            </p>
                            
                        </div>
                    </div>
                            </div>

            <!-- Footer Section: Link Selengkapnya -->
            <div class="is-flex is-justify-content-space-between is-align-items-center mt-4 px-2">
                <a href="https://toscaflow.id/blog" class="has-text-primary has-text-weight-bold is-size-6">
                    Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                </a>
                
                <div class="is-hidden-mobile buttons mb-0">
                    <button class="button is-rounded is-small is-outlined" style="border-color: var(--bulma-border-light);" disabled><i class="fas fa-chevron-left has-text-grey-light"></i></button>
                    <button class="button is-rounded is-small is-outlined" style="border-color: var(--bulma-border-light);" disabled><i class="fas fa-chevron-right has-text-grey-light"></i></button>
                </div>
            </div>
        
    </div>
</section>


<!-- END ALL SECTION -->


    <!-- FOOTER (MEGA MENU STYLE) -->
    <footer class="footer pb-5 pt-6 mt-6 border-top">
        <div class="container">
            <div class="columns is-multiline">
                
                <!-- Kolom 1: Info Perusahaan -->
                <div class="column is-4 pr-5">
                    <div class="mb-4">
                                                    <img src="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png" alt="Cloud LMS" 
                                 class="dynamic-logo"
                                 data-light="https://toscaflow.id/uploads/logo/1777701079_46ba47bebcd16f265c44.png" 
                                 data-dark="https://toscaflow.id/uploads/logo/1777701228_2955d0d783fe7b984d40.png" 
                                 style="max-height: 2.5rem;">
                                            </div>
                    
                    <p class="mb-5 is-size-6 has-text-grey">
                        Cloud LMS adalah penyedia layanan dan solusi IT terpercaya.                    </p>

                    <div class="content is-size-6 mb-5">
                        <p class="mb-2">
                            <span class="icon has-text-primary mr-2"><i class="fa-regular fa-envelope"></i></span>
                            <a href="mailto:info@toscaflow.id" class="has-text-grey">info@toscaflow.id</a>
                        </p>
                        <p class="mb-2">
                            <span class="icon has-text-primary mr-2"><i class="fa-solid fa-phone"></i></span>
                            <a href="https://wa.me/62881081771717" class="has-text-grey">62881081771717</a>
                        </p>
                        <p class="mb-2 is-flex">
                            <span class="icon has-text-primary mr-2"><i class="fa-solid fa-location-dot"></i></span>
                            <span class="has-text-grey">K.M 7, Jl. Bantul No.5, Sawahan, Pendowoharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184</span>
                        </p>
                    </div>

                    <div class="buttons">
                        <a href="#" class="button is-small is-rounded"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://instagram.com/toscaflow" class="button is-small is-rounded"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="button is-small is-rounded"><i class="fa-brands fa-twitter"></i></a>
                    </div>
                </div>

                <div class="column is-1"></div> <!-- Spacer -->

                <!-- Kolom 2: Company -->
                <div class="column is-2">
                    <h4 class="title is-6 mb-4">Company</h4>
                    <ul class="footer-list">
                        <li><a href="https://toscaflow.id/about" class="has-text-grey">Tentang Kami</a></li>
                        <li><a href="https://toscaflow.id/portfolio" class="has-text-grey">Portofolio</a></li>
                        <li><a href="https://toscaflow.id/contact" class="has-text-grey">Kontak</a></li>
                        <li><a href="https://toscaflow.id/faq" class="has-text-grey">FAQ</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Services -->
                <!-- Bagian Layanan di Footer -->
                <div class="column is-3-desktop is-6-tablet mb-4">
                    <h4 class="title is-5 mb-4 has-text-weight-bold" style="color: inherit;">Layanan Kami</h4>
                    <ul style="list-style: none; margin-left: 0; padding-left: 0;">
                                                
                                                                                    <li class="mb-2">
                                    <a href="https://toscaflow.id/services/jasa-pembuatan-website" class="has-text-grey" style="transition: color 0.3s ease;" onmouseover="this.classList.add('has-text-primary');" onmouseout="this.classList.remove('has-text-primary');">
                                        Sistem Manajemen Pembelajaran                                    </a>
                                </li>
                                                            <li class="mb-2">
                                    <a href="https://toscaflow.id/services/hosting-website" class="has-text-grey" style="transition: color 0.3s ease;" onmouseover="this.classList.add('has-text-primary');" onmouseout="this.classList.remove('has-text-primary');">
                                        Hosting Website                                    </a>
                                </li>
                                                            <li class="mb-2">
                                    <a href="https://toscaflow.id/services/konsultan-it" class="has-text-grey" style="transition: color 0.3s ease;" onmouseover="this.classList.add('has-text-primary');" onmouseout="this.classList.remove('has-text-primary');">
                                        Konsultan IT                                    </a>
                                </li>
                                                            <li class="mb-2">
                                    <a href="https://toscaflow.id/services/maintenance-sistem" class="has-text-grey" style="transition: color 0.3s ease;" onmouseover="this.classList.add('has-text-primary');" onmouseout="this.classList.remove('has-text-primary');">
                                        Maintenance Sistem                                    </a>
                                </li>
                                                            <li class="mb-2">
                                    <a href="https://toscaflow.id/services/manajemen-server-infrastruktur" class="has-text-grey" style="transition: color 0.3s ease;" onmouseover="this.classList.add('has-text-primary');" onmouseout="this.classList.remove('has-text-primary');">
                                        Manajemen Server &amp; Infrastruktur                                    </a>
                                </li>
                                                                        </ul>
                </div>

                <!-- Kolom 4: Information -->
                <div class="column is-2">
                    <h4 class="title is-6 mb-4">Information</h4>
                    <ul class="footer-list">
                        <li><a href="https://toscaflow.id/blog" class="has-text-grey">Artikel & Berita</a></li>
                        <li><a href="https://toscaflow.id/privacy-policy" class="has-text-grey">Kebijakan Privasi</a></li>
                        <li><a href="https://toscaflow.id/terms" class="has-text-grey">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

            </div>

            <!-- Copyright Bottom Bar -->
            <hr class="mt-5 mb-4">
            <div class="level is-size-7 has-text-grey">
                <div class="level-left">
                    <p>&copy; 2026 <strong>Cloud LMS Solution</strong>. All rights reserved.</p>
                </div>
                <div class="level-right">
                    <a href="https://toscaflow.id/privacy-policy" class="has-text-grey">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPT UTAMA FRONTEND -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Navbar Burger Menu (Mobile)
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            if ($navbarBurgers.length > 0) {
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }

            // 2. Logic Dark/Light Mode & Tukar Logo
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const htmlElement = document.documentElement;
            const dynamicLogos = document.querySelectorAll('.dynamic-logo'); // Ambil semua logo di Navbar & Footer
            
            // Cek preferensi user di LocalStorage
            const currentTheme = localStorage.getItem('frontend_theme') || 'light';

            const updateThemeUI = (theme) => {
                if(theme === 'dark') {
                    htmlElement.setAttribute('data-theme', 'dark');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                    // Ganti semua src logo menjadi logo dark
                    dynamicLogos.forEach(logo => {
                        if(logo.getAttribute('data-dark')) logo.src = logo.getAttribute('data-dark');
                    });
                } else {
                    htmlElement.setAttribute('data-theme', 'light');
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                    // Ganti semua src logo menjadi logo light
                    dynamicLogos.forEach(logo => {
                        if(logo.getAttribute('data-light')) logo.src = logo.getAttribute('data-light');
                    });
                }
            };

            // Terapkan saat halaman dimuat
            updateThemeUI(currentTheme);

            // Aksi saat tombol ditekan
            if(themeToggle) {
                themeToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    let newTheme = htmlElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
                    localStorage.setItem('frontend_theme', newTheme);
                    updateThemeUI(newTheme);
                });
            }
        });
    </script>

</script>
</body>
</html>
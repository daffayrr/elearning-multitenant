<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, var(--primary-navy) 0%, #1a2a40 100%);">
            <div class="card-body p-4 p-md-5 position-relative text-white">
                <div class="row align-items-center relative z-1">
                    <div class="col-md-8">
                        <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-2 rounded-pill fw-normal">Instructor Portal</span>
                        <h2 class="fw-bold mb-2">Halo, <?= session('name') ?> 👋</h2>
                        <p class="lead opacity-75 mb-4">Selamat datang kembali di LMS! Kelola kelas, nilai siswa, dan CBT Anda dengan mudah hari ini.</p>
                        
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/<?= $tenantStringId ?>/instructor/courses" class="btn btn-light rounded-pill px-4 fw-bold text-navy shadow-sm">
                                <i class="fa-solid fa-plus me-1"></i> Buat Kelas Baru
                            </a>
                            <a href="/<?= $tenantStringId ?>/instructor/quiz-banks" class="btn btn-outline-light rounded-pill px-4 fw-bold shadow-sm">
                                <i class="fa-solid fa-database me-1"></i> Kelola Bank Soal
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block text-end">
                        <i class="fa-solid fa-chalkboard-user fa-8x text-white opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-chart-pie me-2 text-primary"></i> Ringkasan Aktivitas</h5>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="fa-solid fa-book-open fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Total Kelas</h6>
                <h3 class="fw-bold text-dark mb-0"><?= esc($total_courses) ?></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= $tenantStringId ?>/instructor/courses" class="text-decoration-none text-primary fw-bold small">
                    Kelola Kelas <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="fa-solid fa-users fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Total Peserta</h6>
                <h3 class="fw-bold text-dark mb-0"><?= esc($total_students) ?></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= $tenantStringId ?>/instructor/students" class="text-decoration-none text-success fw-bold small">
                    Lihat Peserta <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                        <i class="fa-solid fa-database fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Bank Soal CBT</h6>
                <h3 class="fw-bold text-dark mb-0"><?= esc($total_banks ?? 0) ?></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= $tenantStringId ?>/instructor/quiz-banks" class="text-decoration-none text-warning fw-bold small">
                    Kelola Soal <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                        <i class="fa-solid fa-star-half-stroke fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Penilaian Siswa</h6>
                <h3 class="fw-bold text-dark mb-0"><i class="fa-solid fa-check"></i></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= $tenantStringId ?>/instructor/scoring" class="text-decoration-none text-info fw-bold small">
                    Buka Penilaian <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}
</style>

<?= $this->endSection() ?>

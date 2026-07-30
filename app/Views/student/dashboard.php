<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, var(--primary-navy) 0%, #1a2a40 100%);">
            <div class="card-body p-4 p-md-5 position-relative text-white">
                <div class="row align-items-center relative z-1">
                    <div class="col-md-8">
                        <span class="badge bg-white bg-opacity-25 text-white mb-2 px-3 py-2 rounded-pill fw-normal">Siswa Portal</span>
                        <h2 class="fw-bold mb-2">Halo, <?= session('name') ?> 👋</h2>
                        <p class="lead opacity-75 mb-4">Selamat datang di portal belajarmu. Ayo selesaikan materimu dan raih nilai terbaik!</p>
                        
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="/<?= session('current_tenant_string') ?>/student/courses" class="btn btn-light rounded-pill px-4 fw-bold text-navy shadow-sm">
                                <i class="fa-solid fa-book-open me-1"></i> Buka Kelasku
                            </a>
                            <a href="/<?= session('current_tenant_string') ?>/student/all-courses" class="btn btn-outline-light rounded-pill px-4 fw-bold shadow-sm">
                                <i class="fa-solid fa-compass me-1"></i> Eksplorasi
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block text-end">
                        <i class="fa-solid fa-user-graduate fa-8x text-white opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-chart-pie me-2 text-primary"></i> Ringkasan Belajar</h5>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="fa-solid fa-book fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Kelas Aktif</h6>
                <h3 class="fw-bold text-dark mb-0"><?= esc($activeCourses ?? 0) ?></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= session('current_tenant_string') ?>/student/courses" class="text-decoration-none text-primary fw-bold small">
                    Lanjutkan Belajar <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                        <i class="fa-solid fa-bullhorn fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Pengumuman</h6>
                <h3 class="fw-bold text-dark mb-0"><?= esc($totalAnnouncements ?? 0) ?></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= session('current_tenant_string') ?>/student/announcements" class="text-decoration-none text-warning fw-bold small">
                    Lihat Informasi <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="fa-solid fa-check-to-slot fa-lg"></i>
                    </div>
                </div>
                <h6 class="text-muted text-uppercase fw-bold small mb-1">Tugas / Ujian</h6>
                <h3 class="fw-bold text-dark mb-0"><i class="fa-solid fa-list-check"></i></h3>
            </div>
            <div class="card-footer bg-white border-top-0 pt-0 pb-4 px-4">
                <a href="/<?= session('current_tenant_string') ?>/student/courses" class="text-decoration-none text-success fw-bold small">
                    Cek di Kelas <i class="fa-solid fa-arrow-right ms-1"></i>
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

<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark"><i class="fa-solid fa-book-open me-2 text-primary"></i> Kelasku</h4>
    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/student/all-courses" class="btn btn-navy rounded-pill px-4">
        <i class="fa-solid fa-plus me-1"></i> Cari Kelas Lain
    </a>
</div>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <?php foreach($courses as $course): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold mb-0 text-dark"><?= esc($course->title) ?></h5>
                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1"><i class="fa-solid fa-check-circle me-1"></i>Terdaftar</span>
                </div>
                <p class="text-muted small mb-0 mt-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= esc($course->description) ?>
                </p>
            </div>
            <div class="card-footer bg-white border-top-0 pb-3 pt-0 text-end">
                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/student/course/<?= $course->id ?>" class="btn btn-outline-primary rounded-pill px-4 w-100">
                    Masuk Kelas <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($courses)): ?>
    <div class="col-12">
        <div class="text-center p-5 bg-white border rounded-3 shadow-sm">
            <i class="fa-solid fa-school-flag fa-3x text-muted mb-3"></i>
            <h5 class="text-dark fw-bold">Belum ada kelas terdaftar</h5>
            <p class="text-muted mb-4">Anda belum mengikuti kelas apapun. Silakan eksplorasi dan daftar kelas yang tersedia.</p>
            <a href="/<?= $tenant ?? session('current_tenant_string') ?>/student/all-courses" class="btn btn-navy rounded-pill px-4">
                Eksplorasi Kelas Sekarang
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

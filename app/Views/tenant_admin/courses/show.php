<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Detail Course</h5>
    <a href="/<?= esc($tenantStringId) ?>/admin_tenant/courses" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (!$course): ?>
    <div class="alert alert-danger shadow-sm border-0">
        <i class="fa-solid fa-circle-exclamation me-2"></i> Course tidak ditemukan.
    </div>
<?php else: ?>
    <div class="row g-4">
        <!-- Kolom Info Course -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold m-0 text-dark"><i class="fa-solid fa-book-open me-2 text-primary"></i> Informasi Course</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Judul Course</small>
                        <div class="fw-semibold fs-6 mt-1"><?= esc($course->title) ?></div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Deskripsi</small>
                        <div class="mt-1" style="font-size: 0.9rem; white-space: pre-line;"><?= esc($course->description) ?></div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Dibuat Pada</small>
                        <div class="mt-1" style="font-size: 0.9rem;"><?= date('d M Y, H:i', strtotime($course->created_at)) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Modul -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold m-0 text-dark"><i class="fa-solid fa-layer-group me-2 text-success"></i> Modul Pembelajaran</h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-muted" style="min-height: 250px;">
                    <i class="fa-solid fa-box-open fa-3x mb-3 text-light"></i>
                    <p class="mb-0">Fitur manajemen modul sedang dalam tahap pengembangan.</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

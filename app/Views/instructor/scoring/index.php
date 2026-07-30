<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0 text-dark"><i class="fa-solid fa-star-half-stroke me-2 text-primary"></i> Penilaian Kelas</h4>
</div>

<div class="row g-4">
    <?php foreach($courses as $course): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold mb-0 text-dark"><?= esc($course->title) ?></h5>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle mb-3">Course Scoring</span>
                <p class="text-muted small mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= esc($course->description) ?>
                </p>
            </div>
            <div class="card-footer bg-white border-top-0 pb-3 pt-0 text-end">
                <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/scoring/<?= $course->id ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Buka Tabel Nilai <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($courses)): ?>
    <div class="col-12">
        <div class="text-center p-5 bg-white border rounded-3 shadow-sm">
            <i class="fa-solid fa-book-open fa-3x text-muted mb-3"></i>
            <h5 class="text-dark fw-bold">Belum ada kelas</h5>
            <p class="text-muted mb-4">Anda belum membuat kelas untuk dinilai.</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

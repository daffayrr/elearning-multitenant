<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0 text-dark">
        <i class="fa-solid fa-file-pen me-2 text-primary"></i> Tugas Saya
    </h5>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body p-5 text-center">
        <div class="mb-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="fa-solid fa-file-invoice fa-2x text-primary"></i>
            </div>
        </div>
        <h4 class="fw-bold mb-2">Belum Ada Tugas</h4>
        <p class="text-muted mb-4">Saat ini belum ada tugas yang perlu Anda kerjakan atau kumpulkan.</p>
        <a href="/<?= esc($tenantStringId) ?>/student/courses" class="btn btn-primary rounded-pill px-4">
            <i class="fa-solid fa-book me-2"></i> Lihat Kelas Saya
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/courses" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Manajemen Kelas
    </a>
    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-3">
        <i class="fa-solid fa-eye fa-2x me-3"></i>
        <div>
            <h6 class="fw-bold mb-1">Mode Pratinjau Siswa (Student Preview)</h6>
            <p class="mb-0 small">Ini adalah tampilan yang akan dilihat oleh siswa saat mereka mengakses kelas ini.</p>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-3 bg-navy text-white" style="background-color: var(--primary-navy);">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-2 text-white"><?= esc($course->title) ?></h3>
            <p class="mb-0 opacity-75"><?= esc($course->description) ?></p>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Modules Section -->
    <div class="col-lg-6">
        <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-layer-group me-2 text-primary"></i> Modul & Materi</h5>

        <?php if(empty($modules)): ?>
            <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                <i class="fa-solid fa-folder-open fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0 small">Belum ada modul materi.</p>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-3">
                <div class="list-group list-group-flush rounded-3">
                    <?php foreach($modules as $module): ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-dark"><?= esc($module->title) ?></h6>
                            </div>
                            <p class="text-muted small mb-2"><?= esc($module->description) ?></p>
                            <?php if($module->file_url): ?>
                                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/download/s3?url=<?= urlencode($module->file_url) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3">
                                    <i class="fa-solid fa-download me-1"></i> Unduh Materi
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Assignments Section -->
    <div class="col-lg-6">
        <h5 class="fw-bold mb-3 text-dark"><i class="fa-solid fa-tasks me-2 text-warning"></i> Tugas & Kuis</h5>

        <?php if(empty($assignments)): ?>
            <div class="card border-0 shadow-sm rounded-3 text-center p-4">
                <i class="fa-solid fa-clipboard-check fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0 small">Belum ada tugas atau kuis.</p>
            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm rounded-3">
                <div class="list-group list-group-flush rounded-3">
                    <?php foreach($assignments as $assignment): ?>
                        <div class="list-group-item p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-dark"><?= esc($assignment->title) ?></h6>
                                <span class="badge <?= $assignment->type === 'quiz' ? 'bg-success' : 'bg-info' ?> bg-opacity-10 text-dark border">
                                    <?= ucfirst($assignment->type) ?>
                                </span>
                            </div>
                            <div class="text-danger small fw-bold mb-2"><i class="fa-regular fa-clock me-1"></i> Tenggat Waktu: <?= date('d M Y, H:i', strtotime($assignment->due_date)) ?></div>
                            <p class="text-muted small mb-2"><?= esc($assignment->description) ?></p>
                            <?php if($assignment->file_url): ?>
                                <a href="/<?= $tenant ?? session('current_tenant_string') ?>/download/s3?url=<?= urlencode($assignment->file_url) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3 mb-2">
                                    <i class="fa-solid fa-paperclip me-1"></i> Unduh Lampiran
                                </a>
                            <?php endif; ?>
                            
                            <div class="mt-2 pt-2 border-top">
                                <?php if($assignment->type === 'submission'): ?>
                                    <button class="btn btn-sm btn-primary w-100" disabled><i class="fa-solid fa-upload me-1"></i> Kumpulkan Tugas (Simulasi)</button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-success w-100" disabled><i class="fa-solid fa-play me-1"></i> Mulai Kuis (Simulasi)</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

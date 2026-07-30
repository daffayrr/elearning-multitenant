<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/student/courses" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Kelasku
    </a>
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
                                <span class="badge <?= in_array($assignment->type, ['quiz','cbt']) ? 'bg-success' : 'bg-info' ?> bg-opacity-10 text-dark border">
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
                                <?php $sub = $submissions[$assignment->id] ?? null; ?>
                                <?php if($sub): ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle"><i class="fa-solid fa-check me-1"></i> Selesai</span>
                                        <?php if($sub->score !== null): ?>
                                            <span class="fw-bold text-dark">Nilai: <span class="text-primary"><?= $sub->score ?></span>/100</span>
                                        <?php else: ?>
                                            <span class="text-muted small">Menunggu Dinilai</span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <?php if(in_array($assignment->type, ['submission', 'essay'])): ?>
                                        <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#submitModal<?= $assignment->id ?>"><i class="fa-solid fa-upload me-1"></i> Kumpulkan Tugas</button>
                                    <?php else: ?>
                                        <a href="/<?= $tenant ?? session('current_tenant_string') ?>/student/exams/start/<?= $assignment->id ?>" class="btn btn-sm btn-success w-100"><i class="fa-solid fa-play me-1"></i> Mulai Ujian</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($assignments)): ?>
    <?php foreach($assignments as $assignment): ?>
        <?php if(!isset($submissions[$assignment->id]) && in_array($assignment->type, ['submission', 'essay'])): ?>
            <!-- Submit Modal -->
            <div class="modal fade" id="submitModal<?= $assignment->id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="/<?= $tenant ?? session('current_tenant_string') ?>/student/assignments/<?= $assignment->id ?>/submit" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-bottom-0 pb-0">
                                <h5 class="modal-title fw-bold">Kumpulkan Tugas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-dark fw-semibold mb-3"><?= esc($assignment->title) ?></p>
                                <?php if($assignment->type === 'submission'): ?>
                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold small text-uppercase">Unggah File</label>
                                        <input type="file" name="submission_file" class="form-control" required>
                                        <small class="text-muted">Format yang didukung: PDF, DOCX, ZIP, dll.</small>
                                    </div>
                                <?php elseif($assignment->type === 'essay'): ?>
                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold small text-uppercase">Jawaban Essay</label>
                                        <textarea name="essay_answer" class="form-control" rows="5" required></textarea>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer border-top-0 pt-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4">Kirim Tugas</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>

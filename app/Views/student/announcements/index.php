<?= $this->extend('student/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h3 class="fw-bold mb-0">Pusat Informasi</h3>
    <p class="text-muted">Pembaruan dan pengumuman terbaru dari Admin dan Instruktur Anda.</p>
</div>

<?php if(empty($announcements)): ?>
    <div class="card border-0 shadow-sm rounded-4 text-center p-5">
        <i class="fa-solid fa-bell-slash fa-3x text-muted mb-3"></i>
        <h5 class="text-dark fw-bold">Belum ada informasi</h5>
        <p class="text-muted mb-0">Informasi dari Admin atau Instruktur akan muncul di sini.</p>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach($announcements as $a): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 h-100 <?= $a->author_role == 'tenant_admin' ? 'border-start border-4 border-warning' : 'border-start border-4 border-info' ?>">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="<?= $a->author_role == 'tenant_admin' ? 'bg-warning text-dark' : 'bg-info text-dark' ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fa-solid <?= $a->author_role == 'tenant_admin' ? 'fa-building' : 'fa-chalkboard-user' ?> fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-dark"><?= esc($a->title) ?></h5>
                                <div class="text-muted small">
                                    <i class="fa-regular fa-clock me-1"></i> <?= date('d M Y H:i', strtotime($a->created_at)) ?> 
                                    <span class="mx-1">&bull;</span>
                                    <i class="fa-regular fa-user me-1"></i> <?= esc($a->author_name ?? 'Admin') ?>
                                    <span class="mx-1">&bull;</span>
                                    <span class="badge <?= $a->author_role == 'tenant_admin' ? 'bg-warning' : 'bg-info' ?> bg-opacity-10 text-dark border">
                                        <?= $a->author_role == 'tenant_admin' ? 'Pengumuman Admin' : 'Pengumuman Instruktur' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-light p-3 rounded-3 mt-3">
                        <div class="text-dark lh-base" style="white-space: pre-line;">
                            <?= esc($a->content) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

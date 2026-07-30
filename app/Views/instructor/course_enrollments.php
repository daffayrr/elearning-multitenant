<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <a href="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/course/<?= $course->id ?>" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Detail Kelas
    </a>
    
    <div class="card border-0 shadow-sm rounded-3 bg-navy text-white" style="background-color: var(--primary-navy);">
        <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-1 text-white">Kelola Pendaftar: <?= esc($course->title) ?></h3>
                <p class="mb-0 opacity-75">Kelola siswa yang mendaftar ke kelas ini.</p>
            </div>
            <?php if($course->enrollment_key): ?>
            <div class="bg-white bg-opacity-10 rounded p-3 text-end border border-white border-opacity-25">
                <div class="small opacity-75 text-uppercase fw-bold mb-1">Kunci Pendaftaran (Enrollment Key)</div>
                <div class="fs-5 fw-bold text-warning font-monospace"><?= esc($course->enrollment_key) ?></div>
            </div>
            <?php else: ?>
            <div class="bg-white bg-opacity-10 rounded p-3 text-end border border-white border-opacity-25">
                <div class="small opacity-75 text-uppercase fw-bold mb-1">Status Kunci</div>
                <div class="fs-6 fw-bold text-white">Bebas Pendaftaran (Manual)</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3">Email</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center">Tanggal Daftar</th>
                        <th class="py-3 text-center px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($enrollments)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada siswa yang mendaftar di kelas ini.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach($enrollments as $enrollment): ?>
                        <tr>
                            <td class="px-4 fw-bold text-dark"><?= esc($enrollment->full_name) ?></td>
                            <td class="text-muted"><?= esc($enrollment->email) ?></td>
                            <td class="text-center">
                                <?php if($enrollment->status === 'approved'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">Disetujui</span>
                                <?php elseif($enrollment->status === 'pending'): ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-1 rounded-pill">Menunggu Approval</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-1 rounded-pill">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center text-muted small">
                                <?= $enrollment->created_at ? date('d M Y, H:i', strtotime($enrollment->created_at)) : '-' ?>
                            </td>
                            <td class="text-center px-4">
                                <?php if($enrollment->status === 'pending'): ?>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/enrollment/<?= $enrollment->id ?>/approve" method="POST">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" title="Setujui">
                                                <i class="fa-solid fa-check"></i> Terima
                                            </button>
                                        </form>
                                        <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/enrollment/<?= $enrollment->id ?>/reject" method="POST">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Tolak">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                <?php elseif($enrollment->status === 'approved'): ?>
                                    <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/enrollment/<?= $enrollment->id ?>/reject" method="POST" onsubmit="return confirm('Yakin ingin membatalkan/menolak siswa ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fa-solid fa-ban me-1"></i> Batalkan
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="/<?= $tenant ?? session('current_tenant_string') ?>/instructor/enrollment/<?= $enrollment->id ?>/approve" method="POST">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                            <i class="fa-solid fa-check me-1"></i> Pulihkan (Terima)
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

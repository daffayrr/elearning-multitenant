<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Daftar Course</h5>
    <a href="/<?= esc($tenantStringId) ?>/admin_tenant/courses/create" class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i> Tambah Course
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Judul Course</th>
                        <th class="py-3">ID Instruktur</th>
                        <th class="py-3">Dibuat Pada</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada data course.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                        <tr>
                            <td class="px-4 fw-semibold"><?= esc($course->title) ?></td>
                            <td><?= esc($course->instructor_id ?? '-') ?></td>
                            <td><?= esc($course->created_at ?? '-') ?></td>
                            <td class="text-end px-4">
                                <!-- Tenant Admin hanya boleh melihat detail umum, tidak boleh edit modul -->
                                <a href="/<?= esc($tenantStringId) ?>/admin_tenant/courses/<?= esc($course->id) ?>" class="btn btn-sm btn-outline-info">
                                    <i class="fa-solid fa-eye me-1"></i> Lihat
                                </a>
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

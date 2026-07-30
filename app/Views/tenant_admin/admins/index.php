<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Daftar Admin</h5>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">
        <i class="fa-solid fa-plus me-1"></i> Tambah Admin
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">Nama</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Username</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-end px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admins)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data admin.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td class="px-4 fw-semibold">
                                <?= esc($admin->full_name) ?>
                                <?php if ($admin->id == session()->get('user_id')): ?>
                                    <span class="badge bg-primary ms-1">Anda</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($admin->email) ?></td>
                            <td><?= esc($admin->username ?? '-') ?></td>
                            <td>
                                <?php if ($admin->is_blocked): ?>
                                    <span class="badge bg-danger">Diblokir</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end px-4">
                                <?php if ($admin->id != session()->get('user_id')): ?>
                                    <form action="/<?= esc($tenantStringId) ?>/admin_tenant/admins/delete/<?= $admin->id ?>" method="POST" class="d-inline form-confirm" data-message="Yakin ingin menghapus admin ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
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

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/<?= esc($tenantStringId) ?>/admin_tenant/admins/store" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

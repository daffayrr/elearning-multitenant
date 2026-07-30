<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <a href="/superadmin/tenants" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-semibold text-dark"><i class="fa-solid fa-circle-info me-2 text-info"></i> Informasi Tenant</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <small class="text-muted d-block">Nama Tenant</small>
                        <strong><?= esc($tenant->name) ?></strong>
                    </li>
                    <li class="list-group-item px-0">
                        <small class="text-muted d-block">URL Identifier</small>
                        <span class="font-monospace text-primary bg-light px-2 py-1 rounded small"><?= esc($tenant->tenant_string_id ?? $tenant->url_string ?? '-') ?></span>
                    </li>
                    <li class="list-group-item px-0">
                        <small class="text-muted d-block">Domain</small>
                        <?= $tenant->domain ? esc($tenant->domain) : '<span class="text-muted fst-italic">-</span>' ?>
                    </li>
                    <li class="list-group-item px-0">
                        <small class="text-muted d-block">Status</small>
                        <?php if ($tenant->status === 'active'): ?>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Diblokir</span>
                        <?php endif; ?>
                    </li>
                    <li class="list-group-item px-0 pb-0">
                        <small class="text-muted d-block">Tanggal Dibuat</small>
                        <?= date('d M Y, H:i', strtotime($tenant->created_at)) ?> WIB
                    </li>
                </ul>
            </div>
            <div class="card-footer bg-white py-3 text-center border-top">
                <form method="POST" action="/superadmin/tenants/<?= $tenant->id ?>/toggle" class="d-inline form-confirm" data-message="Yakin ubah status tenant ini?">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn w-100 <?= $tenant->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' ?>">
                        <i class="fa-solid <?= $tenant->status === 'active' ? 'fa-ban' : 'fa-check' ?> me-2"></i>
                        <?= $tenant->status === 'active' ? 'Blokir Tenant' : 'Aktifkan Tenant' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-dark"><i class="fa-solid fa-users me-2 text-primary"></i> Daftar Pengguna</h5>
                <span class="badge bg-primary rounded-pill"><?= count($users) ?> User</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-4">Nama Lengkap</th>
                                <th>Email</th>
                                <th>Peran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pengguna di tenant ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4 fw-medium"><?= esc($user->full_name) ?></td>
                                    <td><a href="mailto:<?= esc($user->email) ?>" class="text-decoration-none"><?= esc($user->email) ?></a></td>
                                    <td>
                                        <?php if ($user->role === 'tenant_admin'): ?>
                                            <span class="badge bg-info text-dark">Admin</span>
                                        <?php elseif ($user->role === 'instructor'): ?>
                                            <span class="badge bg-secondary">Instruktur</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark border">Murid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->is_blocked): ?>
                                            <span class="badge bg-danger">Diblokir</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Aktif</span>
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
    </div>
</div>
<?= $this->endSection() ?>

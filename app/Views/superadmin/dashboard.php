<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Stats Grid -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat border-left-primary h-100 p-3">
            <div class="card-body p-0">
                <h6 class="text-muted text-uppercase mb-2">Total Tenant</h6>
                <h2 class="text-primary mb-0 fw-bold"><?= esc($stats['total_tenants'] ?? 0) ?></h2>
                <i class="fa-solid fa-building icon-bg text-primary" style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.1;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat border-left-success h-100 p-3">
            <div class="card-body p-0">
                <h6 class="text-muted text-uppercase mb-2">Tenant Aktif</h6>
                <h2 class="text-success mb-0 fw-bold"><?= esc($stats['active_tenants'] ?? 0) ?></h2>
                <i class="fa-solid fa-circle-check icon-bg text-success" style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.1;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat border-left-info h-100 p-3">
            <div class="card-body p-0">
                <h6 class="text-muted text-uppercase mb-2">Total User</h6>
                <h2 class="text-info mb-0 fw-bold"><?= esc($stats['total_users'] ?? 0) ?></h2>
                <i class="fa-solid fa-users icon-bg text-info" style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.1;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat border-left-warning h-100 p-3">
            <div class="card-body p-0">
                <h6 class="text-muted text-uppercase mb-2">Total Course</h6>
                <h2 class="text-warning mb-0 fw-bold"><?= esc($stats['total_courses'] ?? 0) ?></h2>
                <i class="fa-solid fa-book-open icon-bg text-warning" style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.1;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row g-4">
    <!-- Table Column -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-dark"><i class="fa-solid fa-list me-2 text-muted"></i> Tenant Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-4">Nama Tenant</th>
                                <th>URL Identifier</th>
                                <th>Jumlah User</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tenants)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada tenant terdaftar.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tenants as $tenant): ?>
                                <tr>
                                    <td class="ps-4 fw-medium"><?= esc($tenant->name) ?></td>
                                    <td><span class="font-monospace text-primary bg-light px-2 py-1 rounded small"><?= esc($tenant->tenant_string_id ?? $tenant->url_string ?? '-') ?></span></td>
                                    <td><?= esc($userCounts[$tenant->id] ?? 0) ?></td>
                                    <td>
                                        <?php if ($tenant->status === 'active'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Diblokir</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?= date('d M Y', strtotime($tenant->created_at)) ?></td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-1">
                                            <a href="/superadmin/tenants/<?= $tenant->id ?>" class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <form method="POST" action="/superadmin/tenants/<?= $tenant->id ?>/toggle" class="d-inline form-confirm" data-message="Yakin ubah status tenant ini?">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm <?= $tenant->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' ?>" title="<?= $tenant->status === 'active' ? 'Blokir' : 'Aktifkan' ?>">
                                                    <i class="fa-solid <?= $tenant->status === 'active' ? 'fa-ban' : 'fa-check' ?>"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if (count($tenants) >= 10): ?>
            <div class="card-footer bg-white text-center py-3">
                <a href="/superadmin/tenants" class="text-primary text-decoration-none fw-medium">Lihat Semua Tenant <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column (Quick Actions) -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-semibold text-dark"><i class="fa-solid fa-bolt me-2 text-warning"></i> Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-quick w-100 text-start p-3 mb-2 shadow-sm text-decoration-none d-flex justify-content-between align-items-center rounded-3" data-bs-toggle="modal" data-bs-target="#createTenantModal">
                    <span><i class="fa-solid fa-plus-circle me-2"></i> Tambah Tenant Baru</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Create Tenant Modal -->
<div class="modal fade" id="createTenantModal" tabindex="-1" aria-labelledby="createTenantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="/superadmin/tenants/store" novalidate>
                <?= csrf_field() ?>
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="createTenantModalLabel"><i class="fa-solid fa-building-circle-check text-primary me-2"></i> Tambah Tenant Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-4">
                        Tenant baru akan langsung memiliki satu akun Tenant Admin yang bisa login.
                    </p>

                    <?php
                    $errors = session()->getFlashdata('errors') ?? [];
                    $old    = fn(string $key, string $default = '') => esc(old($key, $default));
                    $err    = fn(string $key) => isset($errors[$key])
                        ? '<div class="invalid-feedback d-block">' . esc($errors[$key]) . '</div>'
                        : '';
                    $inputCls = fn(string $key) => 'form-control ' . (isset($errors[$key]) ? 'is-invalid' : '');
                    ?>

                    <!-- Section: Data Tenant -->
                    <h6 class="text-primary text-uppercase fw-semibold mb-3 border-bottom pb-2">Informasi Tenant</h6>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Tenant <span class="text-danger">*</span></label>
                        <input type="text" name="tenant_name" value="<?= $old('tenant_name') ?>" placeholder="Contoh: Universitas Al-Ma'ata" class="<?= $inputCls('tenant_name') ?>">
                        <?= $err('tenant_name') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">URL Identifier <span class="text-danger">*</span></label>
                        <div class="input-group <?= isset($errors['url_string']) ? 'has-validation' : '' ?>">
                            <span class="input-group-text bg-light">lms.domain.com/</span>
                            <input type="text" name="url_string" value="<?= $old('url_string') ?>" placeholder="almaata_ac_id_tenant_id_3" class="<?= $inputCls('url_string') ?>">
                        </div>
                        <?= $err('url_string') ?>
                        <div class="form-text">Hanya huruf, angka, strip (-), dan underscore (_). Tidak bisa diubah setelah disimpan.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Domain Custom <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="url" name="domain" value="<?= $old('domain') ?>" placeholder="https://lms.universitascontoh.ac.id" class="<?= $inputCls('domain') ?>">
                        <?= $err('domain') ?>
                    </div>

                    <!-- Section: Data Tenant Admin -->
                    <h6 class="text-primary text-uppercase fw-semibold mb-3 border-bottom pb-2">Akun Tenant Admin Perdana</h6>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Admin <span class="text-danger">*</span></label>
                        <input type="text" name="admin_name" value="<?= $old('admin_name') ?>" placeholder="Contoh: Admin LMS Al-Ma'ata" class="<?= $inputCls('admin_name') ?>">
                        <?= $err('admin_name') ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Email Admin <span class="text-danger">*</span></label>
                        <input type="email" name="admin_email" value="<?= $old('admin_email') ?>" placeholder="admin@universitascontoh.ac.id" class="<?= $inputCls('admin_email') ?>">
                        <?= $err('admin_email') ?>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Password <span class="text-danger">*</span></label>
                            <input type="password" name="admin_password" placeholder="Min. 8 karakter" class="<?= $inputCls('admin_password') ?>">
                            <div class="form-text">Harus ada huruf besar, kecil, dan angka.</div>
                            <?= $err('admin_password') ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="admin_password_confirm" placeholder="Ulangi password" class="<?= $inputCls('admin_password_confirm') ?>">
                            <?= $err('admin_password_confirm') ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Tenant</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-open modal jika ada error validasi atau flash error lainnya yang terkait form
        <?php if(session()->has('errors') || session()->has('error')): ?>
            var createTenantModal = new bootstrap.Modal(document.getElementById('createTenantModal'));
            createTenantModal.show();
        <?php endif; ?>

        // Auto-generate URL identifier
        const nameInput = document.querySelector('#createTenantModal input[name="tenant_name"]');
        const urlInput = document.querySelector('#createTenantModal input[name="url_string"]');
        if(nameInput && urlInput) {
            let urlTouched = urlInput.value.length > 0;
            urlInput.addEventListener('input', () => { urlTouched = true; });

            nameInput.addEventListener('input', function () {
                if (urlTouched) return;
                urlInput.value = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s_-]/g, '')
                    .replace(/\s+/g, '_')
                    .replace(/_+/g, '_')
                    .substring(0, 100);
            });
        }
    });
</script>
<?= $this->endSection() ?>
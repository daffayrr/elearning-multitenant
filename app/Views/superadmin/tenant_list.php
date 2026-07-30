<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold text-dark"><i class="fa-solid fa-building me-2 text-primary"></i> Daftar Tenant</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTenantModal">
            <i class="fa-solid fa-plus-circle me-1"></i> Tambah Tenant Baru
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th class="ps-4">Nama Tenant</th>
                        <th>URL Identifier</th>
                        <th>Domain</th>
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
                            <td><?= $tenant->domain ? esc($tenant->domain) : '<span class="text-muted fst-italic">-</span>' ?></td>
                            <td>
                                <?php if ($tenant->status === 'active'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">Diblokir</span>
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
    <div class="card-footer bg-white py-3">
        <!-- Ensure CodeIgniter Pager displays correctly -->
        <?php if (isset($pager) && $pager) :?>
            <?= $pager->links('default', 'default_full') ?>
        <?php endif ?>
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

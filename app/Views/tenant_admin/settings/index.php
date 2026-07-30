<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h5 class="fw-bold mb-0">Pengaturan Institusi</h5>
    <p class="text-muted small">Kelola informasi dasar dan konfigurasi domain institusi Anda.</p>
</div>

<div class="card shadow-sm border-0" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="/<?= esc($tenantStringId) ?>/admin_tenant/settings" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <label class="form-label fw-semibold">Nama Institusi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-building text-muted"></i></span>
                    <input type="text" name="name" class="form-control" value="<?= esc($tenant->name ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Domain Custom <span class="text-muted fw-normal">(Opsional)</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-globe text-muted"></i></span>
                    <input type="url" name="domain" class="form-control" value="<?= esc($tenant->domain ?? '') ?>" placeholder="https://lms.institusi.com">
                </div>
                <div class="form-text">Biarkan kosong jika Anda hanya menggunakan URL Identifier bawaan.</div>
            </div>

            <button type="submit" class="btn btn-primary fw-bold px-4">
                <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

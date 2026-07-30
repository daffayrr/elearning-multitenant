<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Buat Course Baru</h5>
    <a href="/<?= esc($tenantStringId) ?>/admin_tenant/courses" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="/<?= esc($tenantStringId) ?>/admin_tenant/courses" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Course <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Pemrograman Web Lanjut">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Deskripsikan secara singkat course ini..."></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Pilih Instruktur <span class="text-danger">*</span></label>
                <select name="instructor_id" class="form-select" required>
                    <option value="">-- Pilih Instruktur --</option>
                    <option value="1">Instruktur Placeholder</option>
                    <!-- Dinamis akan diambil dari controller di iterasi selanjutnya -->
                </select>
                <div class="form-text">Pilih instruktur yang akan mengelola modul dari course ini.</div>
            </div>

            <button type="submit" class="btn btn-primary fw-bold px-4">
                <i class="fa-solid fa-save me-1"></i> Simpan Course
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

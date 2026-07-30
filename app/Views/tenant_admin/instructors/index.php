<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0">Daftar Instruktur</h5>
    <div class="btn-group">
        <a href="/<?= esc($tenantStringId) ?>/admin_tenant/instructors/download-template" class="btn btn-outline-secondary">
            <i class="fa-solid fa-download me-1"></i> Download Template
        </a>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fa-solid fa-file-excel me-1"></i> Import Excel
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">
            <i class="fa-solid fa-plus me-1"></i> Tambah Data
        </button>
    </div>
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
                    <?php if (empty($instructors)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data instruktur.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($instructors as $inst): ?>
                        <tr>
                            <td class="px-4 fw-semibold"><?= esc($inst->full_name) ?></td>
                            <td><?= esc($inst->email) ?></td>
                            <td><?= esc($inst->username ?? '-') ?></td>
                            <td>
                                <?php if ($inst->is_blocked): ?>
                                    <span class="badge bg-danger">Diblokir</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end px-4">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-btn" 
                                    data-id="<?= $inst->id ?>"
                                    data-fullname="<?= esc($inst->full_name) ?>"
                                    data-username="<?= esc($inst->username) ?>"
                                    data-email="<?= esc($inst->email) ?>"
                                    data-status="<?= $inst->is_blocked ?>"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form action="/<?= esc($tenantStringId) ?>/admin_tenant/instructors/<?= $inst->id ?>/delete" method="POST" class="d-inline form-confirm" data-message="Yakin ingin menghapus instruktur ini? Data tidak dapat dikembalikan.">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/<?= esc($tenantStringId) ?>/admin_tenant/instructors/import" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Import Instruktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/<?= esc($tenantStringId) ?>/admin_tenant/instructors" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Instruktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form fields here -->
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
<!-- Modal Edit Form -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Instruktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="full_name" id="edit_full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_blocked" id="edit_status" class="form-select">
                            <option value="0">Aktif</option>
                            <option value="1">Diblokir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtns = document.querySelectorAll('.edit-btn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const fullName = this.getAttribute('data-fullname');
                const username = this.getAttribute('data-username');
                const email = this.getAttribute('data-email');
                const status = this.getAttribute('data-status');
                
                document.getElementById('editForm').action = "/<?= esc($tenantStringId) ?>/admin_tenant/instructors/" + id + "/update";
                document.getElementById('edit_full_name').value = fullName;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_status').value = status;
            });
        });
    });
</script>
<?= $this->endSection() ?>

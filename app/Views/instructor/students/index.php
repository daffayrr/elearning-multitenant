<?= $this->extend('instructor/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-users me-2 text-primary"></i> Manajemen Peserta</h5>
    <div class="btn-group shadow-sm">
        <a href="/<?= esc($tenantStringId) ?>/instructor/students/download-template" class="btn btn-outline-secondary">
            <i class="fa-solid fa-download me-1"></i> Download Template
        </a>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fa-solid fa-file-excel me-1"></i> Import Excel
        </button>
        <button type="button" class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#formModal">
            <i class="fa-solid fa-plus me-1"></i> Tambah Data
        </button>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4">
        <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3">
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
                    <?php if (empty($students)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data siswa.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="px-4 fw-semibold text-dark"><?= esc($student->full_name) ?></td>
                            <td><?= esc($student->email) ?></td>
                            <td><?= esc($student->username ?? '-') ?></td>
                            <td>
                                <?php if ($student->is_blocked): ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle">Diblokir</span>
                                <?php else: ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle">Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end px-4">
                                <button type="button" class="btn btn-sm btn-outline-primary edit-btn rounded-pill px-3" 
                                    data-id="<?= $student->id ?>"
                                    data-fullname="<?= esc($student->full_name) ?>"
                                    data-username="<?= esc($student->username) ?>"
                                    data-email="<?= esc($student->email) ?>"
                                    data-status="<?= $student->is_blocked ?>"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal">
                                    <i class="fa-solid fa-pen me-1"></i> Edit
                                </button>
                                <?php if ($student->is_blocked): ?>
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 action-btn" 
                                        data-action="/<?= esc($tenantStringId) ?>/instructor/students/<?= $student->id ?>/unblock"
                                        data-message="Yakin ingin membuka blokir siswa ini?">
                                        <i class="fa-solid fa-unlock me-1"></i> Unblock
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 action-btn" 
                                        data-action="/<?= esc($tenantStringId) ?>/instructor/students/<?= $student->id ?>/block"
                                        data-message="Yakin ingin memblokir siswa ini?">
                                        <i class="fa-solid fa-ban me-1"></i> Block
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 action-btn" 
                                    data-action="/<?= esc($tenantStringId) ?>/instructor/students/<?= $student->id ?>/delete"
                                    data-message="Yakin ingin menghapus siswa ini secara permanen?">
                                    <i class="fa-solid fa-trash me-1"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Confirmation -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form id="confirmForm" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content border-0 shadow text-center p-3">
                <div class="modal-body">
                    <i class="fa-solid fa-triangle-exclamation fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold text-dark">Konfirmasi</h5>
                    <p class="text-muted mb-4" id="confirmMessage">Yakin ingin melanjutkan?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Ya, Lanjutkan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/<?= esc($tenantStringId) ?>/instructor/students/import" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Import Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">File Excel</label>
                        <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/<?= esc($tenantStringId) ?>/instructor/students" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-navy px-4">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Edit Form -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editForm" method="POST">
            <?= csrf_field() ?>
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Nama Lengkap</label>
                        <input type="text" name="full_name" id="edit_full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Password <small class="text-danger fw-normal text-lowercase">(Kosongkan jika tidak ingin diubah)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold small text-uppercase">Status</label>
                        <select name="is_blocked" id="edit_status" class="form-select">
                            <option value="0">Aktif</option>
                            <option value="1">Diblokir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-navy px-4">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

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
                
                document.getElementById('editForm').action = "/<?= esc($tenantStringId) ?>/instructor/students/" + id + "/update";
                document.getElementById('edit_full_name').value = fullName;
                document.getElementById('edit_username').value = username;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_status').value = status;
            });
        });

        const actionBtns = document.querySelectorAll('.action-btn');
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        actionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const message = this.getAttribute('data-message');
                
                document.getElementById('confirmForm').action = action;
                document.getElementById('confirmMessage').innerText = message;
                confirmModal.show();
            });
        });
    });
</script>
<?= $this->endSection() ?>
